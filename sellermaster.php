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

$showall=0;
if(isset($_POST["showall"])) $showall=$_POST["showall"];

$isMobile=is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));
include 'css/avantikablue1.css'; 
?>


</style>

<script>

    function resetSearch(){
        document.getElementById('searchitem').value='';
        frm1.submit();
    }

    function setShowall(showall){
        document.getElementById('showall').value=showall;
        frm1.submit();
    }

    function editSeller(xsellerid){
            window.open("sellermasteredit.php?xsellerid="+xsellerid);
    }
    


</script>
</head>

<?php 
require_once 'connection.php'; 

$searchitem="";
if(isset($_POST["searchitem"])) $searchitem=$_POST["searchitem"];


$actionbutton="";
if(isset($_POST["actionbutton"])) $actionbutton=$_POST["actionbutton"];

?>

<body class='bd1'>
<form name='frm1' id='frm1' action="sellermaster.php" method="post">
    
<?php require_once 'sellerheaderedit.php'; ?>
<div class='divam0e' >
    
<?php
    
    
        $sql1 = " Select am.sellerid, am.sellername, am.sellernamemarathi, am.address, am.contactperson, am.mobileno, am.othermobilenos, coalesce(sim.imageid,0) as imageid, coalesce(im.imagefilename,'') as  imagefilename  from sellermaster am ";
        $sql1 = $sql1." left join sellerimagemaster sim on sim.sellerid=am.sellerid and sim.imagetypeid=2 ";
        $sql1 = $sql1." left join imagemaster im on im.imageid=sim.imageid ";
        $sql1 = $sql1." where 1=1 ";
        if($showall==0){
            $sql1 = $sql1." and am.cancelflag=2 ";
        }
        $sql1 = $sql1." and ( (upper(am.sellername) like '%".strtoupper($searchitem)."%') )";
        $sql1 = $sql1." order by am.sellername";
        
        
	$res1 = mysqli_query($connect, $sql1);
	while ($row1 = mysqli_fetch_array($res1,MYSQLI_BOTH)) {
            $xsellerid=$row1["sellerid"];
            $sellername=$row1["sellername"];
            $sellernamemarathi=$row1["sellernamemarathi"];
            $address=$row1["address"];
            $contactperson=$row1["contactperson"];
            $mobileno=$row1["mobileno"];
            $othermobilenos=$row1["othermobilenos"];
            $imageid=$row1["imageid"];
            $imagefile = "images\\".$row1["imagefilename"];
            
            if($imageid==0){
                $imagefile= getData("SELECT im.imagefilename FROM sellercategory sc inner join categorymaster cm on cm.categoryid=sc.categoryid left join imagemaster im on im.imageid=cm.imageid where sc.sellerid=$xsellerid limit 1", $connect);
                $imagefile = "images\\".$imagefile;
            }
                    
            echo "<div class='divam1e' onclick='editSeller($xsellerid)' style='cursor:pointer;'>";
                echo "<div class='divam2e'>";
                echo "<img src=$imagefile class='img100' >";
                echo "</div>";

                echo "<div class='divam3e'>";
                echo "<div class='divam7e'>$sellernamemarathi</div>";
                echo "<div class='divam8e'>$address</div>";
                echo "<div class='divam8e'>$contactperson</div>";
                echo "<div class='divam8e'>$mobileno</div>";
                echo "<div class='divam8e'>$othermobilenos</div>";

                echo "</div>";
            echo "</div>";
        }
        echo "<input type='hidden' name='actionbutton' id='actionbutton' value=''>";
?>
</div>    
    
    
<div class='divsfoot100' >
<?php    


        echo "<div class='divam4e'>";
            $searchimage="images\\search.png";
            echo "<div style='display:flex;margin:10px;width:60%'><div style='width:90%' ><input type='text' name='searchitem' id='searchitem' value='$searchitem' class='intext2' ></div><div style='margin:10px; padding:5px;'><img src=$searchimage class='imgindex2' onclick='frm1.submit();' ></div></div>";

            if($showall==1){
                echo "<input type='button' onclick='setShowall(0)' value='Show New Only'  class='btn2'>";
            }else{
                echo "<input type='button' onclick='setShowall(1)' value='Show All'  class='btn2'>";
            }
            echo "<input type='hidden' name='showall' id='showall' value='$showall'>";
        echo "</div>";


    
?>    
</div>
    
   
</form>

</body>
</html>
