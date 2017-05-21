<?php
require_once('connections.php');
require_once('User.php');

$user= User::loadUserByID($conn, 3);
var_dump($user1);

if ($user1->delete($conn)) {
  echo "Usuneto uzytkownika";
} else {
  echo "Nie usunieto uzytkownika";
}

//$user1->saveToDB();

$conn ->close();
$conn=null;
?>
