<?php
$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASSWORD = "coderslab";
$DB_DBNAME = "Warsztat";

$conn= new mysqli($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_DBNAME);
if($conn->connect_error) {
  die("Polaczenie neudanie. Blad:" .
  $conn->connect_error);
}
