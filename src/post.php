<?php
class post {

    private $id;
    private $userId;
    private $username;
    private $text;
    private $creationDate;

    public function __construct() {
        $this->id = -1;
        $this->userId = 0;
        $this->text = "";
        $this->creationDate = '';
    }
    public function getId() {
        return $this->id;
    }
    public function getuserId() {
        return $this->userId;
    }
    public function getUsername() {
        return $this->username;
    }
    public function getText() {
        return $this->text;
    }
    public function getCreationDate() {
        return $this->creationDate;
    }
    public function setUserId($userId) {
        if (is_int($userId)) {
            $this->userId = $userId;
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function setText($text) {
        if (is_string($text)) {
            $this->text = $text;
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }

    static public function addNewpost(mysqli $connection, $userID, $post) {
        $query = "INSERT INTO posts (user_id, post, send_datetime) VALUES ($userID, '" . $post . "', NOW())";
        $connection->query($query);
        return;
    }

    static public function loadpostById(mysqli $connection, $id) {
        $sql = "SELECT * FROM posts WHERE id=" . $id;
        $result = $connection->query($sql);
        if (($result == TRUE) && ($result->num_rows == 1)) {
            $row = $result->fetch_assoc();
            $loadedpost = new post();
            $loadedpost->id = $row['id'];
            $loadedpost->userId = $row['user_id'];
            $loadedpost->text = $row['text'];
            $loadedpost->creationDate = $row['creation_date'];
            return $loadedpost;
        }
        return NULL;
    }

    static public function loadAllpostsByUserId(mysqli $connection, $userId) {

        $allposts = [];
        $query = "SELECT t.*, u.username FROM posts t JOIN Users u ON t.user_id=u.id WHERE t.user_id=$userId ORDER BY t.creation_date DESC";
        $result = $connection->query($query);
        if ($result == FALSE) {
            return false;
        }

        foreach ($result as $row) {
            $row = $result->fetch_assoc();
            $loadedpost = new post();
            $loadedpost->id = $row['id'];
            $loadedpost->userId = $row['user_id'];
            $loadedpost->text = $row['text'];
            $loadedpost->creationDate = $row['creation_date'];
            $loadedpost->username = $row['username'];

            $allposts[] = $loadedpost;
        }
        return $allposts;
    }

    static public function loadAllposts(mysqli $connection) {

        $allposts = [];
        $query = "SELECT t.*, u.username FROM posts t JOIN Users u ON t.user_id=u.id ORDER BY t.creation_date DESC";
        $result = $connection->query($query);
        if ($result == FALSE) {
            return false;
        }

        foreach ($result as $row) {
            $row = $result->fetch_assoc();
            $loadedpost = new post();
            $loadedpost->id = $row['id'];
            $loadedpost->userId = $row['user_id'];
            $loadedpost->text = $row['text'];
            $loadedpost->creationDate = $row['creation_date'];
            $loadedpost->username = $row['username'];

            $allposts[] = $loadedpost;
        }

        return $allposts;

    }

    static public function getNoOfComments(mysqli $connection,$postId) {
        $query = "SELECT COUNT(*) AS comments_number FROM Comments WHERE post_id=$postId";
        $result = $connection->query($query);
        if ($result->num_rows != 0) {
            $noOfComments = $result->fetch_assoc();
            return $noOfComments['comments_number'];
        } else {
            return 0;
        }
    }

    public function saveToDB(mysqli $connection) {
        if ($this->id == -1) {
            $sql = "INSERT INTO posts (user_id, text, creation_date) VALUES ($this->userId, '$this->text', '$this->creationDate')";
            $result = $connection->query($sql);
            if ($result) {
                $this->id = $connection->insert_id;
                return TRUE;
            }
        }
        return false;
    }
}
