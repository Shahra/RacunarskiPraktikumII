<!DOCTYPE html>
<?php
  class DB{
    private static $db = null;
    final private function __construct() { }
    final private function __clone() { }
    public static function getConnection() {
      if(DB::$db === null ) {
        global $db_base = 'mysql:host=rp2.studenti.math.hr;dbname=/**/;charset=utf8';
        global $db_user = 'student', $db_pass = 'pass.mysql';
        DB::$db = new PDO($db_base, $db_user, $db_pass);
      }
      return DB::$db;
    }

  }



?>

<html>

</html>
