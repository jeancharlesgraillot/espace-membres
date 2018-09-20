<?php

try
{
  $bdd = new PDO('mysql:host=localhost;dbname=espace_membres;charset=utf8', 'root', 'Strawberry591peaches', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

?>
