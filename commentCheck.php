<?php
include_once "debug.php";
session_start();

$userID = $_POST['userID'];
$postContenu = $_POST['contenuComment'];
$postID = $_POST['postID'];

if($_SESSION){ 

include_once "pdo.php";
$req = $pdo->prepare('INSERT INTO comments (text, userID, postID) VALUES (?,?,?);');
$req->execute([$postContenu, $userID, $postID]);

header('location: post.php?postid='.$postID);    

}

else{
    
    ?><p>Veuillez vous inscrire pour commenter. <a href="register.php">Inscription</a></p><?php

}