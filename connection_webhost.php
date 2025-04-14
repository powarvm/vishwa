<?php  
	//$connect=mysqli_connect("localhost","root","","avantika") or die ("Could not Connected to database") ;
	

	// Database configuration  
	$dbHost     = "localhost";  
	$dbUsername = "id14609164_vmp";  
	$dbPassword = "@=h)s6D<sFXKHCb9";  
	$dbName     = "id14609164_avantika";  
  
	// Create database connection  
	$connect = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);  
  
	// Check connection  
	if ($connect->connect_error) {  
		die("Connection failed: " . $connect->connect_error);  
	}	
	
	function isMobile () {   return is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile")); }	
?>
