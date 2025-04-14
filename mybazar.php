<?php 
session_start(); 
header('Cache-Control: max-age=900');
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>Bazar</title>
<style>

<?php 
$sellerid=0;
if(isset($_SESSION["sellerid"])) $sellerid=$_SESSION["sellerid"];

$isMobile=is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));
include 'css/atpost.css'; 
?>


</style>

<script>
    
    
    function viewItem(selbazarid){
        document.getElementById('selbazarid').value=selbazarid;
        frm1.submit();
    }

    function setactionbutton(actionbutton){
        document.getElementById('actionbutton').value=actionbutton;
        frm1.submit();
    }

    function resetSearch(){
        document.getElementById('searchitem').value='';
        document.getElementById('selbazarid').value=0;
        frm1.submit();
    }

    function goBack(){
        document.getElementById("selbazarid").value = 0; 
        document.frm1.submit();
    }

    function wapporder(phoneno,directlink){
        document.getElementById('wapp').href='whatsapp://send?phone=91'+phoneno+'&text='+directlink;
    }
    
    function addItem(){
        
        if(document.getElementById('areaid').value=='0'){ 
            alert('Select Area'); 
            document.getElementById('areaid').focus();
            return false;
        }
        
        if(document.getElementById('itemtypeid').value=='0'){ 
            alert('Select Category'); 
            document.getElementById('itemtypeid').focus();
            return false;
        }
        
        if(document.getElementById('itemname').value==''){ 
            alert('Item Name must not empty'); 
            document.getElementById('itemname').focus();
            return false;
        }
        
        if(document.getElementById('itemprice').value==''){ 
            alert('Item price must not empty'); 
            document.getElementById('itemprice').focus();
            return false;
        }
        
        if(document.getElementById('contactname').value==''){ 
            alert('Contact name must not empty'); 
            document.getElementById('contactname').focus();
            return false;
        }

        if(document.getElementById('mobileno').value==''){ 
            alert('Mobile must not empty'); 
            document.getElementById('mobileno').focus();
            return false;
        }

        if(document.getElementById("noimage").checked==true){
            document.getElementById("actionbutton").value = "add"; 
        }else{

            if(document.getElementById("fileToUpload").files.length==0) {
                alert('Image File not selected to upload'); 
                document.getElementById('fileToUpload').focus();
                return false;
            }
            
            document.getElementById("frm1").action = "imageupload.php"; 
        }
        document.frm1.submit();
    }
    

</script>
</head>

<?php 
require_once 'connection.php'; 

$searchitem="";
if(isset($_POST["searchitem"])) $searchitem=$_POST["searchitem"];

$selbazarid=0;
if(isset($_GET["id"])) $selbazarid=$_GET["id"];
if(isset($_POST["selbazarid"])) $selbazarid=$_POST["selbazarid"];



$actionbutton="";
if(isset($_GET["actionbutton"])) $actionbutton=$_GET["actionbutton"];
if(isset($_POST["actionbutton"])) $actionbutton=$_POST["actionbutton"];

if($actionbutton=='add'){ 
    
    $selareaid=$_POST["areaid"];
    $itemtypeid=$_POST["itemtypeid"];
    $itemname=$_POST["itemname"];
    $itemdescription=$_POST["itemdescription"];
    $itemprice=$_POST["itemprice"];
    $mobileno=$_POST["mobileno"];
    $contactname=$_POST["contactname"];
    $address=$_POST["address"];
    
    $selbazarid=getData("select coalesce(max(bazarid),0)+1 from bazarmaster", $connect);
    $insert = $connect->query("INSERT into bazarmaster (bazarid,areaid, imageid, itemtypeid, itemname, itemdescription, itemprice, mobileno, contactname, address) VALUES ($selbazarid, $selareaid, (select imageid from itemtypemaster where itemtypeid=$itemtypeid), $itemtypeid, '$itemname', '$itemdescription', $itemprice, $mobileno, '$contactname', '$address')"); 
    $actionbutton="Added";
} 

if($actionbutton=='Approve'){ 
    $insert = $connect->query("UPDATE bazarmaster set approveflag=1 where bazarid=$selbazarid"); 
}
if($actionbutton=='Reject'){ 
    $insert = $connect->query("UPDATE bazarmaster set approveflag=0 where bazarid=$selbazarid"); 
}
if($actionbutton=='Close'){ 
    $insert = $connect->query("UPDATE bazarmaster set closeflag=1 where bazarid=$selbazarid"); 
}
if($actionbutton=='Open'){ 
    $insert = $connect->query("UPDATE bazarmaster set closeflag=0 where bazarid=$selbazarid"); 
}



?>

<body class='bd1'>
<form name='frm1' id='frm1' action="mybazar.php" method="post" enctype="multipart/form-data">

