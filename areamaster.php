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


$editareaid=0;
if(isset($_POST["editareaid"])) $editareaid=$_POST["editareaid"];
    
$isMobile=is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));
include 'css/avantikablue1.css'; 
?>


</style>

<script>
    function editArea(areaid){
        document.getElementById('actionbutton').value='edit';
        document.getElementById('editareaid').value=areaid;
        frm1.submit();
    }

    function newItem(){
        document.getElementById('actionbutton').value='new';
        document.getElementById('editareaid').value=0;
        frm1.submit();
    }
    
    function setAction(act){
        if(act==1){
            document.getElementById('actionbutton').value='BlockArea';
        }else{
            document.getElementById('actionbutton').value='UnBlockArea';
        }
        frm1.submit();
    }


    function updateItem(areaid){
        document.getElementById('actionbutton').value='update';
        document.getElementById('editareaid').value=areaid;
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


    function pickupImage(areaid,action) {
        window.open("imagemasterview.php?documentid="+areaid+"&actiontype="+action+"&backpage=areamaster");
    }

    function goBack(){
        document.getElementById("editareaid").value = 0; 
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
    
    $editareaid=$_POST["editareaid"];
    $areaname=$_POST["areaname"];
    $areaheading=$_POST["areaheading"];
    $pincode=$_POST["pincode"];
    $domainname=$_POST["domainname"];
    $sequence=$_POST["sequence"];

    $connect->query("UPDATE areamaster set areaname='$areaname',areaheading='$areaheading',pincode=$pincode,domainname='$domainname',sequence='$sequence' where areaid=$editareaid"); 
    $actionbutton='updated';
    
} 

if($actionbutton=='add'){ 
    
    $areaname=$_POST["areaname"];
    $areaheading=$_POST["areaheading"];
    $pincode=$_POST["pincode"];
    $domainname=$_POST["domainname"];    
    $sequence=$_POST["sequence"];
    
    $editareaid= getData("select coalesce(max(areaid),0)+1 from areamaster", $connect);
    $connect->query("INSERT into areamaster (areaid,areaname,areaheading,pincode,domainname,sequence) values ($editareaid,'$areaname','$areaheading',$pincode,'$domainname',$sequence)"); 
    $actionbutton='added';
    
} 

if($actionbutton=='BlockArea'){ 
    $editareaid=$_POST["editareaid"];
    $connect->query("UPDATE areamaster set cancelflag=1 where areaid=$editareaid"); 
} 

if($actionbutton=='UnBlockArea'){ 
    $editareaid=$_POST["editareaid"];
    $connect->query("UPDATE areamaster set cancelflag=0 where areaid=$editareaid"); 
} 

?>

<body class='bd1'>
<form name='frm1' id='frm1' action="areamaster.php" method="post">
<?php 
    //start Sellerid ==1 only 
    if($sellerid==1) {
?>
<?php require_once 'sellerheaderedit.php'; ?>
<div class='divam0e' >
    
<?php
    
    
        if($actionbutton=="new"){
            
            echo "<div class='divam1e'>";
            echo "<div class='divam5e'>";
                echo "<div class='divam6e'><div class='divam6e1'>Area Name</div><div class='divam6e2'><input type='text' name='areaname' id='areaname' value='' class='intext2' size='20'></div></div>";
                echo "<div class='divam6e'><div class='divam6e1'>Area Heading</div><div class='divam6e2'><input type='text' name='areaheading' id='areaheading' value='' class='intext2' size='20'></div></div>";
                echo "<div class='divam6e'><div class='divam6e1'>PIN Code</div><div class='divam6e2'><input type='text' name='pincode' id='pincode' value='' class='intext2' size='10'></div></div>";
                echo "<div class='divam6e'><div class='divam6e1'>Sequence</div><div class='divam6e2'><input type='text' name='sequence' id='sequence' value='0' class='intext2' size='2'></div></div>";
                echo "<div class='divam6e'><div class='divam6e1'>Domain Name</div><div class='divam6e2'><input type='text' name='domainname' id='domainname' value='' class='intext2' size='20'></div></div>";
            echo "</div>";
            echo "</div>";
            
        }
    
    
        
        $sql1 = " Select am.areaid, am.areaname, am.areaheading, am.pincode, am.domainname, am.sequence, am.cancelflag, coalesce(am.imageid,0) as imageid, coalesce(im.imagefilename,'') as  imagefilename  from areamaster am ";
        $sql1 = $sql1." left join imagemaster im on im.imageid=am.imageid ";
        $sql1 = $sql1." where 1=1 ";
        if($editareaid>0 || $actionbutton=="new"){
            $sql1 = $sql1." and am.areaid=".$editareaid;
        }else{
            $sql1 = $sql1." and ( (upper(am.areaname) like '%".strtoupper($searchitem)."%') or (upper(am.areaheading) like '%".strtoupper($searchitem)."%'))";
        }
        $sql1 = $sql1." order by am.areaname";
        
	$res1 = mysqli_query($connect, $sql1);
	while ($row1 = mysqli_fetch_array($res1,MYSQLI_BOTH)) {
            $areaid=$row1["areaid"];
            $areaname=$row1["areaname"];
            $areaheading=$row1["areaheading"];
            $pincode=$row1["pincode"];
            $domainname=$row1["domainname"];
            $sequence=$row1["sequence"];
            $imageid=$row1["imageid"];
            $cancelflag=$row1["cancelflag"];
            $imagefile = "images\\".$row1["imagefilename"];
                    
            if($editareaid>0){
                
                echo "<div class='divam1e' >";
                    echo "<div class='divam2edit'>";
                    if($imageid==0){
                        echo "<input type='button' value='Add Image' class='btn1' onclick='pickupImage($areaid,\"replace\")' style='position:absolute;top:80%;center:0%;'>";   
                    }else{
                        echo "<img src=$imagefile class='img100' >";
                        echo "<input type='button' value='Change Image' class='btn1' onclick='pickupImage($areaid,\"replace\")' style='position:absolute;top:80%;center:0%;'>";   
                    }
                    echo "</div>";
                    
                    echo "<div class='divam3edit'>";
                        echo "<div class='divam6e'><div class='divam6e1'>Area Name</div><div class='divam6e2'><input type='text' name='areaname' id='areaname' value='$areaname' class='intext2' size='20'></div></div>";
                        echo "<div class='divam6e'><div class='divam6e1'>Area Heading</div><div class='divam6e2'><input type='text' name='areaheading' id='areaheading' value='$areaheading' class='intext2' size='20'></div></div>";
                        echo "<div class='divam6e'><div class='divam6e1'>PIN Code</div><div class='divam6e2'><input type='text' name='pincode' id='pincode' value='$pincode' class='intext2' size='20'></div></div>";
                        echo "<div class='divam6e'><div class='divam6e1'>Sequence</div><div class='divam6e2'><input type='text' name='sequence' id='sequence' value='$sequence' class='intext2' size='2'></div></div>";
                        echo "<div class='divam6e'><div class='divam6e1'>Domain Name</div><div class='divam6e2'><input type='text' name='domainname' id='domainname' value='$domainname' class='intext2' size='20'></div></div>";
                    echo "</div>";
                echo "</div>";
                
            }else{

                echo "<div class='divam1e' onclick='editArea($areaid)' style='cursor:pointer;'>";
                    echo "<div class='divam2e'>";
                    echo "<img src=$imagefile class='img100' >";
                    echo "</div>";

                    echo "<div class='divam3e'>";
                    echo "<div class='divam7e'>$areaname</div>";
                    echo "<div class='divam8e'>$areaheading</div>";
                    echo "<div class='divam8e'>$pincode</div>";
                    echo "<div class='divam8e'>$domainname</div>";
                    if($cancelflag==1){
                        echo "<div class='divam8e'><span style='color:red;font-size:125%'>BLOCKED</span></div>";
                    }else{
                        echo "<div class='divam8e'>$sequence</div>";
                    }
                    
                    echo "</div>";
                echo "</div>";
            }
        }
        echo "<input type='hidden' name='actionbutton' id='actionbutton' value=''>";
        echo "<input type='hidden' name='editareaid' id='editareaid' value='$editareaid'>";
?>
</div>    
    
    
<div class='divsfoot100' >
<?php    

    if($editareaid==0){

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
    
    if($editareaid>0){
    
        echo "<div class='divam4e'>";
            echo "<div ><input type='button' class='btn2' value='Update' onclick='updateItem($areaid)' ></div>";
            if($cancelflag==1){
                echo "<div><input type='button' class='btn2' value='Unblock' onclick='setAction(0)' ></div>";
            }else{
                echo "<div><input type='button' class='btn2' value='Block Area' onclick='setAction(1)' ></div>";
            }

            echo "<div><input type='button' class='btn2' value='Back' onclick='goBack()' ></div>";
            if($imageid>0){
                echo "<div><input type='button' class='btn2' value='Add New Area' onclick='newItem()' ></div>";
            }
        echo "</div>";
    }
?>    
</div>
    
    
<?php 
    } 
    //end Sellerid ==1 only 
?>
   
</form>

</body>
</html>
