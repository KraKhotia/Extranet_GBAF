<?php
    include("bdd.php");
    
    session_start();
    // Effectuer ici la requête qui insère le message
    $req = $bdd->prepare('INSERT INTO post(ID_acteur, ID_user, date_add, post) VALUES(?, ?, NOW(), ?)');
    $req->execute(array($_POST['ID_acteur'],$_POST['prenom'],$_POST['post']));
    // Puis rediriger vers commentaires.php 

    header('Location: commentaires.php?acteur=' . $_POST['ID_acteur'] . '');
?>