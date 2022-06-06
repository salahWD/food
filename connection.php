<?php

  class DBC {
    private static $instance = null;
    
    private function __construct() {

      try {
        $this->dbh = new PDO("mysql:host=" . HOST . ";dbname=" . DATABASE . ";charset=utf8", USERNAME, PASSWORD);
        $this->dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
      } catch (Exception $e) {
        die("Error establishing a database connection.");
      }

    }

    public static function get_instance() {
      if (!self::$instance) {
        self::$instance = new DBC();
      }
      return self::$instance;
    }
    
  
  }

?>