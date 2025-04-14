<?php 
//ini_set('session.cache_limiter','public');
//session_cache_limiter(false);
session_start(); 
header('Cache-Control: max-age=900');
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>seller</title>
<style>

<?php 
$sellerid=0;
if(isset($_SESSION["sellerid"])) $sellerid=$_SESSION["sellerid"];

$mode=0;
if(isset($_GET["mode"])) $mode=$_GET["mode"];

$searchimage="";
if(isset($_POST["searchimage"])) $searchimage=$_POST["searchimage"];

$backpage="";
if(isset($_GET["backpage"])) $backpage=$_GET["backpage"];
if(isset($_POST["backpage"])) $backpage=$_POST["backpage"];

$actiontype="";
if(isset($_GET["actiontype"])) $actiontype=$_GET["actiontype"];
if(isset($_POST["actiontype"])) $actiontype=$_POST["actiontype"];

$documentid=0;
if(isset($_GET["documentid"])) $documentid=$_GET["documentid"];
if(isset($_POST["documentid"])) $documentid=$_POST["documentid"];

$isMobile=is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));
include 'css/avantikablue1.css'; 

?>

</style>


    <?php
    /*
    if($mode==1){
        echo "<form name='frm10' id='frm10' action='imagemasterview.php' method='post' >";    
        echo "<input type='hidden' name='documentid' id='documentid' value='".$documentid."'>";
        echo "<input type='hidden' name='backpage' id='backpage' value='".$backpage."'>";
        echo "<input type='hidden' name='actiontype' id='actiontype' value='".$actiontype."'>";
        echo "</form>";    
        echo "<script>";
        echo "document.frm10.submit();";
        echo "</script>";
    }
     * 
     */
    ?>

<script>
    function submitImage(imageid){
        document.getElementById("imageid").value = imageid; 
        document.getElementById("actionbutton").value = 'submitImage'; 
        frm1.submit();
    }
    
    function addImage(){
        document.getElementById("frm1").action = "imageupload.php"; 
        document.frm1.submit();
    }
    function submitMe(){
        document.frm1.submit();
    }
    
    

</script>
</head>

    <?php
    require_once 'connection.php'; 
    
    $actionbutton='';
    if(isset($_POST['actionbutton'])) { $actionbutton=$_POST['actionbutton']; };

    if($actionbutton=="submitImage"){
        
        if($backpage=='sellerhomeedit'){
        
            if($actiontype=="replace"){
                $res1 = $connect->query("UPDATE sellerimagemaster set imageid=".$_POST["imageid"]." where sellerimageid=$documentid");
            }

            if($actiontype=="add"){
                $insert = $connect->query("INSERT into sellerimagemaster (imageid, sellerid, imagetypeid, seq) VALUES (".$_POST["imageid"].",$sellerid,1,0)"); 
            }

            if($actiontype=="add2"){
                $insert = $connect->query("INSERT into sellerimagemaster (imageid, sellerid, imagetypeid, seq) VALUES (".$_POST["imageid"].",$sellerid,2,0)"); 
            }
        }

        
        if($backpage=='sellerproductsedit'){
            if($actiontype=="add"){
                $res1 = $connect->query("INSERT into productimages (productid, imageid, seq) values ($documentid,".$_POST["imageid"].",0)");
            }
            
            if($actiontype=="replace"){
                $res1 = $connect->query("UPDATE productimages set imageid=".$_POST["imageid"]." where productimageid=$documentid");
            }

        }
        
        if($backpage=='categorymaster'){
            if($actiontype=="replace"){
                $res1 = $connect->query("UPDATE categorymaster set imageid=".$_POST["imageid"]." where categoryid=$documentid");
            }
        }
        
        if($backpage=='areamaster'){
            if($actiontype=="replace"){
                $res1 = $connect->query("UPDATE areamaster set imageid=".$_POST["imageid"]." where areaid=$documentid");
            }

        }
        

        
        echo "<script>opener.frm1.submit();</script>";
        echo "<script>window.close();</script>";

    }

    ?>



<?php 
    if($mode==1){
        echo "<body class='bd1' onload='submitMe();' >";
    }else{
        echo "<body class='bd1'>";
    }    
?>
<form name='frm1' id='frm1' action='imagemasterview.php' method='post' enctype='multipart/form-data' >
   
<div style='top:0; width:100%;' >

  
<div class='divsimg0' >SELECT IMAGE</div>
</div>
<div class='divsimg1' style='position:absolute;  top:50px; width:99%;' >

    <?php
    
        $sql1 = " select im.imageid, im.imagefilename, im.imagename ";
        $sql1 = $sql1." from imagemaster im ";
        $sql1 = $sql1." where im.imageflag=0 and im.sellerid=".$sellerid; 
        $sql1 = $sql1." and upper(im.imagename) like '%".strtoupper($searchimage)."%'";
        $sql1 = $sql1." ORDER BY im.imageid desc ";

	$res1 = mysqli_query($connect, $sql1);
        
        echo "<div class='divsimg3' >";
        
        echo "<label style='margin:5px;'><input type='text' name='searchimage' id='searchimage' value='$searchimage' class='intext2'></label>";
        echo "<label style='margin:5px;'><input type='submit' name='button' id='button' value='Search' onclick='searchImage()' class='btn1' >&nbsp;<input type='button' name='button' id='button' value='Reset' onclick='resetSearch()'  class='btn1' ></label>";
        
        echo "<label style='margin:5px;'><input type='file' name='fileToUpload' id='fileToUpload' class='uploadbtn' accept='image/*'><br>";
        echo "<input type='button' name='button' id='button' value='Upload Selected Image' onclick='addImage()' class='btn1'></label>";
        echo "<label style='margin:5px;'><input type='button' name='button' id='button' value='Close' onclick='window.close();' class='btn1'></label>";
        echo "</div>";

	while ($row1 = mysqli_fetch_array($res1,MYSQLI_BOTH)) {
            
            $imageid=$row1["imageid"];
            $imagename=$row1["imagename"];
            $imagefile = "images\\".$row1["imagefilename"];
            
            echo "<div class='divsimg2' >";
            echo "<div class='divsimg4' ><a href='#' onclick='submitImage($imageid);'><img src=$imagefile class='simg1' ></a></div>";
            echo "<div class='divsimg5' >".$imagename."</div>";
            echo "</div>";
            
            
        }
        
echo "</div>"; 

echo "<input type='hidden' name='documentid' id='documentid' value='$documentid'>";
echo "<input type='hidden' name='backpage' id='backpage' value='$backpage'>";
echo "<input type='hidden' name='actiontype' id='actiontype' value='$actiontype'>";    

echo "<input type='hidden' name='imageid' id='imageid' value=''>";
echo "<input type='hidden' name='actionbutton' id='actionbutton' value=''>"; 
echo "<input type='hidden' name='openerpage' id='openerpage' value='imagemasterview.php'>";
?>        

</form>

</body>
</html>
