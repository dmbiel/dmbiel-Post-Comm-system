<?php
class Comment {

    private $id;
    private $userId;
    private $postId;
    private $creationDate;
    private $text;

    public function __construct() {

        $this->id = -1;
        $this->userId = 0;
        $this->postId = 0;
        $this->creationDate = '';
        $this->text = "";

    }
    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getpostId() {
        return $this->postId;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    public function getText() {
        return $this->text;
    }

    private function validId($id) {

        if ((is_int($id)) && ($id > 0)) {
            return TRUE;
        } else {
            return FALSE;
        }

    }
    public function setId($id) {

        if ($this->validId($id)) {
            $this->id = $id;
            return TRUE;
        } else {
            return FALSE;
        }

    }
    public function setUserId($userId) {

        if ($this->validId($userId)) {
            $this->userId = $userId;
            return TRUE;
        } else {
            return FALSE;
        }

    }

    public function setpostId($postId) {

        if ($this->validId($postId)) {
            $this->postId = $postId;
            return TRUE;
        } else {
            return FALSE;
        }

    }

    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }

    public function setText($text) {
        if (is_string($text)) {
            $this->text = $text;
            return TRUE;
        } else {
            return FALSE;
        }
    }

    static public function loadCommentById(mysqli $connection, $commentId) {

        if (self::validId($commentId)) {

            $query = "SELECT * FROM Comments WHERE id=$commentId";
            $result = $connection->query($query);

            if (($result == TRUE) && ($result->num_rows == 1)) {

                $row = $result->fetch_assoc();

                $loadedComment = new Comment();
                $loadedComment->setId((int)$row['id']);
                $loadedComment->setpostId((int)$row['post_id']);
                $loadedComment->setUserId((int)$row['user_id']);
                $loadedComment->setText($row['text']);
                $loadedComment->setCreationDate($row['creation_date']);

                return $loadedComment;

            }
            return NULL;

        } else {
            return FALSE;
        }

    }

    static public function loadAllCommentsByPostId(mysqli $connection, $postId) {

        if (self::validId($postId)) {

            $query = "SELECT * FROM Comments WHERE post_id=$postId ORDER BY creation_date DESC";
            $result = $connection->query($query);

            if ($result->num_rows != 0) {

                $comments = [];

                foreach ($result as $row) {

                    $loadedComment = new Comment();
                    $loadedComment->setId((int)$row['id']);
                    $loadedComment->setpostId((int)$row['post_id']);
                    $loadedComment->setUserId((int)$row['user_id']);
                    $loadedComment->setText($row['text']);
                    $loadedComment->setCreationDate($row['creation_date']);

                    array_push($comments, $loadedComment);
                }

                return $comments;
            }
            return NULL;

        } else {

            return FALSE;

        }

    }

    public function saveToDB(mysqli $connection) {

        if ($this->id == -1) {
            $sql = "INSERT INTO Comments (text, post_id, user_id, creation_date) VALUES "
                    . "('$this->text', $this->postId, $this->userId, '$this->creationDate')";
            $result = $connection->query($sql);
            if ($result) {
                $this->id = $connection->insert_id;
                return TRUE;
            }
        }

        return FALSE;

    }

}
