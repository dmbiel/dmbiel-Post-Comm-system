<?php
require_once('connections.php');
require_once('User.php');

$users= User::loadAllUsers();
var_dump($users);

$conn ->close();
$conn=null;
?>
