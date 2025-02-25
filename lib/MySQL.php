<?php

/*
    author: vipul

    FOR BIND PARAMS::
      SQL statement example:
        SELECT * FROM users WHERE uid = ? AND name = ?
      datatypes:
        i: Integer
        d: Double
        s: String
        b: Blob (binary data)
*/

namespace Lib;

class MySQL {

    private static $CONN;
    
    protected function __construct() {

      $user = DB_USER;
      $pass = DB_PASSWORD;
      $server = DB_HOST;
      $dbase = DB_NAME;
      $conn = mysqli_connect($server, $user, $pass, $dbase);
      mysqli_set_charset($conn,"utf8");

      //$conn = mysql_connect($server,$user,$pass);
      if (!$conn || mysqli_connect_errno()) {
          $this->error("Connection attempt failed");
      }

      self::$CONN = $conn;
      return true;
    }

    function error($text) {
      $conn = self::$CONN;
      $no = mysqli_errno($conn);
      $msg = mysqli_error($conn);
	    mysqli_close($conn);
      exit;
    }

    public static function select($sql = "", $bindParams = null, $dataTypes = '') {
      new MySQL();
    	$results = null; 

      if (empty($sql) || !preg_match("/^select/i", $sql) || empty(self::$CONN)) Utility::printR(Constants\Messages::DB_ISSUE_MSG);
        
      $conn = self::$CONN;
      if ($bindParams){
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, $dataTypes, ...$bindParams);	// Bind parameters
        mysqli_stmt_execute($stmt);						                      // Execute the statement
        $results = mysqli_stmt_get_result($stmt);				            // Get the result
      }else{
        $results = mysqli_query($conn, $sql);
      }
		
    	if ((!$results) or ( empty($results))) {
        return false;
      }
      $count = 0;
      $data = array();
      while ($row = mysqli_fetch_array($results)) {
        $row = array_filter($row, function($key) { return !is_int($key); }, ARRAY_FILTER_USE_KEY);
        $data[$count] = $row;
        $count++;
      }
      mysqli_free_result($results);
	    mysqli_close($conn);
      return $data;
    }

    public static function insert($sql = "", $bindParams = null, $dataTypes = '') {
      new MySQL();
    	$results = null; 
        
      if (empty($sql) || !preg_match("/^insert/i", $sql) || empty(self::$CONN)) Utility::printR(Constants\Messages::DB_ISSUE_MSG);

      $conn = self::$CONN;
      if ($bindParams){
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, $dataTypes, ...$bindParams);	// Bind parameters
        mysqli_stmt_execute($stmt);						                      // Execute the statement
        $results = 1;
      }else{
        $results = mysqli_query($conn, $sql);
      }

      if (!$results) {
          echo "Insert Operation Failed..<hr>" . mysqli_error(self::$CONN);
          $this->error("Insert Operation Failed..");
          $this->error("<H2>No results!</H2>\n");
          return false;
      }
      $id = mysqli_insert_id(self::$CONN);
	    mysqli_close($conn);
      return $id;
    }
    
    public static function adder($sql = "") {
      new MySQL();
      if (empty($sql) || !preg_match("/^insert/i", $sql) || empty(self::$CONN)) Utility::printR(Constants\Messages::DB_ISSUE_MSG);
      $conn = self::$CONN;
      $results = @mysql_query($sql, $conn);

      if (!$results)
          $id = "";
      else
          $id = mysql_insert_id();

      mysqli_close($conn);
      return $id;
    }

    public static function edit($sql = "", $bindParams = null, $dataTypes = '') {
      new MySQL();
    	$results = null; 
      if (empty($sql) || !preg_match("/^update/i", $sql) || empty(self::$CONN)) Utility::printR(Constants\Messages::DB_ISSUE_MSG);
      
      $conn = self::$CONN;
      if ($bindParams){
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, $dataTypes, ...$bindParams);	// Bind parameters
        mysqli_stmt_execute($stmt);						                      // Execute the statement
        $results = 1;
      }else{
        $results = mysqli_query($conn, $sql);
      }
      
      if (!$results) {
          $this->error("<H2>No results!</H2>\n");
          return false;
      }
      $rows = 0;
      $rows = mysqli_affected_rows($conn);
      mysqli_close($conn);
      return $rows;
    }

    public static function sql_query($sql = "") {
      new MySQL();
      if (empty($sql) || empty(self::$CONN)) Utility::printR(Constants\Messages::DB_ISSUE_MSG);
      
      $conn = self::$CONN;
      $results = mysqli_query($conn, $sql) or die("Query Failed..<hr>" . mysqli_error($conn));
      if (!$results) {
          $message = "Query went bad!";
          $this->error($message);
          return false;
      }
      if (!(preg_match("/^select/i", $sql) || preg_match("/^show/i", $sql))) {
          return true;
      } else {
          $count = 0;
          $data = array();
          while ($row = mysqli_fetch_array($results)) {
              $data[$count] = $row;
              $count++;
          }
          mysqli_free_result($results);
          mysqli_close($conn);
          return $data;
      }
    }
	
	  public static function delete($sql = "", $bindParams = null, $dataTypes = '') {
      new MySQL();
    	$results = null; 
      if (empty($sql) || empty(self::$CONN) || !preg_match("/^delete/i", $sql)) Utility::printR(Constants\Messages::DB_ISSUE_MSG);
      
      $conn = self::$CONN;
      if ($bindParams){
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, $dataTypes, ...$bindParams);	// Bind parameters
        mysqli_stmt_execute($stmt);						                      // Execute the statement
        $results = 1;
      }else{
        $results = mysqli_query($conn, $sql);
      }
      if ((!$results) or ( empty($results))) {
          return false;
      }
	    mysqli_close($conn);
    }
}

?>
