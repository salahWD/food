<?php

  if (isset($_SESSION["admin"]) && !empty($_SESSION["admin"])) {
    header("Location: " . M_URL . "dashboard");
    exit();
  }
  $configration = $db->table("general")->select("id, R_name, password, username")->get()[0];

  if ($_SERVER["REQUEST_METHOD"] == "POST"):
    $error = [];
    if (isset($_POST["username"]) && !empty($_POST["username"])) {
      if (isset($_POST["pass"]) && !empty($_POST["pass"])) {
        if ($configration->password == sha1($_POST["pass"]) && $configration->username == $_POST["username"]) {
          $_SESSION["admin"] = [
            "username" => $configration->username,
            "pass" => $configration->password,
          ];
          header("Location: " . M_URL . "dashboard");
          exit();
        }
      }else {
        $error["pass"] = "please fill in this field";// no password sent
      }
    }else {
      $error["username"] = true;// no username sent
    }

  endif;?>

    <div class="main">
      <div class="middle">
        <div class="row">
          <div class="col-md-5">
            <div class="logo"><?php echo $configration->R_name;?>
            </div>
          </div>
          <div class="col-md-7">
            <div id="login">
              <form class="form" action="<?php echo M_URL . "login";?>" method="POST">
                <div class="input-group">
                  <span class="fa fa-user"></span>
                  <input name="username" type="text" Placeholder="Username" required <?php if (isset($_POST["username"])) {echo 'value="' . $_POST["username"] . '"';}?>
                    class="form-control <?php echo isset($error["username"]) ? "is-invalid": "";?>">
                  <div class="invalid-feedback">
                    please fill in this field.
                  </div>
                </div>
                <div class="input-group">
                  <span class="fa fa-lock"></span>
                  <input name="pass" type="password"  Placeholder="Password" required
                    <?php echo isset($_POST["pass"]) ? 'value="' . $_POST["pass"] . '"': "";?>
                    class="form-control <?php echo isset($error["pass"]) ? "is-invalid": "";?>"
                    >
                  <div class="invalid-feedback">
                    please fill in this field.
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