<div class='divbm0' >
<label class='divbm1' style='cursor:pointer;' onclick='window.open("index.php");'><b>atpost.in</b></label>
<label class='divbm1' ><b>MY BAZAR</b></label>

<?php 
    $close="images\\close.png";
    echo "<div class='divbm1' ><img src='$close' class='imgindex1' onclick='window.close();'></div>";
?>
</div>

<div class='divbm0a' >
    <?php 
    if($selbazarid==0){
        echo "<div class='divbm12'>";
            require_once 'ddarea.php'; 
            require_once 'dditemtype.php';
        echo "</div>";
    }
    
    echo "<div class='divbm12'>";

            if($selbazarid>=0){
                echo "<div class='divbm11'><input type='button' name='button' id='button' value='Register' onclick='viewItem(-1)' class='btn2' ></div>";
            }
        
            if($selbazarid==0){
                echo "<div class='divbm10'><input type='text' name='searchitem' id='searchitem' value='$searchitem' class='intext3' ></div>";
                $imagefile="images\\search.png";
                echo "<div class='divbm11'><img src=$imagefile class='imgindex1' onclick='frm1.submit();'></div>";
            }
            
            if($selbazarid<0){
                echo "<div class='divbm11'><input type='button' class='btn2' value='Add' onclick='addItem()' ></div>";
            }
            
            if($selbazarid!=0){
                echo "<div class='divbm11'><input type='button' class='btn2' value='Back' onclick='goBack()' ></div>";
            }
    echo "</div>";
    
    ?>
</div>    
    
    
    
