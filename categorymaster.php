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


$editcategoryid=0;
if(isset($_POST["editcategoryid"])) $editcategoryid=$_POST["editcategoryid"];
    
$isMobile=is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));
include 'css/avantikablue1.css'; 
?>


</style>

<script>
    function editCategory(categoryid){
        document.getElementById('actionbutton').value='edit';
        document.getElementById('editcategoryid').value=categoryid;
        frm1.submit();
    }

    function newItem(){
        document.getElementById('actionbutton').value='new';
        document.getElementById('editcategoryid').value=0;
        frm1.submit();
    }


    function updateItem(categoryid){
        document.getElementById('actionbutton').value='update';
        document.getElementById('editcategoryid').value=categoryid;
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


    function pickupImage(categoryid,action) {
        window.open("imagemasterview.php?documentid="+categoryid+"&actiontype="+action+"&backpage=categorymaster");
    }

    function goBack(){
        document.getElementById("editcategoryid").value = 0; 
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
    
    $editcategoryid=$_POST["editcategoryid"];
    $categoryname=$_POST["categoryname"];
    $sequence=$_POST["sequence"];

    $connect->query("UPDATE categorymaster set categoryname='$categoryname',sequence='$sequence' where categoryid=$editcategoryid"); 
    $actionbutton='updated';
    
} 


if($actionbutton=='add'){ 
    
    $categoryname=$_POST["categoryname"];
    $sequence=$_POST["sequence"];

    $editcategoryid= getData("select coalesce(max(categoryid),0)+1 from categorymaster", $connect);
    $connect->query("INSERT into categorymaster (categoryid,categoryname,sequence) values ($editcategoryid,'$categoryname','$sequence')"); 
    $actionbutton='added';
    
} 


?>

<body class='bd1'>
<form name='frm1' id='frm1' action="categorymaster.php" method="post">
    
<?php require_once 'sellerheaderedit.php'; ?>

<div class='divcm0e' >
    
<?php
    
    
        if($actionbutton=="new"){
            
            echo "<div class='divcm1e'>";
            echo "<div class='divcm5e'>";
                echo "<div class='divcm6e'><div class='divcm6e1'>Category</div><div class='divcm6e2'><input type='text' name='categoryname' id='categoryname' value='' class='intext2' size='20'></div></div>";
                echo "<div class='divcm6e'><div class='divcm6e1'>Sequence</div><div class='divcm6e2'><input type='text' name='sequence' id='sequence' value='0' class='intext2' size='2'></div></div>";
            echo "</div>";
            echo "</div>";
            
        }
    
    
        
        $sql1 = " Select cm.categoryid, cm.categoryname, cm.sequence, coalesce(cm.imageid,0) as imageid, coalesce(im.imagefilename,'') as  imagefilename  from categorymaster cm ";
        $sql1 = $sql1." left join imagemaster im on im.imageid=cm.imageid ";
        $sql1 = $sql1." where 1=1 ";
        if($editcategoryid>0 || $actionbutton=="new"){
            $sql1 = $sql1." and cm.categoryid=".$editcategoryid;
        }else{
            $sql1 = $sql1." and upper(cm.categoryname) like '%".strtoupper($searchitem)."%'";
        }
        $sql1 = $sql1." order by cm.categoryname";
        
        
        
	$res1 = mysqli_query($connect, $sql1);
	while ($row1 = mysqli_fetch_array($res1,MYSQLI_BOTH)) {
            $categoryid=$row1["categoryid"];
            $categoryname=$row1["categoryname"];
            $sequence=$row1["sequence"];
            $imageid=$row1["imageid"];
            $imagefile = "images\\".$row1["imagefilename"];
                    
            if($editcategoryid>0){
                
                echo "<div class='divcm1e' >";
                    echo "<div class='divcm2edit'>";
                    if($imageid==0){
                        echo "<input type='button' value='Add Image' class='btn1' onclick='pickupImage($categoryid,\"replace\")' style='position:absolute;top:80%;center:0%;'>";   
                    }else{
                        echo "<img src=$imagefile class='img100' >";
                        echo "<input type='button' value='Change Image' class='btn1' onclick='pickupImage($categoryid,\"replace\")' style='position:absolute;top:80%;center:0%;'>";   
                    }
                    echo "</div>";
                    
                    echo "<div class='divcm3edit'>";
                    echo "<div class='divcm6e'><div class='divcm6e1'>Category</div><div class='divcm6e2'><input type='text' name='categoryname' id='categoryname' value='$categoryname' class='intext2' size='10'></div></div>";
                    echo "<div class='divcm6e'><div class='divcm6e1'>Sequence</div><div class='divcm6e2'><input type='text' name='sequence' id='sequence' value='$sequence' class='intext2' size='2'></div></div>";
                    echo "</div>";
                echo "</div>";
                
            }else{

                echo "<div class='divcm1e' onclick='editCategory($categoryid)' style='cursor:pointer;'>";
                    echo "<div class='divcm2e'>";
                    echo "<img src=$imagefile class='img100' >";
                    echo "</div>";

                    echo "<div class='divcm3e'>";
                    echo "<div class='divcm7e'>$categoryname</div>";
                    echo "<div class='divam8e'>$sequence</div>";
                    echo "</div>";
                echo "</div>";
            }
        }
        echo "<input type='hidden' name='actionbutton' id='actionbutton' value=''>";
        echo "<input type='hidden' name='editcategoryid' id='editcategoryid' value='$editcategoryid'>";
?>
</div>    
    
    
<div class='divsfoot100' >
<?php    

    if($editcategoryid==0){

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
    
    if($editcategoryid>0){
    
        echo "<div class='divam4e'>";
            echo "<div ><input type='button' class='btn2' value='Update' onclick='updateItem($categoryid)' ></div>";
            echo "<div><input type='button' class='btn2' value='Back' onclick='goBack()' ></div>";
            if($imageid>0){
                echo "<div><input type='button' class='btn2' value='Add New Category' onclick='newItem()' ></div>";
            }
        echo "</div>";
    }
?>    
</div>
    
    
   
</form>

</body>
</html>
