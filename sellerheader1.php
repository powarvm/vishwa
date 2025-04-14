<div style='position: fixed; top:0; width:100%; background-color:  #ffffff; z-index: 1;' >
<?php 

$sql1  = " SELECT coalesce(im.imagefilename,'blankimage.jpg') as imagefilename ";
$sql1  = $sql1." FROM `areamaster` a ";
$sql1  = $sql1." inner join imagemaster im on im.imageid=a.imageid ";
$sql1  = $sql1." where a.areaid=".$_SESSION["areaid"];
$res1 = mysqli_query($connect, $sql1);
if($row1 = mysqli_fetch_array($res1)) {
    $area_imagefile="images\\".$row1["imagefilename"];
}


//$sql1 = "Select sim.sellerimageid,sim.imageid,im.imagefilename from sellerimagemaster sim inner join imagemaster im on sim.imageid=im.imageid where sim.sellerid=".$_GET["sellerid"];

$sql1  = " SELECT sm.sellernamemarathi, sm.address, sm.mobileno,sm.othermobilenos, coalesce(ims.imageid, 0) as imageid, coalesce(sim.sellerimageid,0) as sellerimageid, coalesce(ims.imagefilename,'x') as imagefilename ";
$sql1  = $sql1." FROM `sellermaster` sm ";
$sql1  = $sql1." left join sellerimagemaster sim on sim.sellerid=sm.sellerid and imagetypeid=2 ";
$sql1  = $sql1." left join imagemaster ims on ims.imageid=sim.imageid ";
$sql1  = $sql1." WHERE sm.sellerid=".$sellerid;

$res1 = mysqli_query($connect, $sql1);
if($row1 = mysqli_fetch_array($res1)) {
    
    $sellerimageid=$row1["sellerimageid"];
    $imagefile='';
    if($sellerimageid==0){
        $res2=mysqli_query($connect, "SELECT im.imagefilename from sellercategory sc, categorymaster cm, imagemaster im  where sc.categoryid=cm.categoryid and cm.imageid=im.imageid and sc.sellerid=".$sellerid." LIMIT 1");
        if($row2 = mysqli_fetch_array($res2)) {
            $imagefile="images\\".$row2["imagefilename"];
        }
    }else{
        $imageid=$row1["imageid"];
        $imagefile="images\\".$row1["imagefilename"];
    }
    echo "<div width='100%' class='divs1'>";
        echo "<div class='divs2'>";
        echo "<img src=$imagefile class='img2' >";
        echo "</div>";

        echo "<div class='divs3'>";
            $sellername=$row1["sellernamemarathi"];
            echo "<div class='divs5'>";
                echo "<label onclick='openArea();' ><b>$sellername</b></label>";
            echo "</div>";
            echo "<div class='divs5'>";
                echo $row1["address"].','.$row1["mobileno"].' '. $row1["othermobilenos"];        
            echo "</div>";
        echo "</div>";

        echo "<div class='divs4'>";
            echo "<img src=$area_imagefile class='img2' >";
        echo "</div>";
    echo "</div>";
}

require_once 'sellerheader2.php'; 

?>	
</div>