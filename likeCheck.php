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
session_start();

include_once "pdo.php";

$postid = $_GET["postID"];
$currentUserID = $_SESSION['id'];

$reqAlreadyLiked = $pdo->prepare('select * from likesReposts where userID = ? AND postID = ? AND liked = ?;');
$reqAlreadyLiked->execute([$currentUserID, $postid, TRUE]);
$isPostLikedByCurrentUser = $reqAlreadyLiked->fetch(); 

if($currentUserID){
    if($isPostLikedByCurrentUser){
        $reqUnlike = $pdo->prepare('UPDATE likesReposts
        SET liked = FALSE WHERE userID = ? AND postID = ?;');
        $reqUnlike->execute([$currentUserID, $postid]);
    }
    else{
        $reqPostInLikesReposts = $pdo->prepare('select * from likesReposts where userID = ? AND postID = ?;');
        $reqPostInLikesReposts->execute([$currentUserID, $postid]);
        $isPostAlreadyThere = $reqPostInLikesReposts->fetch();

        if($isPostAlreadyThere){
            $reqLikeAgain = $pdo->prepare('UPDATE likesReposts
            SET liked = TRUE WHERE userID = ? AND postID = ?;');
            $reqLikeAgain->execute([$currentUserID, $postid]);
        }
        else{
            $reqLike = $pdo->prepare('INSERT INTO likesReposts (userID, postID, liked) VALUES (?,?,?);');
            $reqLike->execute([$currentUserID, $postid, TRUE]);
        }
    }
    header('location: '.$_SERVER['HTTP_REFERER']);
}
else{
    ?><p>Veuillez vous connecter pour pouvoir aimer des posts. <a href="login.php">Se connecter</a></p><?php
}