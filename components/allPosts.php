<div id="listePosts" style="display:flex; flex-direction:column-reverse;">
    <?php
    include_once "pdo.php";
    $currentUserID = $_SESSION['id'];

    $req = $pdo->query('select * from post;');
    $allPosts = $req->fetchAll();

    foreach($allPosts as $post){
        $reqUsers = $pdo->prepare('select * from user where id = ?;');
        $reqUsers->execute([$post['userID']]);
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