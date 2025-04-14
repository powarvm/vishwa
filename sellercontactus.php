<?php 
session_start(); 
header('Cache-Control: max-age=900');
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>Home</title>
<style>

<?php 
$isMobile=is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));
include 'css/avantikablue1.css'; 

$sellerid=0;
if(isset($_GET["sellerid"])) $sellerid=$_GET["sellerid"];
if(isset($_POST["sellerid"])) $sellerid=$_POST["sellerid"];

?>


</style>

<script>
function openWebsite(website){
	window.open(website);
}

function wapplink(mylink){
    document.getElementById('wapp').href='whatsapp://send?text='+mylink;
    //document.getElementById('wapp').href='whatsapp://send?phone=919890215475&text='+mylink;
    
}

</script>


</head>
<body class='bd1'>
<form name='frm1' id='frm1' action="sellercontactus.php" method="post">
<?php 
require_once 'connection.php'; 
require_once 'sellerheader.php'; 

$sql1 = "Select cm.*, am.domainname as areadomainname from sellermaster cm, areamaster am where cm.areaid=am.areaid and cm.sellerid=".$_GET["sellerid"];
$res1 = mysqli_query($connect, $sql1);
if($row1 = mysqli_fetch_array($res1)) {
	?>
        <div class='divsc1'   >
            
            
            <div class='divsc2'>
                <div class='divsc5'><label><b>
                <?php echo $row1["sellernamemarathi"]; ?>
                </b></label></div>
            </div>
            <div class='divsc2'>
                <div class='divsc6'><label></label></div>
            </div>
            
            <div class='divsc2'>
                <div class='divsc3'>Address</div>
                <div class='divsc4'><label>
                <?php echo $row1["address"]; ?>
                </label></div>
            </div>

            <div class='divsc2'>
                <div class='divsc3'>Contact</div>
                <div class='divsc4'><label>
                <?php echo $row1["contactperson"]; ?>
                </label></div>
            </div>

            <div class='divsc2'>
                <div class='divsc3'>Contact No</div>
                <div class='divsc4'><label>
                <?php echo $row1["mobileno"]." ". $row1["othermobilenos"];  ?>
                </label></div>
            </div>
            
            <div class='divsc2'>
                <div class='divsc3'>Email</div>
                <div class='divsc4'><label>
                <?php echo $row1["emailid"]; ?>
                </label></div>
            </div>
            
            <div class='divsc2'>
                <div class='divsc3'>Website</div>
                <div class='divsc4'><label>
		<?php 
                $website=$row1["website"];
                if($website==""){
                    $website="www.".$_SERVER["HTTP_HOST"]."/".$row1["directlink"];
                    $directlink="https://www.".$_SERVER["HTTP_HOST"]."/".$row1["directlink"];
                }else{
                    $directlink=$website;
                }
                echo "<a href='#' onclick='openWebsite(\"$directlink\");'>$website</a>";
                ?>
                </label></div>
            </div>

            <div class='divsc2'>
                <div class='divsc3'>Location</div>
                <div class='divsc4'><label>
		<?php echo "<a href='http://www.google.com/maps/place/49.4680,17.115140' target='_blank'>Show on Map</a>" ?>
                </label></div>
            </div>

            <div class='divsc2'>
                <div class='divsc3'>Close day</div>
                <div class='divsc4'><label>
                <?php echo $row1["closeday"]; ?>
                </label></div>
            </div>
            
            
            
            
        </div>
<?php 
}
?>	
<?php //require_once 'sellerfooter.php';     ?>    
</form>
</body>
</html>
