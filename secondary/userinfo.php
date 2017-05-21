<?php
    session_start();
    require_once '../utils/check_login.php';
    require_once '../utils/connection.php';
    require_once '../src/post.php';
    require_once '../src/User.php';
    require_once '../style/header.html';
    require_once '../style/navbar.html';

    if (($_SERVER['REQUEST_METHOD'] == 'GET') && (isset($_GET['user_id']))) {
        $userId = (int)$_GET['user_id'];
        if (is_int($userId)) {
            $user = User::loadUserById($conn, $userId);
            echo "<div class='panel panel-default'>";
            echo "<div class='panel-heading'></div>";
            echo "<div class='panel-body'>";
            echo "<p><span style='color: #777; font-weight: bold'>Username:</span> " . $user->getUsername() . "</p>";
            echo "<p><span style='color: #777; font-weight: bold'>E-mail:</span> " . $user->getEmail() . "</p>";
            if ($userId != $_SESSION['user_id']) {
                echo "<a href='send.php?to=" . $user->getUsername() . "'><button class='btn btn-default'>Send message</button></a>";
            }
            echo "</div>";
            echo "<div class='panel-footer'></div>";
            echo "</div>";
        }
    } else {
        header('Location: ../index.php');
    }
    require_once '../style/footer.html';
