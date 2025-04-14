<?php  
	//$connect=mysqli_connect("localhost","root","","avantika") or die ("Could not Connected to database") ;
	

	// Database configuration  
	$dbHost     = "localhost";  
	$dbUsername = "root";  
	$dbPassword = "";  
	$dbName     = "avantika";  
  
	// Create database connection  
	$connect = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);  
  
	// Check connection  
	if ($connect->connect_error) {  
		die("Connection failed: " . $connect->connect_error);  
	}	
	
	function isMobile () {   return is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile")); }
        
        function getData ($sql,$connect) {
            $returnResult="";
            $res0=$connect->query($sql); 
            if($row0 = mysqli_fetch_array($res0,MYSQLI_BOTH)) { 
                $returnResult=$row0[0]; 
            }
            return $returnResult;
        }
        
?>
