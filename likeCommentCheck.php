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

$commentID = $_GET["commentID"];
$currentUserID = $_SESSION['id'];

$reqAlreadyLiked = $pdo->prepare('select * from likesRepostsComments where userID = ? AND commentID = ? AND liked = ?;');
$reqAlreadyLiked->execute([$currentUserID, $commentID, TRUE]);
$isPostLikedByCurrentUser = $reqAlreadyLiked->fetch(); 

if($currentUserID){
    if($isPostLikedByCurrentUser){
        $reqUnlike = $pdo->prepare('UPDATE likesRepostsComments
        SET liked = FALSE WHERE userID = ? AND commentID = ?;');
        $reqUnlike->execute([$currentUserID, $commentID]);
    }
    else{
        $reqPostInLikesReposts = $pdo->prepare('select * from likesRepostsComments where userID = ? AND commentID = ?;');
        $reqPostInLikesReposts->execute([$currentUserID, $commentID]);
        $isPostAlreadyThere = $reqPostInLikesReposts->fetch();

        if($isPostAlreadyThere){
            $reqLikeAgain = $pdo->prepare('UPDATE likesRepostsComments
            SET liked = TRUE WHERE userID = ? AND commentID = ?;');
            $reqLikeAgain->execute([$currentUserID, $commentID]);
        }
        else{
            $reqLike = $pdo->prepare('INSERT INTO likesRepostsComments (userID, commentID, liked) VALUES (?,?,?);');
            $reqLike->execute([$currentUserID, $commentID, TRUE]);
        }
    }
    header('location: '.$_SERVER['HTTP_REFERER']);
}
else{
    ?><p>Veuillez vous connecter pour pouvoir aimer des commentaires. <a href="login.php">Se connecter</a></p><?php
}