<?php
class DBController {
	private $host = "localhost";
	private $user = "phpmyadmin";
	private $password = "password";
	private $database = "mock_test_tbl";

    private $conn;
	
	function __construct() {
		$this->conn = $this->connectDB();
	}
	
	function connectDB() {
		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);

		  if (!$conn) 
			{
				die ( "no connection found" . mysqli_error($conn));
			}
		return $conn;
	}
	
	function runQuery($query) {
		$result = mysqli_query($this->conn,$query);
          


		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
        
        // print_r($resultset);exit();

		if(!empty($resultset))
			return $resultset;
	}
	
	function numRows($query) {
		$result  = mysqli_query($this->conn, $query);
		$rowcount = mysqli_num_rows($result);
		return $rowcount;	
	}
	
	function executeQuery($query) {
	    $result  = mysqli_query($this->conn, $query);
	    return $result;	
	}
}
?>
