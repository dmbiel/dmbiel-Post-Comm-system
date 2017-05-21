<?php
session_start();
require_once '../utils/check_login.php';

require_once '../style/header.html';
require_once '../style/navbar.html';
require_once '../src/post.php';
require_once '../src/comment.php';
require_once '../src/User.php';
require_once '../utils/connection.php';
?>

<div class="container">
    <div class="row">
        <?php
            require_once '../style/account_navbar.html';
        ?>
        <div class="col-md-10">
            <?php
                $postId = (int)$_GET['post_id'];
                $mypost = post::loadpostById($conn, $postId);

                echo "<div class='panel panel-default'>";
                echo "<div class='panel-body'>" . $mypost->getText() . "</div>";
                echo "<div class='panel-footer'><span class='text-muted'>at </span><small>" . $mypost->getCreationDate() . "</small></div>";
                echo "</div>";

                $comments = Comment::loadAllCommentsByPostId($conn, $postId);

                if ($comments != null) {

                    foreach ($comments as $row) {

                    $userComment = User::loadUserById($conn, $row->getUserId());

                    echo "<div style='border: 1px solid #ddd; border-radius: 3px; padding: 10px; margin-bottom: 5px;'>";
                    echo "<a href='userinfo.php?user_id=" . $userComment->getId() . "'>" . $userComment->getUsername() . "</a> <span style='color: #777'>commented:</span><br>";
                    echo $row->getText();
                    echo "</div>";

                    }

                }

            ?>
        </div>
    </div>
</div>

<?php
require_once '../style/footer.html';
