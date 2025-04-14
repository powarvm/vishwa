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
<body class='bd1'>
<div class='divsfoot1'  >
<?php
require_once 'connection.php'; 
$sql1 = "Select scrollmsg from sellerfooter where sellerid=$sellerid and scrollmsg is not null limit 1";
//echo $sql1;
$res1 = mysqli_query($connect, $sql1);
$scrollmsg="";
while ($row1 = mysqli_fetch_array($res1)) {
        if($scrollmsg==""){
            $scrollmsg=$row1["scrollmsg"];
        }else{
            $scrollmsg=$scrollmsg." * ".$row1["scrollmsg"];
        }
}
//echo "<table width='100%'><tr><td class='tdscroll1'><marquee class='scrollmsg1'>$scrollmsg</marquee></td></tr></table>";
echo "<marquee class='scrollmsg1'>$scrollmsg</marquee>";
$website="www.".$_SERVER["HTTP_HOST"]."/".getData("select directlink from sellermaster where sellerid=$sellerid", $connect);
$directlink="https://".$website;

//echo "<label onclick='window.open(\"$directlink\")' style='cursor:pointer;font-size:100%'>Kodoli-416114</label>";
echo "<label onclick='window.open(\"$directlink\")' style='cursor:pointer;font-size:120%'>$website</label>";

?>
</div>
</body>
</html>
<!--
<div class='divsfoot1'  >
</div>
->