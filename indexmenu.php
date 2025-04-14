<?php session_start(); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ATPOST</title>
<style>
<?php    
require_once 'css/atpost.css'; 
require_once 'connection.php';

$sellerid=0;
if(isset($_SESSION["sellerid"])) $sellerid=$_SESSION["sellerid"];

?>
</style>
</head>
<body class='bdhead'>
<?php 
    echo "<ul class='ulmenu1'>";
    echo "<li class='limenu1'><a href='#' onclick='newRegistration();'>New Registration</a></li>";
    if($sellerid==0){
        echo "<li class='limenu1'><a href='#' onclick='signIn();'>Sign In</a></li>";
    }else{
        $sellername=getData("Select sellername from sellermaster where sellerid=".$sellerid,$connect);
        echo "<li class='limenu1'><a href='#' onclick='openSellerEdit();'>$sellername</a></li>";
        echo "<li class='limenu1'><a href='#' onclick='signOut();'>Sign Out</a></li>";
    }
    echo "</ul>";
?>
</body>
</html>
