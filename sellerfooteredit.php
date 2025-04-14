<html>
<head>
<style>
<?php 
include 'css/avantikablue1.css'; 
$sellerid=0;
if(isset($_GET["sellerid"])) $sellerid=$_GET["sellerid"];
if(isset($_POST["sellerid"])) $sellerid=$_POST["sellerid"];
?>
</style>
</head>

<?php
require_once 'connection.php'; 
$actionbutton="";
if(isset($_POST["actionbutton"])) $actionbutton=$_POST["actionbutton"];
if($actionbutton=='Update'){ 
    $cnt= getData("select count(*) as cnt from sellerfooter where sellerid=$sellerid", $connect);
    if($cnt==0){
        $res1 = $connect->query("INSERT into sellerfooter (sellerid,scrollmsg) values ($sellerid, '".$_POST["scrollmsg"]."')");        
    }else{
        $res1 = $connect->query("UPDATE sellerfooter set scrollmsg='".$_POST["scrollmsg"]."' where sellerid=$sellerid");        
    }
}

?>


<body class='bd1'>
<form name='frm1' id='frm1' action="sellerfooteredit.php" method="post" >
<div class='divsfoot1'  >
<?php

$sql1 = "Select scrollmsg from sellerfooter where sellerid=$sellerid and scrollmsg is not null limit 1";
//echo $sql1;
$res1 = mysqli_query($connect, $sql1);
$scrollmsg="";
if ($row1 = mysqli_fetch_array($res1)) {
    $scrollmsg=$row1["scrollmsg"];
}
if($actionbutton=='Edit'){
    echo "<div style='width:70%'><input type='text' name='scrollmsg' id='scrollmsg' value='$scrollmsg' class='intext2' ></div>";
    echo "<div style='width:20%;'><input type='submit' name='actionbutton' id='actionbutton' value='Update' class='btn22' ></div>";
}else{
    if($scrollmsg=="") $scrollmsg="Your scroll message here";
    echo "<div style='width:70%'><marquee class='scrollmsg1' >$scrollmsg</marquee></div>";
    echo "<div style='width:20%;'><input type='submit' name='actionbutton' id='actionbutton' value='Edit' class='btn22' ></div>";
}    
echo "<input type='hidden' name='sellerid' id='sellerid' value='$sellerid' >";
?>
</div>

</form>
</body>
</html>
<!--
<div class='divsfoot1'  >
</div>
->