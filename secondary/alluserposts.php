<?php
session_start();
require_once '../utils/check_login.php';

require_once '../style/header.html';
require_once '../style/navbar.html';
require_once '../src/post.php';
require_once '../utils/connection.php';
?>

<div class="container">
    <div class="row">
        <?php
            require_once '../style/account_navbar.html';
        ?>
        <div class="col-md-10">
            <?php

                $userId = (int)$_SESSION['user_id'];

                foreach (post::loadAllpostsByUserId($conn, $userId) as $post) {
                    echo "<a href='mypost.php?post_id=" . $post->getId() . "'><div class='panel panel-default'>";
                    echo "<div class='panel-body'>" . $post->getText() . "</div></a>";
                    echo "<div class='panel-footer' style='color: #777'>Comments: " . post::getNoOfComments($conn, $post->getId()) . "</div>";
                    echo "</div>";
                }

            ?>
        </div>
    </div>
</div>

<?php
require_once '../style/footer.html';
