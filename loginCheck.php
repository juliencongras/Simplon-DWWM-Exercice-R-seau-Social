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
$name = $_POST['username'];
$password = $_POST['password'];

include_once "pdo.php";
include_once "debug.php";

$req = $pdo->prepare('select * from user where username = ?;');
$req->execute([$name]);
$loginCheck = $req->fetch(); 
    
if($loginCheck){
    $hashPass = $loginCheck["password"];
    if(password_verify($password, $hashPass)){
        session_start();
    
        $_SESSION['user'] = $loginCheck["username"];
        $_SESSION['id'] = $loginCheck["id"];

        header('location: index.php');
    }
}
else{
    ?><p>Mauvais identifiants. <a href="login.php">Retour</a></p><?php
}