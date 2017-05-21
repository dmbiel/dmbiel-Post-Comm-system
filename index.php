<?php
    session_start();

    require_once 'utils/check_login.php';
    require_once 'utils/connection.php';
    require_once 'src/post.php';
    require_once 'style/header.html';
    require_once 'style/navbar.html';
    require_once 'style/post.html';

    unset($_SESSION['bad_input']);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (preg_match('/^[a-z0-9 .\-]+$/i', $_POST['post'])) {
            $newpost = new post();
            $newpost->setUserId((int)$_SESSION['user_id']);
            $newpost->setText($_POST['post']);
            $newpost->setCreationDate(date('Y-m-d H:i:s'));
            $newpost->saveToDB($conn);
        } else {
            $_SESSION['bad_input'] = "<p class='text-danger'>You can type only alphanumeric, spaces, period and dashes</p>";
        }
    }
    if (isset($_SESSION['bad_input'])) {
        echo "<div>" . $_SESSION['bad_input'] . "</div>";
    }
    foreach (post::loadAllposts($conn) as $post) {
        echo "<div class='panel panel-default'>";
        echo "<div class='panel-heading'><a href='secondary/userinfo.php?user_id=" . $post->getuserId() . "'>" . $post->getUsername() . "</a> <span class='text-muted'>wrote:</span></div>";
        echo "<a href='secondary/post.php?post_id=" . $post->getId() . "'><div class='panel-body'>" . $post->getText() . "</div></a>";
        echo "<div class='panel-footer'><span class='text-muted'>at </span><small>" . $post->getCreationDate() . "</small></div>";
        echo "</div>";
    }
    require_once 'style/footer.html';

?>
