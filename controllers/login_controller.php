<?php


class LoginController extends Controller {
  
  public $permission;
  public $restaurant_id;
  public $errors = [];

  public function __construct(public $username = null, public $password = null) {
    
    if (!isset($username) || empty($username)) {
      $errors["username"][] = "No 'username' Passed!";
    }else {
      $this->username = $username;
    }

    if (!isset($password) || empty($password)) {
      $errors["password"][] = "No 'password' Passed!";
    }else {
      $this->password = sha1($password);
    }

  }

  public function default_action() {

    $template = new Template("login", 2);// 2 to include login page without header and footer
    $template->view("login.php");
    
  }

  public function check_data() {
    if (!preg_match("/[A-z_0-9-\s]/", $this->username)) {
      $this->errors["username"][] = "username is not valid!";
    }
    if (strlen($this->username) > 28) {
      $this->errors["username"][] = "username is too long (max is 28 character)!";
    }

    return count($this->errors) > 0 ? false: true;

  }

  public function login() {// $db = DB Connection Object

    if ($this->check_data()) {
      
      $db = DBC::get_instance();
      
      $sql = $db->dbh->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
      $sql->execute([$this->username, $this->password]);

      if ($sql->rowCount() > 0) {
        $data = $sql->fetchObject("User");
        $_SESSION["user"] = $data;
        header("Location: " . M_URL . "dashboard");
        exit();
      }else {
        $this->errors["undifind"] = "username or password is wrong";
        $_SESSION["errors"] = $this->errors;
        header("Location: " .  M_URL . "login");
        exit();
      }
    
    }else {
      echo $this->username . "  ||  ";
      foreach($this->errors as $error) {
        foreach($error as $er) {
          echo $er . "<br><hr><br>";
        }
      }
      exit();
    }
    exit();
  }

}

?>