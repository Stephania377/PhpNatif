<!DOCTYPE html>
<html>
    <head>
        <title>S'inscrire</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
    </head>
    
    <body>
        <h1>Inscrivez-vous!</h1>
           <form method="post">
                Email <input type="email" name="email" /> </br> </br>
                 Mot de  passe<input type="password" name="mdp" /> </br> </br>
                <input type="submit" value="Se connecter" name="register">
           </form>
        <?php
        
            if(isset($_POST['register'])){
                if(isset($_POST['email']) && $_POST['email']!="" && isset($_POST['mdp']) && $_POST['mdp']!=""){
                    insertUser($_POST['email'],$_POST['mdp']);
                }
               
            }
            
            function insertUser($email, $mdp){ 
                include ('connect.php');
                    $insertion = $dbco->prepare("INSERT INTO Utilisateurs(Email,Motdepasse) VALUES(?,?); "); 
                    $insertion->execute(array($email,$mdp));
                    echo 'Inscription effectué avec succès, ! <a href="./login.php">Connectez-vous  maintenant</a>';   
            }


        
        ?>
         

</body>
</html>