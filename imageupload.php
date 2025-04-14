<?php 
session_start(); 
header('Cache-Control: max-age=900');

$openerpage=$_POST["openerpage"];

$sellerid=0;
if(isset($_SESSION["sellerid"])){
    $sellerid=$_SESSION["sellerid"];
}


$target_dir = "images/";
$base_name = basename($_FILES["fileToUpload"]["name"]);
$base_file = $target_dir.$base_name;
$file_ext=strtolower(substr(strrchr($base_name, '.'), 1));
$image_name= strtoupper(substr($base_name,0,strpos($base_name, ".")));
$file_name = date("Ymdhis").".".$file_ext;
$target_file = $target_dir.$file_name ;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if($sellerid==0) {
    if($openerpage!="mybazar.php"){    
        echo "<script>alert('Sorry, your session is Expired, Sign In and try again');</script>";
        $uploadOk = 0;
    }
}


// Check if image file is a actual image or fake image
if(isset($_POST["button"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    $uploadOk = 1;
  } else {
    echo "<script>alert('Sorry, File is not an image');</script>";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "<script>alert('Sorry, file already exists');</script>";
    $uploadOk = 0;
}
// Check file size
//if ($_FILES["fileToUpload"]["size"] > 1048576) {
if ($_FILES["fileToUpload"]["size"] > 5242880) {
  echo "<script>alert('Sorry, your image file size must below or equal to 5 MB');</script>";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
  echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed');</script>";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "<script>alert('Sorry, Sorry, your file was not uploaded');</script>";
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";

    require_once 'connection.php'; 
    
    $imageid=1;
    $res1 = $connect->query("select coalesce(max(imageid),0)+1 as imageid from imagemaster");
    if($row1 = mysqli_fetch_array($res1)) { $imageid=$row1["imageid"]; }
    

    $insert = $connect->query("INSERT into imagemaster (imageid, sellerid, imagename, imagefilename ) VALUES ($imageid,$sellerid,'$image_name','$file_name')"); 
    
    if($openerpage=="mybazar.php"){
        $selareaid=$_POST["areaid"];
        $itemtypeid=$_POST["itemtypeid"];
        $itemname=$_POST["itemname"];
        $itemdescription=$_POST["itemdescription"];
        $itemprice=$_POST["itemprice"];
        $mobileno=$_POST["mobileno"];
        $contactname=$_POST["contactname"];
        $address=$_POST["address"];

        $selbazarid=getData("select coalesce(max(bazarid),0)+1 from bazarmaster", $connect);
        $insert = $connect->query("INSERT into bazarmaster (areaid, imageid, itemtypeid, itemname, itemdescription, itemprice, mobileno, contactname, address) VALUES ($selareaid, $imageid, $itemtypeid, '$itemname', '$itemdescription', $itemprice, $mobileno, '$contactname', '$address')"); 
        $openerpage=$openerpage."?id=".$selbazarid."&actionbutton=Added";
    }

    if($openerpage=="imagemasterview.php"){
        echo "<form name='frm1' id='frm1' action='imagemasterview.php' method='post'  >";
        echo "<input type='hidden' name='documentid' id='documentid' value='".$_POST["documentid"]."'>";
        echo "<input type='hidden' name='backpage' id='backpage' value='".$_POST["backpage"]."'>";
        echo "<input type='hidden' name='actiontype' id='actiontype' value='".$_POST["actiontype"]."'>"; 
        echo "<input type='hidden' name='imageid' id='imageid' value='".$imageid."'>"; 
        echo "<input type='hidden' name='actionbutton' id='actionbutton' value='submitImage'>"; 
        echo "</form>";
        echo "<script>document.frm1.submit();</script>";
    }
    
    
  } else {
    echo "<script>alert('Sorry, there was an error uploading your file');</script>";
  }
}

echo "<script>location.href='".$openerpage."'</script>";
?>
