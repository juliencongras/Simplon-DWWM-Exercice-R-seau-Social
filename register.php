<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Z - Inscription</title>
    <link rel="icon" type="image/x-icon" href="ressources/siteLogo.svg">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include_once("components/boutonProfil.php") ?>
    <form enctype="multipart/form-data" action="registerConfirmation.php" method="post">
        <div class="mb-3">
          <label for="inputUtilisateur" class="form-label">Nom d'utilisateur</label>
          <input type="text" name="username" class="form-control" id="inputUtilisateur">
        </div>
        <div class="mb-3">
            <label for="inputMail" class="form-label">Mail</label>
            <input type="email" name="mail" class="form-control" id="inputMail">
          </div>
        <div class="mb-3">
          <label for="inputPassword" class="form-label">Mot de passe</label>
          <input type="password" name="password" class="form-control" id="inputPassword">
        </div>
        <div class="mb-3">
            <label for="inputConfirmPassword" class="form-label">Confirmation mot de passe</label>
            <input type="password" name="passwordVerification" class="form-control" id="inputConfirmPassword">
        </div>
        <div class="mb-3">
            <label for="inputImage" class="form-label">Image de profil</label>
            <input type="file" name="image" class="form-control" id="inputImage">
        </div>
        <button type="submit" class="btn btn-primary">Inscription</button>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>