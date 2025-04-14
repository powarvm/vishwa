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

$editproductid=0;
if(isset($_POST["editproductid"])) $editproductid=$_POST["editproductid"];
    
$isMobile=is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));
include 'css/avantikablue1.css'; 
?>


</style>

<script>
    function editItem(productid){
        document.getElementById('actionbutton').value='edit';
        document.getElementById('editproductid').value=productid;
        frm1.submit();
    }

    function newItem(){
        document.getElementById('actionbutton').value='new';
        document.getElementById('editproductid').value=0;
        frm1.submit();
    }


    function updateItem(productid){
        document.getElementById('actionbutton').value='update';
        document.getElementById('editproductid').value=productid;
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


    function pickupImage(productid,action) {
        window.open("imagemasterview.php?documentid="+productid+"&actiontype="+action+"&backpage=sellerproductsedit");
    }

    function goBack(){
        document.getElementById("editproductid").value = 0; 
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
    
    $editproductid=$_POST["editproductid"];
    $productname=$_POST["productname"];
    $description=$_POST["description"];
    $price=$_POST["price"];
    $mrp=$_POST["mrp"];
    $pricedetail=$_POST["pricedetail"];

    $connect->query("UPDATE sellerproducts set productname='$productname',description='$description',price=$price,mrp=$mrp,pricedetail='$pricedetail' where productid=$editproductid"); 
    $actionbutton='updated';
    
} 




?>

<body class='bd1'>
<form name='frm1' id='frm1' action="sellerproductsedit.php" method="post">
    
<?php require_once 'sellerheaderedit.php'; ?>

<div class='divsp0e' >
    
<?php
    
    
if($actionbutton=='add'){ 
    
    $productname=$_POST["productname"];
    $description=$_POST["description"];
    $price=$_POST["price"];
    $mrp=$_POST["mrp"];
    $pricedetail=$_POST["pricedetail"];


    $editproductid= getData("select coalesce(max(productid),0)+1 from sellerproducts", $connect);
    $connect->query("INSERT into sellerproducts (productid,sellerid,productname,description,price,mrp,pricedetail) values ($editproductid,$sellerid,'$productname','$description',$price,$mrp,'$pricedetail')"); 
    $actionbutton='added';
    
} 
    
    
        if($actionbutton=="new"){
            
            echo "<div class='divsp1ea'>";
                echo "<div class='divsp5e'>";
                    echo "<div class='divsp8e3'><div class='divsp8e1'>Name</div><div class='divsp8e2'><input type='text' name='productname' id='productname' value='' class='intext2' ></div></div>";
                    echo "<div class='divsp8e3'><div class='divsp8e1'>Description</div><div class='divsp8e2'><input type='text' name='description' id='description' value='' class='intext2' ></div></div>";
                    echo "<div class='divsp8e3'><div class='divsp8e1'>Price</div><div class='divsp8e2'><input type='text' name='price' id='price' value='0' class='intext2' ></div></div>";
                    echo "<div class='divsp8e3'><div class='divsp8e1'>MRP</div><div class='divsp8e2'><input type='text' name='mrp' id='mrp' value='0' class='intext2' ></div></div>";
                    echo "<div class='divsp8e3'><div class='divsp8e1'>PER</div><div class='divsp8e2'><input type='text' name='pricedetail' id='pricedetail' value='NO' class='intext2' ></div></div>";
                echo "</div>";
            echo "</div>";
            
        }
    
    
        
        $sql1 = " Select cp.*, coalesce(pi.productimageid,0) as productimageid, coalesce(im.imagefilename,'') as  imagefilename ";
        $sql1 = $sql1." from sellerproducts cp ";
        $sql1 = $sql1." left join productimages pi on pi.productid=cp.productid and pi.seq=0 ";
        $sql1 = $sql1." left join imagemaster im on im.imageid=pi.imageid ";
        $sql1 = $sql1." where cp.sellerid=$sellerid";
        
        if($editproductid>0 || $actionbutton=="new"){
            $sql1 = $sql1." and cp.productid=".$editproductid;
        } else {
            $sql1 = $sql1." and upper(cp.productname) like '%".strtoupper($searchitem)."%'";
        }
        
        
        
	$res1 = mysqli_query($connect, $sql1);
	while ($row1 = mysqli_fetch_array($res1,MYSQLI_BOTH)) {
            $productid=$row1["productid"];
            $productimageid=$row1["productimageid"];
            $productname=trim($row1["productname"]);
            $description=$row1["description"];
            $price=$row1["price"];
            $mrp=$row1["mrp"];
            $pricedetail=$row1["pricedetail"];
            $imagefile = "images\\".$row1["imagefilename"];

            if($editproductid>0){

                echo "<div class='divsp1ea' >";
                    echo "<div class='divsp2edit'>";
                    if($productimageid==0){
                        echo "<input type='button' value='Add Image' class='btn1' onclick='pickupImage($productid,\"add\")' style='position:absolute;top:80%;center:0%;'>";   
                    }else{
                        echo "<img src=$imagefile class='imgsp2a' >";
                        echo "<input type='button' value='Change Image' class='btn1' onclick='pickupImage($productimageid,\"replace\")' style='position:absolute;top:80%;center:0%;'>";   
                    }
                    echo "</div>";
                    
                    echo "<div class='divsp3edit'>";
                        echo "<div class='divsp8e3'><div class='divsp8e1'>NAME</div><div class='divsp8e2'><input type='text' name='productname' id='productname' value='$productname' class='intext2' ></div></div>";
                        echo "<div class='divsp8e3'><div class='divsp8e1'>DETAILS</div><div class='divsp8e2'><input type='text' name='description' id='description' value='$description' class='intext2' ></div></div>";
                        echo "<div class='divsp8e3'><div class='divsp8e1'>PRICE</div><div class='divsp8e2'><input type='text' name='price' id='price' value='$price' class='intext2' ></div></div>";
                        echo "<div class='divsp8e3'><div class='divsp8e1'>MRP</div><div class='divsp8e2'><input type='text' name='mrp' id='mrp' value='$mrp' class='intext2' ></div></div>";
                        echo "<div class='divsp8e3'><div class='divsp8e1'>PER</div><div class='divsp8e2'><input type='text' name='pricedetail' id='pricedetail' value='$pricedetail' class='intext2' ></b></div></div>";

                    echo "</div>";
                echo "</div>";

            }else{

                echo "<div class='divsp1e' onclick='editItem($productid)' style='cursor:pointer;'>";
                    echo "<div class='divsp2e'>";
                    echo "<img src=$imagefile class='img100' >";
                    echo "</div>";

                    echo "<div class='divsp3e'>";
                    echo "<div class='divsp7e'>$productname</div>";
                    echo "<div class='divsp8e2'>$description</div>";
                    echo "<div class='divsp8e2'>Price : <b>Rs $price</b>&nbsp;<del>$mrp</del>&nbsp;$pricedetail</div>";
                    echo "</div>";
                echo "</div>";
            }
        }
        echo "<input type='hidden' name='actionbutton' id='actionbutton' value=''>";
        echo "<input type='hidden' name='editproductid' id='editproductid' value='$editproductid'>";
?>
</div>    
<?php echo "<input type='hidden' name='sellerid' id='sellerid' value='$sellerid'>" ?>    
    
<div class='divsfoot100' >
<?php    
    if($editproductid==0 && $actionbutton!="new"){
        echo "<div class='divsp4e'>";
            echo "<div style='margin:10px;width:40%'><input type='text' name='searchitem' id='searchitem' value='$searchitem' class='intext2' ></div>";
            $searchimage="images\\search.png";
            $newimage="images\\new.png";
            echo "<div style='margin:10px; padding:20px;'><img src=$searchimage class='imgindex2' onclick='frm1.submit();' ><img src=$newimage class='imgindex2' onclick='newItem()' > </div>";
        echo "</div>";
    }
    
    if($editproductid>0){
        echo "<div class='divsp4e'><input type='button' class='btn2' value='Update' onclick='updateItem($productid)' >";
            if($actionbutton=='updated'){
                echo "&nbsp;<b>Updated Successfully</b>";
            }
            echo "&nbsp;<input type='button' class='btn2' value='Back' onclick='goBack()' >";
        echo "</div>";
    }
    
    if($actionbutton=="new"){
        echo "<div class='divsp4e' >";
            echo "<input type='button' class='btn2' value='Add' onclick='addItem(0)' style='margin:10px;'>";
            echo "<input type='button' class='btn2' value='Back' onclick='goBack()' style='margin:10px;'>";
        echo "</div>";
    }
    
    
?>    
</div>
    
    
</form>

</body>
</html>
