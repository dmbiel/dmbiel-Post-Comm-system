<?php
session_start();
require_once '../utils/connection.php';
require_once '../src/User.php';
$user = User::loadUserById($conn, $_SESSION['user_id']);
session_destroy();
//$user->logout();
$conn->close();
$conn = NULL;
header('Location: login.php');
