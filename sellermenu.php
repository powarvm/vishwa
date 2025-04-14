<?php session_start(); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ATPOST</title>
<style>
<?php    

if(isset($_POST['actionbutton'])) { $actionbutton=$_POST['actionbutton']; };
if($actionbutton=="signout"){
    $_SESSION["sellerid"]=0;
}


require_once 'css/avantikablue1.css'; 




$sellerid=0;
if(isset($_SESSION["sellerid"])) $sellerid=$_SESSION["sellerid"];

?>
</style>

<script>
   
    function signOut(){
        document.getElementById("actionbutton").value='SignOut';
        frm1.submit();
    }

</script>    

</head>
<body class='bdhead' >
<form name='frm1' id='frm1' action="sellermenu.php" method="post">

<?php 
    echo "<ul class='ulmenu1'>";
    if($sellerid==0){
        echo "<li class='limenu1' ><a href='#' onclick='window.open(\"signin.php\");'>Sign In</a></li>";
    }else{
        echo "<li class='limenu1' ><a href='#' onclick='signOut();'>Sign Out</a></li>";
    }
    echo "</ul>";

    echo "<input type='hidden' id='actionbutton' name='actionbutton' value=''>";
    
?>
</form>    
</body>
</html>
