<?php
class User{
    private $id;
    private $username;
    private $hashedPassword;
    private $email;

    public function __construct()
{
    $this->id = -1;
    $this->username = "";
    $this->hashedPassword = "";
    $this->email = "";
}

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setHashedPassword($newPassword)
    {
        $this->hashedPassword=password_hash($newPassword,PASSWORD_BCRYPT);
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function saveToDB(mysqli $connection){
        if($this->id== -1){
            $sql = "INSERT INTO Users (email,username,hashed_password) VALUES "
            . "('$this->email','$this->username','$this->hashedPassword')";
         $result = $connection->query($sql);
         if($result == true){
             $this->id = $connection->insert_id;
             return true;
         }
        }
        return false;
  }
  public function delete (mysqli $connection) {
    if($this-> id !=-1)  {
      $sql="DELETE FROM Users WHERE id=$this->id";
      $result= $connection->query($sql);
      if($result == true) {
        $this->id=1;
        return true;
      } else {
        return false;
  }
}
}
  public function login() {
    $_SESSION['user_id'] = $this->id;
  }

  static public function loadUserById(mysqli $connection, $id)
   {
       $sql = "SELECT * FROM Users WHERE id=$id";
       $result = $connection->query($sql);
       if ($result == true && $result->num_rows == 1) {
           $row = $result->fetch_assoc();
           $loadedUser = new User();
           $loadedUser->id = $row['id'];
           $loadedUser->username = $row['username'];
           $loadedUser->hashedPassword = $row['hashed_password'];
           $loadedUser->email = $row['email'];
           return $loadedUser;
       }
       return null;

   }
   static public function loadAllUsers(mysqli $connection){
       $sql = "SELECT * FROM Users";
       $ret = [];

       $result = $connection->query($sql);
       if($result == true && $result->num_rows != 0){
           foreach($result as $row){
           $loadedUser = new User();
           $loadedUser->id = $row['id'];
           $loadedUser->username = $row['username'];
           $loadedUser->hashedPassword = $row['hashed_password'];
           $loadedUser->email = $row['email'];

       $ret[] = $loadedUser;
           }
       }
return $ret;
   }
   public function saveToDB(mysqli $connection){
if($this->id == -1){
  $sql="ISERT INTO Users (email,username,hashed_password) VALUES ($this->email,)"
}
else{
$sql = "UPDATE Users SET username='$this->username',
email='$this->email',
hashed_password='$this->hashedPassword'
WHERE id=$this->id";
$result = $connection->query($sql);
if($result == true){
return true;
}
}
return false;
}
public function delete(mysqli $connection){
if($this->id != -1){
$sql = "DELETE FROM Users WHERE id=$this->id";
$result = $connection->query($sql);
if($result == true){
$this->id = -1;
return true;
}
return false;
}
return true;
}
