<?php
$host = "localhost";
$user = "root";
$pass = "coderslab";
$db = "Warsztat";

$conn= new mysqli($host,$user,$pass,$db);
if($conn->connect_error) {
  die("Polaczenie neudanie. Blad:" .
  $conn->connect_error);
}
?>