<div class='divbm1a' >
<?php

    if($selbazarid<0){
        
        echo "<div class='divbm1n'>";
                echo "<div class='divbm6e'><div class='divbm7e'>Area</div><div class='divbm8e'>";
                require_once 'ddarea.php'; 
                echo "</div></div>";
                
                echo "<div class='divbm6e'><div class='divbm7e'>Item Type</div><div class='divbm8e'>";
                require_once 'dditemtype.php'; 
                echo "</div></div>";
                
        
                echo "<div class='divbm6e'><div class='divbm7e'>Item Name</div><div class='divbm8e'><input type='text' name='itemname' id='itemname' value='' class='intext2' ></div></div>";
                echo "<div class='divbm6e'><div class='divbm7e'>Item Description</div><div class='divbm8e'><textarea name='itemdescription' id='itemdescription' class='txtarea1' rows=3 cols=50></textarea></div></div>";
                echo "<div class='divbm6e'><div class='divbm7e'>Item Price</div><div class='divbm8e'><input type='text' name='itemprice' id='itemprice' value='' class='intext2' ></div></div>";

                echo "<div class='divbm6e'><div class='divbm7e'>Image</div><div class='divbm8e'>";
                echo "<label style='margin:5px;'><input type='file' name='fileToUpload' id='fileToUpload'  class='uploadbtn' accept='image/*' required>";
                echo "<label style='margin:5px;'><input type='checkbox' name='noimage' id='noimage' value='1' class='chkbox1'>NO Image";
                echo "</div></div>";
                
                echo "<div class='divbm6e'><div class='divbm7e'>Contact Name</div><div class='divbm8e'><input type='text' name='contactname' id='contactname' value='' class='intext2' ></div></div>";
                echo "<div class='divbm6e'><div class='divbm7e'>Address</div><div class='divbm8e'><input type='text' name='address' id='address' value='' class='intext2' ></div></div>";
                echo "<div class='divbm6e'><div class='divbm7e'>Mobile No</div><div class='divbm8e'><input type='text' name='mobileno' id='mobileno' value='' class='intext2' ></div></div>";
                echo "<div class='divbm6e'></div>";

        echo "</div>";
        
    }else{

    
        $sql1 = " Select bm.bazarid, bm.itemname, bm.itemdescription, bm.contactname, bm.address, bm.mobileno, am.areaheading, bm.itemprice, coalesce(bm.imageid,0) as imageid, coalesce(im.imagefilename,'') as  imagefilename, bm.closeflag, bm.approveflag from bazarmaster bm ";
        $sql1 = $sql1." left join imagemaster im on im.imageid=bm.imageid ";
        $sql1 = $sql1." inner join areamaster am on am.areaid=bm.areaid ";
        $sql1 = $sql1." where 1=1 ";
        
        if($sellerid!=1){
            $sql1 = $sql1." and bm.closeflag=0 ";
        }
        
        if($actionbutton!="Added" && $sellerid!=1){
            $sql1 = $sql1." and bm.approveflag=1 ";
        }
        
        if($selbazarid>0){
            $sql1 = $sql1." and bm.bazarid=$selbazarid";
        }else{
            $sql1 = $sql1." and upper(bm.itemname) like '%".strtoupper($searchitem)."%'";
            if(isset($_POST["areaid"])){
                if($_POST["areaid"]>0) $sql1 = $sql1." and am.areaid=".$_POST["areaid"];
            }

            if(isset($_POST["itemtypeid"])){
                if($_POST["itemtypeid"]>0) $sql1 = $sql1." and bm.itemtypeid=".$_POST["itemtypeid"];
            }
            $sql1 = $sql1." order by bm.approveflag,bm.closeflag, bm.registerdate desc ";
        }
        
	$res1 = mysqli_query($connect, $sql1);
	while ($row1 = mysqli_fetch_array($res1,MYSQLI_BOTH)) {
            $bazarid=$row1["bazarid"];
            $imagefile = "images\\".$row1["imagefilename"];
            
            if($selbazarid>0){
                echo "<div class='divbm2s' >";
                
                    echo "<div class='divbm3s'>";
                    echo "<img src=$imagefile class='img100' >";
                    echo "</div>";

                    echo "<div class='divbm4s'>";
                    if($actionbutton=="Added"){
                        echo "<div class='divbm6s'>!! Thank you for Item Registration !!</div>";
                        echo "<div class='divbm6s'><u>Item will be published after Approval</u></div>";
                    }
                    
                    echo "<div class='divbm5s'>".$row1["itemname"]."</div>";
                    echo "<div class='divbm6s'>".$row1["areaheading"]."</div>";
                    echo "<div class='divbm6s'>".$row1["itemprice"]."</div>";
                    echo "<div class='divbm7s'>".$row1["itemdescription"]."</div>";                    

                    $mobileno=$row1["mobileno"];
                    echo "<div class='divbm5s'>".$row1["contactname"].' '.$mobileno."</div>";                    
                    echo "<div class='divbm7s'>".$row1["address"]."</div>";                    
                    
                    echo "<div class='divbm9s'>";
                        $directlink=$_SERVER["HTTP_HOST"]."/mybazar.php?id=".$selbazarid;

                        $imagewapp = "images\\whatsapp.png";
                        $imagesms = "images\\sms.png";
                        $imagemail = "images\\email.png";
                        $imagephone = "images\\phone.png";
                        $imageback = "images\\back.png";
                        
                        echo "<div class='divbm8s'><a href='#' id='wapp' name='wapp' onclick='wapporder($mobileno,\"$directlink\");' title='Whatsapp your order'><img src=$imagewapp class='imgbm1' ></a></div>";
                        echo "<div class='divbm8s'><a href='#' id='sms' name='sms' onclick='wapporder($mobileno,\"$directlink\");' title='SMS your order'><img src=$imagesms class='imgbm1' title='SMS your order' ></a></div>";
                        echo "<div class='divbm8s'><img src=$imagephone class='imgbm1' title='Call' ></div>";
                        echo "<div class='divbm8s'><img src=$imageback class='imgbm1' title='Back' onclick='goBack();' ></div>";
                        
                    echo "</div>";        
                    
                    
                    if($sellerid==1){
                        echo "<div class='divbm6'>";
                        if($row1["approveflag"]==0){
                            echo "<input type='button' class='btn2' value='Approve' onclick='setactionbutton(\"Approve\")' >&nbsp;";
                        }else{
                            echo "<input type='button' class='btn2' value='Cancel Approval' onclick='setactionbutton(\"Reject\")' >&nbsp;";
                        }
                        
                        if($row1["closeflag"]==0){
                            echo "<input type='button' class='btn2' value='Close' onclick='setactionbutton(\"Close\")' >";
                        }else{
                            echo "<input type='button' class='btn2' value='Open' onclick='setactionbutton(\"Open\")' >";
                        }
                        echo "</div>";
                    }
                    
                    echo "</div>";
                echo "</div>";
            }else{
                echo "<div class='divbm2' onclick='viewItem($bazarid)' style='cursor:pointer;'>";
                    echo "<div class='divbm3'>";
                    echo "<img src=$imagefile class='img100' >";
                    echo "</div>";

                    echo "<div class='divbm4'>";
                    echo "<div class='divbm5'>".$row1["itemname"]."</div>";
                    echo "<div class='divbm6'>".$row1["areaheading"]."</div>";
                    echo "<div class='divbm6'>".$row1["itemprice"]."</div>";

                    if($sellerid==1){
                        if($row1["approveflag"]==0){
                            echo "<div class='divbm6'><span style='color:red'>Under Approval</span></div>";
                        }
                        if($row1["closeflag"]==1){
                            echo "<div class='divbm6'>Closed</div>";
                        }
                    }
                    
                    echo "</div>";
                echo "</div>";
            }
        }
    }
    echo "<input type='hidden' name='actionbutton' id='actionbutton' value=''>";
    echo "<input type='hidden' name='selbazarid' id='selbazarid' value='$selbazarid'>";
    echo "<input type='hidden' name='openerpage' id='openerpage' value='mybazar.php'>";        
?>
</div>    
   
</form>

</body>
</html>
