<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>Bazar</title>
<style>
</style>

<script>
</script>
</head>

<body class='bd1'>
<form name='frm1' id='frm1' action="abc.php" method="post" enctype="multipart/form-data">
Hi, Welcome !
<?php
	// Database configuration  
	$dbHost     = "localhost";  
	$dbUsername = "root";  
	$dbPassword = "";  
	$dbName     = "avantika";  
  
	// Create database connection  
	$connect = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);  
        $res0=$connect->query("select sellername from sellermaster where sellerid=78"); 
        if($row0 = mysqli_fetch_array($res0,MYSQLI_BOTH)) { 
            echo $row0[0]; 
        }
        
?>        

</form>
</body>
</html>
