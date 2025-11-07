<?php 
// global variables
$debug = false;

$tables = array(
	'usr' => 'users',
	'mag' => 'magazine',
	'ors' => 'orase',
	'pri' => 'producatori',
	'prd' => 'produse'
	);

if ($debug)	{
	$params = array(
		'srv' => 'localhost',
		'usr' => 'root',
		'pas' => '',
		'dbs' => ''
		);
} else { // your data here
	$params = array(
		'srv' => '',
		'usr' => '',
		'pas' => '',
		'dbs' => ''
		);
}
		
// class to handle all database related actions
class Connection
{
	protected $conn = "";
	
	function getConn() { return $this->conn; }
	
	// checks if table/db exists
	// params: name = table/db name, srcfor = search for ( table/db )
	function exists($name, $srcfor) {
		$ret = false;
		if (strtoupper($srcfor) === "DATABASES" || strtoupper($srcfor) === "TABLES") {
			$sql = "SHOW $srcfor LIKE '" . $name . "'";
			$res = $this->conn->query($sql);
			if ($res && $res->num_rows > 0) $ret = true;
		} else {
			echo 'You must search for either a table or a database!';
		}
		
		return $ret;
	}
	
	// check if table is empty
	function isEmpty($tname) { 
		$ret = true;
		$sql = 'select * from ' . $tname;
		$res = $this->conn->query($sql);
		if ($res && $res->num_rows > 0) $ret = false;
		
		return $ret;
	}
	
	// constructor
	function __construct($params) {
		// create the connection
		$this->conn = new mysqli($params["srv"], $params["usr"], $params["pas"]);
		
		// check connection
		if ($this->conn->connect_error) {
			die("Connection failed: " . $this->conn->connect_error);
		} else { // select the correct database
			mysqli_select_db($this->conn, $params["dbs"]);
		}
	}
	
	// destructor
	function __destruct() { $this->conn->close(); }
	
	// run a sql query
	function runQuery($sqlq, $op) {
		$res = 0;
		if ($res = $this->conn->query($sqlq)) {
			if (!empty($op))
				echo "Operation [" . $op . "] completed successfully!<br>";
		} else
			echo "Error while trying to " . $op . " record!: " . $this->conn->error . "<br>";
		
		return $res;
	}
}

?>