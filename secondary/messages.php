<?php
session_start();
require_once '../style/header.html';
require_once '../style/navbar.html';
require_once '../src/message.php';
require_once '../utils/connection.php';
?>

<div class="container">
    <div class="row">
        <?php
            require_once '../style/messages_navbar.html';
        ?>
        <div class="col-md-10">
            <table class="table table-hover">
                <thead>
                    <tr class="text-muted">
                        <th>Title</th>
                        <th>Message</th>
                        <th>Sender</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (Message::getAllMessages($conn, $_SESSION['user_id']) != NULL) {

                            foreach (Message::getAllMessages($conn, $_SESSION['user_id']) as $row) {
                                $shortMessage = (strlen($row->getMessage()) > 30) ? substr($row->getMessage(), 0, 29) . "..." : $row->getMessage();
                                echo "<tr>";
                                echo "<td><a href='message.php?id=" . $row->getId() . "&status=1'>" . $row->getTitle() . "</a></td>";
                                echo "<td>" . $shortMessage . "</td>";
                                echo "<td class='text-muted'>" . $row->getSendername() . " </td>";
                                echo "<td class='text-muted'>" . $row->getSendDatetime() . " </td>";
                                echo "<td>";
                                    if ($row->getStatus() == 0) {
                                        echo "<span class='glyphicon glyphicon-envelope' style='color: #777'></span>";
                                    } else {
                                        echo "<span class='glyphicon glyphicon-check' style='color: #777'></span>";
                                    }
                                echo "</td>";
                                echo "</tr>";
                            }

                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
require_once '../style/footer.html';
