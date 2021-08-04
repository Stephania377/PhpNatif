<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ./login.php");
}
if(isset($_POST['deconnexion'])){
  session_destroy();

}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Sniffons  le site</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
    </head>
    
    <body>
        <form method="post"> <input type="submit" value="Double cliquez ici pour se déconnecter" name="deconnexion"/> </form>
         <h1>Listes des urls</h1>
         <form method="post">
                <input type="text" placeholder="Ex: https://www.votresite.com" name="url" />
                <input type="submit" value="Afficher la liste des urls" /> <br/><br/>
        </form>
        
        <?php
       
        createDb();
        createTables();
        if(isset($_POST['url']) && ($_POST['url']!="")){
             sniffer($_POST['url']);
        }

            function createDb(){
                    $servername = 'localhost';
                    $username = 'root';
                    $password = '';
                    
                    try{
                        $dbco = new PDO("mysql:host=$servername", $username, $password);
                        $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sql2 = "CREATE DATABASE IF NOT EXISTS Sniff";
                        $dbco->exec($sql2);
                    }
                    catch(PDOException $e){
                      echo "Erreur : " . $e->getMessage();
                    }
            }

            function createTables(){ 
                include ('connect.php');                        
                    $sql = "CREATE TABLE IF NOT EXISTS Utilisateurs(
                        Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        Email VARCHAR(30) NOT NULL,
                        Motdepasse VARCHAR(30) NOT NULL,
                        DateInscription TIMESTAMP,
                        UNIQUE(Email))";
                    $sql2 = "CREATE TABLE IF NOT EXISTS Urls(
                            Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                            Urls text NOT NULL
                            )";
                       
                    $dbco->exec($sql);
                    $dbco->exec($sql2);
                   
            }

             function sniffer($urlavoir){
                if (preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:.[A-Z0-9][A-Z0-9_-]*)+):?(d+)?\/?/i', $urlavoir)) {

                $fichier=file_get_contents($urlavoir);//lit la page à copier
                $ex=preg_split("#(https?://[a-z0-9-_./?&%:;=]+)#i",$fichier,null,PREG_SPLIT_DELIM_CAPTURE);
                $liensdelapage="";
                $lesLiens=array();
                foreach($ex as $liens){
                    if(preg_match("#^http#i",$liens)){
                        if(!in_array($liens,$lesLiens)){//si on la pas déjà mis dans le txt, on l'enregistre
                            $liensdelapage.=$liens."\n";
                            $lesLiens[]=$liens;//pour ne pas l'enregistrer une deuxième fois
                        }
                    }
                }
                file_put_contents("liens.txt",$liensdelapage);//sauvegarde les liens dans le fichier liens.txt
                $fichier = file("liens.txt");
                $total = count($fichier);
                
            ?>
                <table>
                       <tr>
                           <th>ID</th>
                           <th>URL</th>
                       </tr>
                <?php
                    $servername = 'localhost';
                    $username = 'root';
                    $password = '';
                    include ('connect.php');   
                            $sql = "TRUNCATE TABLE Urls";
                            $insertion = $dbco->prepare("INSERT INTO Urls(Urls) VALUES(?);"); 
                            $dbco->exec($sql);
                                foreach ($fichier as $line_num => $line) {
                                    $insertion->execute(array($line));
                            
                                }
                            $select=$dbco->query("SELECT * FROM Urls; "); 
                            while ($row = $select->fetch()) {
                                $i=1;
                                echo "<tr> <td>" .$row["Id"]. " </td> <td>" .$row["Urls"]. "</td></tr>";
                                $i++;
                            }
            } 
            else {
                echo "Veuillez entrez un lien valide s'il  vous plaît";
            }
                    
        }
         ?>
        </table>

    </body>
</html>