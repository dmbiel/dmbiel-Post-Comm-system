<?php
    session_start();
    require_once '../utils/check_login.php';
    require_once '../utils/connection.php';
    require_once '../src/post.php';
    require_once '../src/User.php';
    require_once '../src/Comment.php';

    require_once '../style/header.html';
    require_once '../style/navbar.html';

    unset($_SESSION['bad_input']);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (preg_match('/^[a-z0-9 .\-]+$/i', $_POST['comment'])) {

            $newComment = new Comment();
            $newComment->setText($_POST['comment']);
            $newComment->setpostId($_SESSION['post_id']);
            $newComment->setUserId((int)$_SESSION['user_id']);
            $newComment->setCreationDate(date('Y-m-d H:i:s'));
            $newComment->saveToDB($conn);
            header('Location: post.php?post_id=' . $_SESSION['post_id']);
            unset($_SESSION['post_id']);
            exit();

        } else {

            $_SESSION['bad_input'] = "<p class='text-danger'>You can type only alphanumeric, spaces, period and dashes</p>";

        }

    }

    if (($_SERVER['REQUEST_METHOD'] == 'GET') && (isset($_GET['post_id']))) {

        $_SESSION['post_id'] = (int)$_GET['post_id'];

        if (is_int($_SESSION['post_id'])) {

            $post = post::loadpostById($conn, $_SESSION['post_id']);
            $userpost = User::loadUserById($conn, $post->getuserId());
            $comments = Comment::loadAllCommentsByPostId($conn, $_SESSION['post_id']);

            echo "<div class='panel panel-default'>";
            echo "<div class='panel-heading'><a href='userinfo.php?user_id=" . $post->getuserId() . "'>" . $userpost->getUsername() . "</a> <span class='text-muted'>wrote:</span></div>";
            echo "<div class='panel-body'>" . $post->getText() . "</div>";
            echo "<div class='panel-footer'><span class='text-muted'>at </span><small>" . $post->getCreationDate() . "</small></div>";
            echo "</div>";

            require_once '../style/comment.html';

            if (isset($_SESSION['bad_input'])) {

                echo "<div>" . $_SESSION['bad_input'] . "</div>";

            }

            if ($comments != null) {

                foreach ($comments as $row) {

                $userComment = User::loadUserById($conn, $row->getUserId());

                echo "<div style='border: 1px solid #ddd; border-radius: 3px; padding: 10px; margin-bottom: 5px;'>";
                echo "<a href='userinfo.php?user_id=" . $userComment->getId() . "'>" . $userComment->getUsername() . "</a> <span style='color: #777'>commented:</span><br>";
                echo $row->getText();
                echo "</div>";

                }

            }

        }

    } else {

        header('Location: ../index.php');

    }
    require_once '../style/footer.html';
