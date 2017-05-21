<?php
require_once('connections.php');
require_once('User.php');

$user1= new User();

$user1->setEmail("email@email.pl");
$user1->setUsername("Jan Kowalski");
$user1->setHashedPassword("TajneMiasto");

$user1->savetoDB($conn);

$conn ->close();
$conn=null;
?>
