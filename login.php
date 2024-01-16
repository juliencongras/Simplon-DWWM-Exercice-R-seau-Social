<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Z - Connection</title>
    <link rel="icon" type="image/x-icon" href="ressources/siteLogo.svg">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
</head>
<body>
    <?php session_start() ?>
    <?php include_once("components/boutonProfil.php") ?>
    <form action="loginCheck.php" class="loginForm" method="post">
        <div class="mb-3">
          <label for="inputUtilisateur" class="form-label">Utilisateur</label>
          <input name="username" type="text" class="form-control" id="inputUtilisateur">
        </div>
        <div class="mb-3">
          <label for="inputPassword" class="form-label">Mot de passe</label>
          <input name="password" type="password" class="form-control" id="inputPassword">
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
    <a href="register.php">Inscription</a>
    <?php include_once("components/allPosts.php") ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>