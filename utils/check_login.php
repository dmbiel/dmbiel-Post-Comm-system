<?php
if (! isset($_SESSION['user_id'])) {
    header("location: ./secondary/login.php");
}
