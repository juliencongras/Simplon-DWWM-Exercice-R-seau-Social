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
    <?php include_once "components/boutonProfil.php";
    include_once "pdo.php";
    $currentUserID = $_SESSION['id'];
    $postid = $_GET["postid"];

    $req = $pdo->prepare('select * from post where id = ?;');
    $req->execute([$postid]);
    $currentPost = $req->fetch();

    $reqUser = $pdo->prepare('select * from user where id = ?;');
    $reqUser->execute([$currentPost['userID']]);
    $postUser = $reqUser->fetch();

    $reqComments = $pdo->prepare('select * from comments where postID = ?;');
    $reqComments->execute([$postid]);
    $postComments = $reqComments->fetchAll();

    $reqLikes = $pdo->prepare('select * from likesReposts where postID = ? AND liked = ?');
    $reqLikes->execute([$currentPost['id'], TRUE]);
    $postLiked = $reqLikes->fetchAll();

    $numberOfLike = count($postLiked);
    
    ?>
    <div class="post">
        <div class="imgUtilisateur">
            <img src="<?= $postUser['image'] ?>" alt="" class="dropdownLink">
        </div>
        <div class="postNonImgContainer">
            <b class="usernamePost"><a href="profil.php?uid=<?= $postUser['id']; ?>"><?= $postUser['username'] ?></a></b>
            <p class="textPost"><?= $currentPost['text'] ?></p>
            <div class="likeReposts">
                <div class="likes">
                    <button class="likeRepostButton">
                        <a href="likeCheck.php?postID=<?= $currentPost['id']; ?>">
                        <svg class="repostLikesImgs" width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 9.1371C2 14 6.01943 16.5914 8.96173 18.9109C10 19.7294 11 20.5 12 20.5C13 20.5 14 19.7294 15.0383 18.9109C17.9806 16.5914 22 14 22 9.1371C22 4.27416 16.4998 0.825464 12 5.50063C7.50016 0.825464 2 4.27416 2 9.1371Z" 
                            <?php 
                                $reqLiked = $pdo->prepare('select * from likesReposts where userID = ? AND postID = ? AND liked = ?;');
                                $reqLiked->execute([$currentUserID, $currentPost['id'], TRUE]);
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
    <form action="commentCheck.php" method="post" id="creerPost">
        <textarea required="true" maxlength="255" name="contenuComment" id="" cols="30" rows="5"></textarea>
        <input type="hidden" value="<?= $currentUserID ?>" name="userID">
        <input type="hidden" value="<?= $currentPost['id'] ?>" name="postID">
        <button id="buttonCreerPost">Commenter</button>
    </form>
    <p>Commentaires</p>

    <div id="listePosts" style="display:flex; flex-direction:column-reverse;">
        <?php
        foreach($postComments as $comment){
            $reqUsers = $pdo->prepare('select * from user where id = ?;');
            $reqUsers->execute([$comment['userID']]);
            $user = $reqUsers->fetchAll();

            $reqCommentLikes = $pdo->prepare('select * from likesRepostsComments where commentID = ? AND liked = ?');
            $reqCommentLikes->execute([$comment['id'], TRUE]);
            $commentLiked = $reqCommentLikes->fetchAll();

            $numberOfCommentLiked = count($commentLiked);
        ?>
        <div class="post">
            <div class="imgUtilisateur">
                <img src="<?= $user[0]['image'] ?>" alt="" class="dropdownLink">
            </div>
            <div class="postNonImgContainer">
                <b class="usernamePost"><a href="profil.php?uid=<?= $user[0]['id']; ?>"><?= $user[0]['username'] ?></a></b>
                <p class="textPost"><?= $comment['text'] ?></p>
                <div class="likeReposts">
                    <div class="likes">
                        <button class="likeRepostButton">
                            <a href="likeCommentCheck.php?commentID=<?= $comment['id']; ?>">
                            <svg class="repostLikesImgs" width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 9.1371C2 14 6.01943 16.5914 8.96173 18.9109C10 19.7294 11 20.5 12 20.5C13 20.5 14 19.7294 15.0383 18.9109C17.9806 16.5914 22 14 22 9.1371C22 4.27416 16.4998 0.825464 12 5.50063C7.50016 0.825464 2 4.27416 2 9.1371Z" 
                                
                                <?php 
                                $reqCommentsLiked = $pdo->prepare('select * from likesRepostsComments where userID = ? AND commentID = ? AND liked = ?;');
                                $reqCommentsLiked->execute([$comment['userID'], $comment['id'], TRUE]);
                                $isCommentLikedByCurrentUser = $reqCommentsLiked->fetch();

                                if($isCommentLikedByCurrentUser){
                                    ?> fill="#8b0000" <?php
                                }
                                else{
                                    ?> fill="#1C274C" <?php
                                }
                                ?>

                                fill="#1C274C"/>
                            </svg>
                            </a>
                        </button>
                        <p><?= $numberOfCommentLiked ?></p>
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