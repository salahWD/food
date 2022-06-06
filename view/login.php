<?php
  
  if (isset($_SESSION["admin"]) && !empty($_SESSION["admin"])) {
    header("Location: " . M_URL . "dashboard");
    exit();
  }

  ?>
  
  <div class="main">
    <div class="middle">
      <div class="row">
        <div class="col-md-5 col-lg-6">
          <div class="logo">Restaurant Name</div>
        </div>
        <div class="col-md-7 col-lg-6">
          <div id="login">
            <form class="form" action="<?php echo Router::get_path("login");?>" method="POST">
              <div class="input-group">
                <span class="fa fa-user"></span>
                <input name="username" type="text" Placeholder="Username" required
                  class="form-control <?php echo isset($_SESSION["error"]["username"]) ? "is-invalid": "";?>">
                <div class="invalid-feedback">
                  <?php echo isset($_SESSION["error"]["username"]) ? $_SESSION["error"]["username"] : "";?>
                </div>
              </div>
              <div class="input-group">
                <span class="fa fa-lock"></span>
                <input name="pass" type="password"  Placeholder="Password" required
                  class="form-control <?php echo isset($_SESSION["error"]["pass"]) ? "is-invalid": "";?>">
                <div class="invalid-feedback">
                  <?php echo isset($_SESSION["error"]["pass"]) ? $_SESSION["error"]["pass"]: "";?>
                </div>
              </div>
              <div>
                <span style="width:48%; text-align:left;  display: inline-block;">
                  <a class="small-text" href="#">Forgot password?</a>
                </span>
                <span style="width:50%; text-align:right;  display: inline-block;">
                  <input type="submit" value="Sign In">
                </span>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php //endif;?>


<!-- 


if ($_SERVER["REQUEST_METHOD"] == "POST"):
    $configration = $db->table("general")->select("id, name, password, username")->get()[0];
    $error = [];
    if (isset($_POST["username"]) && !empty($_POST["username"])) {
      if (isset($_POST["pass"]) && !empty($_POST["pass"])) {
        if ($configration->password == sha1($_POST["pass"]) && $configration->username == $_POST["username"]) {
          $_SESSION["admin"] = [
            "username" => $configration->username,
            "pass" => $configration->password,
          ];
          header("Location: " . M_PATH . "dashboard");
          exit();
        }
      }else {
        $error["pass"] = "please fill in this field";// no password sent
      }
    }else {
      $error["username"] = true;// no username sent
    }

  endif;?> -->