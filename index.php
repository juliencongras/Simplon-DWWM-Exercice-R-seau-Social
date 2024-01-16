<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Z - Réseau Social</title>
    <link rel="icon" type="image/x-icon" href="ressources/siteLogo.svg">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
</head>
<body>
    <?php session_start(); ?>
    <?php include_once("components/boutonProfil.php") ?>
    <form action="postCheck.php" method="post" id="creerPost">
        <textarea required="true" maxlength="255" name="contenuPost" id="" cols="30" rows="5"></textarea>
        <input type="hidden" value="<?= $_SESSION['id'] ?>" name="userID">
        <button id="buttonCreerPost">Créer post</button>
    </form>
    <?php include_once("components/allPosts.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>