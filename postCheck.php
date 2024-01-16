<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Z - Réseau Social</title>
    <link rel="icon" type="image/x-icon" href="ressources/siteLogo.svg">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
</head>
<?php
include_once "debug.php";
session_start();

$userID = $_POST['userID'];
$postContenu = $_POST['contenuPost'];

if($_SESSION){ 

include_once "pdo.php";
$req = $pdo->prepare('INSERT INTO post (text, userID) VALUES (?,?);');
$req->execute([$postContenu, $userID]);

header('location: index.php');    

}

else{
    
    ?><p>Veuillez vous inscrire pour commencer à poster. <a href="register.php">Inscription</a></p><?php

}