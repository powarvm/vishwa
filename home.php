<?php session_start(); 
header('Cache-Control: max-age=900');
?>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>atpost</title>
</head>
   
<body style='margin:0;'>
<?php

$areaid=0;
if(isset($_SESSION["areaid"])) $areaid=$_SESSION["areaid"];

if(isset($_GET["id"])) $id=$_GET["id"];

//$isMobile=is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));
require_once 'connection.php'; 
$sql2 = "Select count(*) as cnt from sellerimagemaster sim where sim.imagetypeid=1 and sim.sellerid=$id";
$cnt= getData($sql2, $connect);
if($cnt==0){
    echo "<iframe name='sellertop' id='sellertop' src='sellercontactus.php?sellerid=$id' width='100%' height='90%' style='border:none;'></iframe>"; 
}else{
    echo "<iframe name='sellertop' id='sellertop' src='sellerhome.php?sellerid=$id' width='100%' height='90%' style='border:none;'></iframe>";     
}
echo "<iframe name='sellerfooter' id='sellerfooter' src='sellerfooter.php?sellerid=$id' width='100%' height='10%' style='border:none;'></iframe>"; 
?>
</body>
</html>
