<?php


class LoginController extends Controller {
  
  public $permission;
  public $restaurant_id;
  public $errors = [];

  public function default_action() {

    if (isset($_SESSION["user"]) && !empty($_SESSION["user"])) {
      header("Location: " . M_URL . "dashboard");
      exit();
    }else {
      $template = new Template("login", 2);// 2 to include login page without header and footer
      $template->view("login.php");
    }

  }

  public static function check_data($username) {
    $errors = [];
    $not_allowed_chars = ["@","!","#","$","%","^","&","*","(",")","=","+",".",">","/","\\",'<'];
    $trigger = false;
    foreach($not_allowed_chars as $char) {
      if (str_contains($username, $char)) {
        $trigger = true;
      }
    }
    if ($trigger) {
      $errors["username"][] = "username is not valid!";
    }
    if (strlen($username) > 28) {
      $errors["username"][] = "username is too long (max is 28 character)!";
    }
    
    if (count($errors) > 0) {
      return [false, $errors];
    }else {
      return [true, []];
    }

  }

  public static function login($username, $password) {// $db = DB Connection Object

    $errors = self::check_data($username);
    if ($errors[0]) {
      
      $db = DBC::get_instance();
      
      $sql = $db->dbh->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
      $sql->execute([$username, sha1($password)]);

      if ($sql->rowCount() > 0) {
        $data = $sql->fetchObject("User");
        $_SESSION["user"] = $data;
        header("Location: " . M_URL . "dashboard");
      }else {
        $errors[1]["undefined"] = "username or password is wrong";
        $_SESSION["errors"] = $errors[1];
        $_SESSION["login_username"] = $username;
        header("Location: " .  M_URL . "login");
      }
      
    }else {
      $_SESSION["errors"] = $errors[1];
      $_SESSION["login_username"] = $username;
      header("Location: " .  M_URL . "login");
    }
    exit();
  }

}

?>