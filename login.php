<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Se  connecter</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
    </head>
    
    <body>
      <h1>Se connecter</h1>
           <form method="post">
                Email <input type="email" name="email" /> </br> </br>
                 Mot de  passe<input type="password" name="mdp" /> </br> </br>
                <input type="submit" value="Se connecter" name="login">
                <p>Vous  n'avez pas encore de compte? <a href="./register.php">Inscrivez-vous!</a></p>
           </form>
          <?php
            if(isset($_POST['login'])){
                login($_POST['email'], $_POST['mdp']);
            }

                function login($email, $mdp){
                    include ('connect.php');
                    
                    $select = $dbco->prepare("SELECT * FROM Utilisateurs WHERE Email=?; "); 
                    $select->execute(array($email));
                    $user = $select->fetch();
            
                    if(isset($user['Motdepasse']) && $user['Motdepasse']==$mdp){
                      $_SESSION['id']=$user['Id'];
                      header("Location: ./index.php");
                    }
                     else{
                          echo "Email ou mot  de passe invalide";
                     }
                    
                }
          ?>
         

</body>
</html>