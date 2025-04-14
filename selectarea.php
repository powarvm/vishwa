<?php 
session_start(); 
header('Cache-Control: max-age=900');
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>seller</title>
<style>

<?php 

$areaid=0;
if(isset($_SESSION["areaid"])) $areaid=$_SESSION["areaid"];
if($areaid=='') $areaid=0;

$backpage="index.php";
if(isset($_GET["backpage"])) $backpage=$_GET["backpage"];
if(isset($_POST["backpage"])) $backpage=$_POST["backpage"];



$isMobile=is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));
include 'css/atpost.css'; 
?>


</style>

<script>

    function resetSearch(){
        document.getElementById('searchitem').value='';
        frm1.submit();
    }

    function selectArea(areaid,backpage){
        
        if(backpage=="index.php"){
            //window.top.location='index.php?areaid='+areaid;
            //window.opener.location='indexmain.php?areaid='+areaid;
            window.top.location='indexmain.php?areaid='+areaid;
            //window.close();
            
            //window.open('index.php?areaid='+areaid);
            //window.top.close();
            //
            //window.top.location='index.php?areaid='+areaid;
            //document.getElementById('areaid').value=areaid;
            //document.getElementById('frm1').action=backpage; 
            
        }
        if(backpage=="registration.php"){
            window.opener.document.getElementById('areaid').value=areaid;
            window.opener.document.frm1.submit();
            window.close();
        }
        
        //parent.location='index.php?areaid='+areaid;
        //window.open(encodeURI('index.php?areaid='+areaid));
        //window.close();

    }

    function wappArea(phoneno){
        document.getElementById('wapparea').href='whatsapp://send?phone='+phoneno+'&text=Please add new area '+document.getElementById('newarea').value;
    }


</script>
</head>

<?php 
require_once 'connection.php'; 

$searchitem="";
if(isset($_POST["searchitem"])) $searchitem=$_POST["searchitem"];

?>

<body class='bd1'>
<form name='frm1' id='frm1' action="selectarea.php" method="post">

<div class='divsa0h' >
<!-- <label class='divsa1h' ><b>atpost.in</b></label> -->
<label class='divsa1h'  ><b>SELECT AREA</b></label>
<!-- <label class='divsa1h' ><b>atpost.in</b></label> -->
</div>

    
    
<div class='divsa0' >
    
<?php
echo "<div class='divsa0' >";
    
    
    echo "<div class='divsa1a'>";
        
    $sql1 = " Select am.areaid, am.areaname, am.areaheading, am.pincode, am.domainname, am.sequence, coalesce(am.imageid,0) as imageid, coalesce(im.imagefilename,'') as  imagefilename  from areamaster am ";
    $sql1 = $sql1." left join imagemaster im on im.imageid=am.imageid ";
    $sql1 = $sql1." where am.cancelflag=0 ";
    $sql1 = $sql1." and ( (upper(am.areaname) like '%".strtoupper($searchitem)."%') or (upper(am.areaheading) like '%".strtoupper($searchitem)."%') or (am.pincode like '%".strtoupper($searchitem)."%'))";
    $sql1 = $sql1." order by case when am.areaid=$areaid then 0 else 1 end, am.pincode";
        
	$res1 = mysqli_query($connect, $sql1);
	while ($row1 = mysqli_fetch_array($res1,MYSQLI_BOTH)) {
            $xareaid=$row1["areaid"];
            $areaname=$row1["areaname"];
            $areaheading=$row1["areaheading"];
            $pincode=$row1["pincode"];
            $domainname=$row1["domainname"];
            $sequence=$row1["sequence"];
            $imageid=$row1["imageid"];
            $imagefile = "images\\".$row1["imagefilename"];
            
            if($areaid==$xareaid){
                echo "<div class='divsa1' onclick='selectArea($xareaid,\"$backpage\")' style='cursor:pointer;'>";
                    echo "<div class='divsa3'>";
                        echo "<div class='divsa7'><b>$areaheading</b></div>";
                        echo "<div class='divsa8'><b>$pincode</b></div>";
                    echo "</div>";
                echo "</div>";
            } else {
                echo "<div class='divsa1' onclick='selectArea($xareaid,\"$backpage\")' style='cursor:pointer;'>";
                    echo "<div class='divsa3'>";
                        echo "<div class='divsa7'>$areaheading</div>";
                        echo "<div class='divsa8'>$pincode</div>";
                    echo "</div>";
                echo "</div>";
            }
        }
    echo "</div>";
echo "</div>";

echo "<input type='hidden' name='areaid' id='areaid' value='$areaid'>";
echo "<input type='hidden' name='backpage' id='backpage' value='$backpage'>";

echo "<div class='divsa100' >";

    echo "<div class='divsa1a'>";
        //echo "<div class='divsa1'>";
                echo "<div class='divsa10'><input type='text' name='searchitem' id='searchitem' value='$searchitem' class='intext3' ></div>";
                echo "<div class='divsa11'><input type='submit' name='button' id='button' value='Search'  class='btn1' >&nbsp;<input type='button' name='button' id='button' value='Reset' onclick='resetSearch()'  class='btn1' ></div>";
        //echo "</div>";
    
    /*
        echo "<div class='divsa1'>";
            echo "<div class='divsa3'>";
                $imagewapp = "images\\whatsapp.png";
                echo "<label style='margin:5px;'><label class='labelsa1'>NEW AREA REQUEST</label><input type='text' name='newarea' id='newarea' value='' class='intext1' size=10><a href='#' id='wapparea' name='wapparea' onclick='wappArea(\"919890215475\");' title='Whatsapp your new area'><img src=$imagewapp class='imgsa1' ></a></label>";
            echo "</div>";
        echo "</div>";
     * 
     */
    echo "</div>";
    
echo "</div>";

?>
    
</form>

</body>
</html>
