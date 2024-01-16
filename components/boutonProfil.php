<?php session_start();
include_once "pdo.php";
$reqUserProfilHam = $pdo->prepare('select * from user where id = ?;');
$reqUserProfilHam->execute([$_SESSION['id']]);
$currentUserProfilHam = $reqUserProfilHam->fetch();
?>

<div id="boutonProfilBurg" class="dropdown">
    <img 
    <?php
        if($_SESSION){
            ?>src="<?= $currentUserProfilHam['image'] ?>"<?php
        }
        else{
            ?>src="ressources/siteLogo.svg"<?php
        };?>
        alt="" class="dropdownLink" class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">

    <ul class="dropdown-menu">
        <li><a href="index.php" class="dropdown-item" type="button">Accueil</a></li>
        <?php if($_SESSION) { ?>
        <li><a href="profil.php?uid=<?= $_SESSION['id']; ?>" class="dropdown-item" type="button">Profil</a></li>
        <li><a href="disconect.php" class="dropdown-item" type="button">Déconnection</a></li>
        <?php }
        else{ ?>
        <li><a href="login.php" class="dropdown-item" type="button">Connection</a></li>
        <li><a href="register.php" class="dropdown-item" type="button">Inscription</a></li>
        <?php } ?>
    </ul>        
</div>