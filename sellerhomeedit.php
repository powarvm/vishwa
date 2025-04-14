<?php 
//ini_set('session.cache_limiter','public');
//session_cache_limiter(false);
session_start(); 
header('Cache-Control: max-age=900');
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Seller</title>

<style>

<?php 
$sellerid=0;
if(isset($_SESSION["sellerid"])) $sellerid=$_SESSION["sellerid"];
    
$isMobile=is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));
include 'css/avantikablue1.css'; 

?>


</style>

<script>
function submitRemoveImage(sellerimageid,imageid){
    if(confirm('Are you sure to REMOVE this image')){
        document.getElementById("sellerimageid").value = sellerimageid; 
        document.getElementById("imageid").value = imageid; 
        document.getElementById("actionbutton").value = "RemoveImage"; 
        frm1.submit();
    }
}

function submitAddImage(imageid){
    if(confirm('Are you sure to ADD this image')){
        document.getElementById("imageid").value = imageid; 
        document.getElementById("actionbutton").value = "AddImage"; 
        frm1.submit();
    }
}

function pickupImage(sellerimageid,action) {
    window.open("imagemasterview.php?mode=1&documentid="+sellerimageid+"&actiontype="+action+"&backpage=sellerhomeedit");
}


</script>

</head>

<?php 
require_once 'connection.php'; 

$actionbutton='';
if(isset($_POST['actionbutton'])) { $actionbutton=$_POST['actionbutton']; };

if($actionbutton=="RemoveImage"){
    $res1 = $connect->query("DELETE from sellerimagemaster where sellerimageid=".$_POST["sellerimageid"]);
}

if($actionbutton=="AddImage"){
    $imageid=$_POST["imageid"];
    $insert = $connect->query("INSERT into sellerimagemaster (sellerid,imagetypeid,imageid,seq) VALUES ($sellerid,1,$imageid,0)"); 
}

if(isset($_GET['actionbutton'])) { $actionbutton=$_GET['actionbutton']; };
if($actionbutton=="signout" || $sellerid==0){
    $_SESSION["sellerid"]=0;
    //echo "<script>opener.frm1.submit();</script>";
    echo "<script>top.close();</script>";
    
    //echo "<script>opener.frm1.submit();</script>";
    //echo "<script>location.href='sellerhome.php?sellerid=".$sellerid."'</script>";
}

?>


<body class='bd1'>
<form name='frm1' id='frm1' action="sellerhomeedit.php" method="post" >

<?php require_once 'sellerheaderedit.php';     ?>
    
    <div class='divsh1' >
        
    <?php
    
    $sql1  = " SELECT sm.sellernamemarathi, coalesce(ims.imageid, 0) as imageid, coalesce(sim.sellerimageid,0) as sellerimageid, coalesce(ims.imagefilename,'') as imagefilename ";
    $sql1  = $sql1." FROM `sellermaster` sm ";
    $sql1  = $sql1." left join sellerimagemaster sim on sim.sellerid=sm.sellerid and imagetypeid=2 ";
    $sql1  = $sql1." left join imagemaster ims on ims.imageid=sim.imageid ";
    $sql1  = $sql1." WHERE sm.sellerid=".$sellerid;

    $res1 = mysqli_query($connect, $sql1);
    if($row1 = mysqli_fetch_array($res1)) {
        $imagefile="images\\".$row1["imagefilename"];
        $sellerimageid=$row1["sellerimageid"];
        $imageid=$row1["imageid"];
    }
    
    /*
    echo "<div class='divsh4' >";
    if($sellerimageid==0){
        echo "<label style='margin:5px;'><input type='button' value='Add Logo' class='btn1' onclick='pickupImage(0,\"add2\")' ></label>";   
    }else{
        echo "<label style='margin:5px;'><img src=$imagefile class='img2' ></label>";
        echo "<label style='margin:5px;'><input type='button' value='Remove Logo' class='btn1' onclick='submitRemoveImage($sellerimageid,$imageid)' ></label>";
        echo "<label style='margin:5px;'><input type='button' value='Change Logo' class='btn1' onclick='pickupImage($sellerimageid,\"replace\")' ></label>";
    }
    echo "</div>";
    */
    
    echo "<div class='divsh3' >";
    echo "<input type='button' value='Add Image' class='btn1' onclick='pickupImage(0,\"add\")' >";   
    echo "</div>";
    
    
    $sql2 = "Select sim.sellerimageid, im.imageid, im.imagefilename from sellerimagemaster sim left join imagemaster im on im.imageid=sim.imageid where sim.imagetypeid=1 and sim.sellerid=".$sellerid." order by sim.sellerimageid desc";
    $res2 = mysqli_query($connect, $sql2);
    while($row2 = mysqli_fetch_array($res2)) {
            $imagefile="images\\".$row2["imagefilename"];
            $sellerimageid=$row2["sellerimageid"];
            $imageid=$row2["imageid"];
            echo "<div class='divsh2' style='position:relative'>";
            echo "<img src=$imagefile class='imgauto100' >"; 
            echo "<input type='button' value='Remove Image' class='btn1' onclick='submitRemoveImage($sellerimageid,$imageid)' style='position:absolute;top:0%;left:0%;'>";   
            echo "<input type='button' value='Change Image' class='btn1' onclick='pickupImage($sellerimageid,\"replace\")' style='position:absolute;top:15%;left:0%;'>";   
            echo "</div>";
    }
    
    
    ?>
    </div>    
    <div class='divsfoot100' >
        <?php 
        $sql1 = "Select scrollmsg from sellerfooter where sellerid=$sellerid and scrollmsg is not null limit 1";
        $scrollmsg= getData($sql1, $connect);
        echo "<marquee class='scrollmsg1'>$scrollmsg</marquee>";
        ?>
    </div>
    
    
<input type='hidden' name='sellerimageid' id='sellerimageid' value='0'>
<input type='hidden' name='imageid' id='imageid' value='0'>
<input type='hidden' name='actionbutton' id='actionbutton' value=''>

</form>
</body>
</html>
