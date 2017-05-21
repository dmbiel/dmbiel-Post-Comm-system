<?php
require_once('connections.php');
require_once('User.php');

$user1= User::loadUserByID($conn, 1);
var_dump($user1);

$user1-setUsername("Nowe Imie");
$user1->saveToDB($conn);

$conn ->close();
$conn=null;
?>
