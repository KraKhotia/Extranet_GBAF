<?php

$host = 'localhost';
$dbname = 'extranet';
$username = 'root';
$password = '';

try
    {
        $bdd = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8', $username, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch(Exception $e)
    {
            die('Erreur : '.$e->getMessage());
    }

?>