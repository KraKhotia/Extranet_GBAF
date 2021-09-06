<?php
    include("database/bdd.php");
    
    session_start();
    // Effectuer ici la requête qui insère le message
    $req = $bdd->prepare('INSERT INTO post(ID_actor, auteur, date_creation, commentaire) VALUES(?, ?, NOW(), ?)');
    $req->execute(array($_POST['ID_actor'],$_POST['prenom'],$_POST['commentaire']));
    // Puis rediriger vers commentaires.php 

    header('Location: commentaires.php?acteur=' . $_POST['ID_actor'] . '');
?>