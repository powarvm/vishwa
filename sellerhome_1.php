<?php session_start(); 
header('Cache-Control: max-age=900');
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Seller</title>
<style>

<?php 
$isMobile=is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));
include 'css/avantikablue1.css'; 

$sellerid=0;
if(isset($_GET["sellerid"])) $sellerid=$_GET["sellerid"];
if(isset($_POST["sellerid"])) $sellerid=$_POST["sellerid"];

if(isset($_GET['actionbutton'])) { $actionbutton=$_GET['actionbutton']; };
if($actionbutton=="signout" || $sellerid==0){
    $_SESSION["sellerid"]=0;
    //echo "<script>opener.frm1.submit();</script>";
    //echo "<script>top.close();</script>";
    
    //echo "<script>opener.frm1.submit();</script>";
    //echo "<script>location.href='sellerhome.php?sellerid=".$sellerid."'</script>";
}


?>


</style>
<script>

</script>
</head>
<body class='bd1' onmouseup='hideMenu();'>
<form name='frm1' id='frm1' action="sellerhome.php" method="post" >
<?php 

require_once 'connection.php'; 
require_once 'sellerheader.php'; 



    echo "<div class='divsh1'  >";

    $sql2 = "Select sim.sellerimageid, im.imageid, im.imagefilename from sellerimagemaster sim left join imagemaster im on im.imageid=sim.imageid where sim.imagetypeid=1 and sim.sellerid=".$sellerid." order by sim.sellerimageid desc";
    $res2 = mysqli_query($connect, $sql2);
    while($row2 = mysqli_fetch_array($res2)) {
            $imagefile="images\\".$row2["imagefilename"];
            $sellerimageid=$row2["sellerimageid"];
            $imageid=$row2["imageid"];
            echo "<div class='divsh2' >";
            echo "<img src=$imagefile class='imgauto100' >"; 
            echo "</div>";
    }
    echo "</div>";
    
?>
<input type='hidden' name='sellerid' id='sellerid' value='<?php echo $sellerid ?>'>
<?php //require_once 'sellerfooter.php';     ?>    

</form>
</body>
</html>
