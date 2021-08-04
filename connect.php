<?php

 	$servername = 'localhost';
    $username = 'root';
    $password = '';
                    
        try{
                $dbco = new PDO("mysql:host=$servername;dbname=Sniff", $username, $password);
                $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e){
           		echo "Erreur : " . $e->getMessage();
        }

?>