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
$username = $_POST['username'];
$mail = $_POST['mail'];
$passwordOriginal = $_POST['password'];
$passwordVerification = $_POST['passwordVerification'];
$joined = date('Y-m-d');

if($passwordOriginal != $passwordVerification){ ?>
    <p>Erreur, les mots de passe ne sont pas identique. 
        <a href="register.php">Retour à l'inscription</a>
    </p>
<?php }

else{
    include_once "pdo.php";
    include_once "debug.php";
    $req = $pdo->prepare('select * from user where username = ?;');
    $req->execute([$username]);
    $UserExistCheck = $req->fetch();

    if($UserExistCheck){
        ?><p>Ce nom d'utilisateur existe déjà, veuillez en choisir un autre. 
            <a href="register.php">Retour à l'inscription</a>
            </p><?php
    }
    else{
        $password = password_hash($passwordOriginal, PASSWORD_DEFAULT);
        
        if($_FILES['image']['size'] == 0){
            $image = "ressources/siteLogo.svg";
        }

        else{
            $file_nameimg = $_FILES['image']['name'];
            $file_tmpimg = $_FILES['image']['tmp_name'];
            $file=pathinfo($file_nameimg);
            $i = 1;
            $filename=$file['filename'];

            while(file_exists("ressources/userImages/".$filename.".".$file['extension'])){
                $filename=$file['filename']." ($i)";
                $i++;
            }

            $image = "ressources/userImages/".$filename.".".$file['extension'];
            move_uploaded_file($file_tmpimg,"ressources/userImages/".$filename.".".$file['extension']);
        }

        $req1 = $pdo->prepare('INSERT INTO user (username, password, mail, image, joined) VALUES (?,?,?,?,?);');
        $req1->execute([$username, $password, $mail, $image, $joined]);
        
        $req2 = $pdo->prepare('select * from user where username = ? AND password = ?;');
        $req2->execute([$username, $password]);
        $loginCheck = $req2->fetchAll(); 
        
        session_start();
        
        $_SESSION['user'] = $loginCheck[0]["username"];
        $_SESSION['id'] = $loginCheck[0]["id"];
        
        header('location: index.php');
    }
}

?>