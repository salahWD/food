<?php

class dashboard_controller extends controller {

  public function default_action() {

    $this->admin_check();

    $db = DBC::get_instance();

		$sql = $db->dbh->prepare("SELECT name FROM general WHERE id = ?");
		$sql->execute([$_SESSION["user"]->id]);

		if ($sql->rowCount() > 0) {
			
			$view_data["general"] = $sql->fetch(PDO::FETCH_LAZY);
			$template = new Template(null, 3, true);
			$template->view("dashboard.php", $view_data);
			
		}else {
			echo "There is No Restaurant To Be Managed For You! From Index.php";
			exit();
		}

  }

}

?>