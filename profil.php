<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Z - Profil</title>
    <link rel="icon" type="image/x-icon" href="ressources/siteLogo.svg">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
</head>
<body>
    <?php
    include_once "pdo.php";
    include_once "components/boutonProfil.php";
    $userid = $_GET["uid"];
    $currentUserID = $_SESSION['id'];

    $reqUsers = $pdo->prepare('select * from user where id = ?;');
    $reqUsers->execute([$userid]);
    $user = $reqUsers->fetchAll(); 

    ?>
    <p>Nom d'utilisateur : <?= $user[0]["username"] ?></p>
    <p>Inscrit depuit le : <?= $user[0]["joined"] ?></p>
    <p>Liste de posts :</p>
    <div id="listePosts" style="display:flex; flex-direction:column-reverse;">
        <?php
        include_once "pdo.php";
        $req = $pdo->prepare('select * from post where userID = ?;');
        $req->execute([$userid]);
        $allPosts = $req->fetchAll();
        foreach($allPosts as $post){
            $reqUsers = $pdo->prepare('select * from user where id = ?;');
            $reqUsers->execute([$userid]);
            $user = $reqUsers->fetchAll(); 

            $reqLikes = $pdo->prepare('select * from likesReposts where postID = ? AND liked = ?');
            $reqLikes->execute([$post['id'], TRUE]);
            $postLiked = $reqLikes->fetchAll();
    
            $numberOfLike = count($postLiked);
        ?>
        <div onclick="location.href='post.php?postid=<?= $post['id'] ?>'" class="post">
            <div class="imgUtilisateur">
                <img src="<?= $user[0]['image'] ?>" alt="" class="dropdownLink">
            </div>
            <div class="postNonImgContainer">
                <b class="usernamePost"><a href="profil.php?uid=<?= $user[0]['id']; ?>"><?= $user[0]['username'] ?></a></b>
                <p class="textPost"><?= $post['text'] ?></p>
                <div class="likeReposts">
                    <div class="likes">
                        <button class="likeRepostButton">
                            <a href="likeCheck.php?postID=<?= $post['id']; ?>">
                            <svg class="repostLikesImgs" width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 9.1371C2 14 6.01943 16.5914 8.96173 18.9109C10 19.7294 11 20.5 12 20.5C13 20.5 14 19.7294 15.0383 18.9109C17.9806 16.5914 22 14 22 9.1371C22 4.27416 16.4998 0.825464 12 5.50063C7.50016 0.825464 2 4.27416 2 9.1371Z" 
                                <?php 
                                    $reqLiked = $pdo->prepare('select * from likesReposts where userID = ? AND postID = ? AND liked = ?;');
                                    $reqLiked->execute([$currentUserID, $post['id'], TRUE]);
                                    $isPostLikedByCurrentUser = $reqLiked->fetch();

                                    if($isPostLikedByCurrentUser){
                                        ?> fill="#8b0000" <?php
                                    }
                                    else{
                                        ?> fill="#1C274C" <?php
                                    }
                                ?>
                                />
                            </svg>
                            </a>
                        </button>
                        <p><?= $numberOfLike ?></p>
                    </div>
                    <div class="reposts">
                        <button><img class="repostLikesImgs" src="ressources/refresh-svgrepo-com.svg" alt=""></button>
                        <p></p>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>