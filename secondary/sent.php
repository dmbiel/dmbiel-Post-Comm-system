<?php
session_start();
require_once '../style/header.html';
require_once '../style/navbar.html';
require_once '../style/messages_navbar.html';
require_once '../src/Message.php';
require_once '../utils/connection.php';
?>

<div class="container">
    <div class="row">
        <?php
            require_once '../style/messages_navbar.html';
        ?>
        <div class="col-md-10">
            <?php
                if (($_SERVER['REQUEST_METHOD'] == 'GET') && (isset($_GET['id']))) {
                    $result = Message::getMessageById($conn, $_GET['id']);
                    echo "<div class='panel panel-default'>";
                    echo "<div class='panel-heading'><span class='text-muted'>Title: </span>" . $result->getTitle() . " <span class='text-muted'> || </span><span class='text-muted'>Recipient: </span>" . $result->getRecipientname() . "</div>";
                    echo "<div class='panel-body'>" . $result->getMessage() . "</div>";
                    echo "<div class='panel-footer'><span class='text-muted'>at </span><small>" . $result->getSendDatetime() . "</small></div>";
                    echo "</div>";
                }
            ?>
        </div>
    </div>
</div>

<?php
require_once '../style/footer.html';
