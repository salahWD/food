<?php


class LoginController extends Controller {

  public $permission;
  public $restaurant_id;
  public $errors = [];

  public function default_action() {
    global $restaurant;
    if (isset($_SESSION["admin"]) && !empty($_SESSION["admin"])) {
      header("Location: " . Router::route($restaurant->url_name . "/dashboard"));
      exit();
    }else {
      $template = new Template();
      $template->view("login", 2, ["restaurant" => $restaurant]);
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

  public function login_action($username, $password) {// $db = DB Connection Object

    global $restaurant;

    $errors = self::check_data($username);
    if ($errors[0]) {

      $db = DBC::get_instance();

      $sql = $db->dbh->prepare("SELECT * FROM users WHERE username = ? AND password = ? LIMIT 1");
      $sql->execute([$username, sha1($password)]);

      if ($sql->rowCount() > 0) {
        $data = $sql->fetchObject("Admin");

        Router::set_admin_session($data);
        header("Location: " . Router::route($restaurant->url_name));
      }else {
        $errors[1]["undefined"] = "username or password is wrong";
        $_SESSION["errors"] = $errors[1];
        $_SESSION["login_username"] = $username;
        header("Location: " . Router::route($restaurant->url_name . "/login"));
      }

    }else {
      $_SESSION["errors"] = $errors[1];
      $_SESSION["login_username"] = $username;
      header("Location: " . Router::route($restaurant->url_name . "/login"));
    }
    exit();
  }

}

?>
