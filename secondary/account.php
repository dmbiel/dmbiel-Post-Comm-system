<?php
session_start();
require_once '../utils/check_login.php';
require_once '../style/header.html';
require_once '../style/navbar.html';
?>

<div class="container">
    <div class="row">
        <?php
            require_once '../style/account_navbar.html';
        ?>
        <div class="col-md-10">
            Information about user(need to add editing.)
        </div>
    </div>
</div>

<?php
require_once '../style/footer.html';
