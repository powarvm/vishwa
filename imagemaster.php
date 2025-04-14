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

$isMobile=is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));
include 'css/avantikablue1.css'; 

?>


</style>

<script>
    function submitDeleteImage(imageid){
        if(confirm('Are you sure to REMOVE this image')){
            document.getElementById("imageid").value = imageid; 
            document.getElementById("actionbutton").value = "Delete Image"; 
            frm1.submit();
        }
    }

    function editImageName(imageid){
        document.getElementById("imageid").value = imageid; 
        document.getElementById("actionbutton").value = "EditImageName"; 
        frm1.submit();
    }

    function updateImageName(imageid){
        document.getElementById("imageid").value = imageid; 
        document.getElementById("actionbutton").value = "UpdateImageName"; 
        frm1.submit();
    }

    function addImage(){
        document.getElementById("frm1").action = "imageupload.php"; 
        document.frm1.submit();
    }

    function resetSearch(){
        document.getElementById('searchimage').value='';
        frm1.submit();
    }

</script>
</head>

<?php 
require_once 'connection.php'; 


$searchimage="";
if(isset($_POST["searchimage"])) $searchimage=$_POST["searchimage"];


$actionbutton='';
if(isset($_POST['actionbutton'])) { $actionbutton=$_POST['actionbutton']; };

if($actionbutton=="Delete Image"){
    $imageCount= getData("select count(*) as cnt from sellerimagemaster where imageid=".$_POST["imageid"], $connect);
    if($imageCount==0){
        $res1 = $connect->query("UPDATE imagemaster set imageflag=1 where imageid=".$_POST["imageid"]);
    }else{
        echo "<script>alert('You cant delete used Image');</script>";
    }
}

if($actionbutton=="UpdateImageName" ){
    $res1 = $connect->query("UPDATE imagemaster set imagename='".$_POST["imagename"]."' where imageid=".$_POST["imageid"]);
}

?>


<body class='bd1'>
<form name='frm1' id='frm1' action="imagemaster.php" method="post" enctype="multipart/form-data">
<?php require_once 'sellerheaderedit.php'; ?>


    
<div class='divsimg1' >

    <?php
    
    
        $sql1 = " select im.imageid, im.imagefilename, im.imagename  ";
        $sql1 = $sql1." from imagemaster im ";
        $sql1 = $sql1." where im.imageflag=0 and im.sellerid=".$sellerid; 
        if($actionbutton=="EditImageName" ){
            $sql1 = $sql1." and im.imageid=".$_POST["imageid"];
        } else {
            $sql1 = $sql1." and upper(im.imagename) like '%".strtoupper($searchimage)."%'";
        }
        $sql1 = $sql1." ORDER BY im.imageid desc ";

	$res1 = mysqli_query($connect, $sql1);
        
        
	while ($row1 = mysqli_fetch_array($res1,MYSQLI_BOTH)) {

            $imageid=$row1["imageid"];
            $imagename=$row1["imagename"];
            $imagefile = "images\\".$row1["imagefilename"];
            
            if($actionbutton=="EditImageName"){
                echo "<div class='divsimg2a' style='position:relative'>";
                    echo "<div class='divsimg4a' ><img src=$imagefile class='simg2' >";
                        echo "<input type='button' value='X' class='btn2' onclick='submitDeleteImage($imageid)' style='position:absolute;top:45%;left:45%;' >";
                        echo "<div class='divsimg5a' >";
                        echo "<div style='width:80%'><input type='text' name='imagename' id='imagename' value='".$imagename."' class='intext2'></div>";
                        echo "</div>";
                    echo "</div>";

                echo "</div>";
            } else {
                echo "<div class='divsimg2' onclick='editImageName($imageid)' style='cursor:pointer;'>";
                    echo "<div class='divsimg4' ><img src=$imagefile class='simg1' ></div>";
                    echo "<div class='divsimg5' >";
                        echo "<a href='#' class='simgname' >".$imagename."</a>";
                    echo "</div>";
                echo "</div>";
            }
        }
        
    ?>
    
</div> 
<input type='hidden' name='imageid' id='imageid' value='0'>
<input type='hidden' name='actionbutton' id='actionbutton' value=''>
<input type='hidden' name='openerpage' id='openerpage' value='imagemaster.php'>

<div class='divsimgfoot' style="">
    <div class='divreg2'>
        <?php 
        echo "<div class='divsimg3' >";

        if($actionbutton=="EditImageName"){
            echo "<div ><input type='button' name='button' id='button' value='Update' class='btn2' onclick='updateImageName($imageid)' >&nbsp;<input type='submit' name='button' id='button' value='Cancel' class='btn2' ></div>";
        }else{
            
            echo "<label style='margin:5px;'><input type='text' name='searchimage' id='searchimage' value='$searchimage' class='intext2'></label>";
            echo "<label style='margin:5px;'><input type='submit' name='button' id='button' value='Search' class='btn2' >&nbsp;<input type='button' name='button' id='button' value='Reset' onclick='resetSearch()'  class='btn2' ></label>";
            
            echo "<label style='margin:5px;'><input type='file' name='fileToUpload' id='fileToUpload'  class='uploadbtn' accept='image/*'></label>";
            echo "<label style='margin:5px;'><input type='button' name='button' id='button' value='Upload Selected Image' onclick='addImage()' class='btn2' ></label>";
        }
        echo "</div>";
        ?>
    </div>
</div>


</form>

</body>
</html>
