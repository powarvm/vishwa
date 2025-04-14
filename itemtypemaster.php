<?php 
session_start(); 
header('Cache-Control: max-age=900');
?>

<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>seller</title>
<style>

<?php 

$sellerid=0;
if(isset($_SESSION["sellerid"])) $sellerid=$_SESSION["sellerid"];


$edititemtypeid=0;
if(isset($_POST["edititemtypeid"])) $edititemtypeid=$_POST["edititemtypeid"];
    
$isMobile=is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));
include 'css/avantikablue1.css'; 
?>


</style>

<script>
    function editCategory(itemtypeid){
        document.getElementById('actionbutton').value='edit';
        document.getElementById('edititemtypeid').value=itemtypeid;
        frm1.submit();
    }

    function newItem(){
        document.getElementById('actionbutton').value='new';
        document.getElementById('edititemtypeid').value=0;
        frm1.submit();
    }


    function updateItem(itemtypeid){
        document.getElementById('actionbutton').value='update';
        document.getElementById('edititemtypeid').value=itemtypeid;
        frm1.submit();
    }
    
    function addItem(){
        document.getElementById('actionbutton').value='add';
        frm1.submit();
    }

    function resetSearch(){
        document.getElementById('searchitem').value='';
        frm1.submit();
    }


    function pickupImage(itemtypeid,action) {
        window.open("imagemasterview.php?documentid="+itemtypeid+"&actiontype="+action+"&backpage=itemtypemaster");
    }

    function goBack(){
        document.getElementById("edititemtypeid").value = 0; 
        document.frm1.submit();
    }


</script>
</head>

<?php 
require_once 'connection.php'; 

$searchitem="";
if(isset($_POST["searchitem"])) $searchitem=$_POST["searchitem"];


$actionbutton="";
if(isset($_POST["actionbutton"])) $actionbutton=$_POST["actionbutton"];
if($actionbutton=='update'){ 
    
    $edititemtypeid=$_POST["edititemtypeid"];
    $itemtype=$_POST["itemtype"];

    $connect->query("UPDATE itemtypemaster set itemtype='$itemtype' where itemtypeid=$edititemtypeid"); 
    $actionbutton='updated';
    
} 


if($actionbutton=='add'){ 
    
    $itemtype=$_POST["itemtype"];

    $edititemtypeid= getData("select coalesce(max(itemtypeid),0)+1 from itemtypemaster", $connect);
    $connect->query("INSERT into itemtypemaster (itemtypeid,itemtype) values ($edititemtypeid,'$itemtype')"); 
    $actionbutton='added';
    
} 


?>

<body class='bd1'>
<form name='frm1' id='frm1' action="itemtypemaster.php" method="post">
    
<?php require_once 'sellerheaderedit.php'; ?>

<div class='divcm0e' >
    
<?php
    
    
        if($actionbutton=="new"){
            
            echo "<div class='divcm1e'>";
            echo "<div class='divcm5e'>";
                echo "<div class='divcm6e'><div class='divcm6e1'>Category</div><div class='divcm6e2'><input type='text' name='itemtype' id='itemtype' value='' class='intext2' size='20'></div></div>";
            echo "</div>";
            echo "</div>";
        }
    
    
        
        $sql1 = " Select cm.itemtypeid, cm.itemtype, coalesce(cm.imageid,0) as imageid, coalesce(im.imagefilename,'') as  imagefilename  from itemtypemaster cm ";
        $sql1 = $sql1." left join imagemaster im on im.imageid=cm.imageid ";
        $sql1 = $sql1." where 1=1 ";
        if($edititemtypeid>0 || $actionbutton=="new"){
            $sql1 = $sql1." and cm.itemtypeid=".$edititemtypeid;
        }else{
            $sql1 = $sql1." and upper(cm.itemtype) like '%".strtoupper($searchitem)."%'";
        }
        $sql1 = $sql1." order by cm.itemtype";
        
        
        
	$res1 = mysqli_query($connect, $sql1);
	while ($row1 = mysqli_fetch_array($res1,MYSQLI_BOTH)) {
            $itemtypeid=$row1["itemtypeid"];
            $itemtype=$row1["itemtype"];
            $imageid=$row1["imageid"];
            $imagefile = "images\\".$row1["imagefilename"];
                    
            if($edititemtypeid>0){
                
                echo "<div class='divcm1e' >";
                    echo "<div class='divcm2edit'>";
                        if($imageid==0){
                            echo "<input type='button' value='Add Image' class='btn1' onclick='pickupImage($itemtypeid,\"replace\")' style='position:absolute;top:80%;center:0%;'>";   
                        }else{
                            echo "<img src=$imagefile class='img100' >";
                            echo "<input type='button' value='Change Image' class='btn1' onclick='pickupImage($itemtypeid,\"replace\")' style='position:absolute;top:80%;center:0%;'>";   
                        }
                    echo "</div>";
                    
                    echo "<div class='divcm3edit'>";
                        echo "<div class='divcm6e'><div class='divcm6e1'>Category</div><div class='divam6e2'><input type='text' name='itemtype' id='itemtype' value='$itemtype' class='intext2' size='10'></div></div>";
                    echo "</div>";
                echo "</div>";
                
            }else{

                echo "<div class='divcm1e' onclick='editCategory($itemtypeid)' style='cursor:pointer;'>";
                    echo "<div class='divcm2e'>";
                    echo "<img src=$imagefile class='img100' >";
                    echo "</div>";

                    echo "<div class='divcm3e'>";
                    echo "<div class='divcm7e'>$itemtype</div>";
                    echo "</div>";
                echo "</div>";
            }
        }
        echo "<input type='hidden' name='actionbutton' id='actionbutton' value=''>";
        echo "<input type='hidden' name='edititemtypeid' id='edititemtypeid' value='$edititemtypeid'>";
?>
</div>    
    
<div class='divsfoot100' >
<?php    

    if($edititemtypeid==0){

        if($actionbutton=="new"){

            echo "<div class='divam4e'>";
                echo "<div><input type='button' class='btn2' value='Add' onclick='addItem(0)' ></div>";
                echo "<div><input type='button' class='btn2' value='Back' onclick='goBack()' ></div>";
            echo "</div>";

        }else{
            echo "<div class='divam4e'>";
                $searchimage="images\\search.png";
                echo "<div style='display:flex;margin:10px;width:60%'><div style='width:90%' ><input type='text' name='searchitem' id='searchitem' value='$searchitem' class='intext2' ></div><div style='margin:10px; padding:5px;'><img src=$searchimage class='imgindex2' onclick='frm1.submit();' ></div></div>";
                $newimage="images\\new.png";
                echo "<div style='margin:10px; padding:5px;'><img src=$newimage class='imgindex2' onclick='newItem()' > </div>";
            echo "</div>";
        }
        
    }
    
    if($edititemtypeid>0){
    
        echo "<div class='divam4e'>";
            echo "<div ><input type='button' class='btn2' value='Update' onclick='updateItem($itemtypeid)' ></div>";
            echo "<div><input type='button' class='btn2' value='Back' onclick='goBack()' ></div>";
            if($imageid>0){
                echo "<div><input type='button' class='btn2' value='Add New Type' onclick='newItem()' ></div>";
            }
        echo "</div>";
    }
?>    
</div>
    
   
</form>

</body>
</html>
