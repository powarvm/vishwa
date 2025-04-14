<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Header</title>
<style>
    <?php include 'css/avantika.css'; ?>
</style>
</head>
<body class='bd1'>

<script>
function openWebsite(website){
	window.open(website);
}
</script>

<?php 	require_once 'connection.php'; ?>


<?php 


$sql1  = " SELECT sm.*, coalesce(ims.imageid, 0) as imageid, coalesce(sim.sellerimageid,0) as sellerimageid, coalesce(ims.imagefilename,'x') as imagefilename ";
$sql1  = $sql1." FROM `sellermaster` sm ";
$sql1  = $sql1." left join sellerimagemaster sim on sim.sellerid=sm.sellerid and imagetypeid=2 ";
$sql1  = $sql1." left join imagemaster ims on ims.imageid=sim.imageid ";
$sql1  = $sql1." WHERE sm.sellerid=".$_GET['sellerid'];

$res1 = mysqli_query($connect, $sql1);


if($row1 = mysqli_fetch_array($res1)) {
    
    
        $sellerimageid=$row1["sellerimageid"];
        $imagefile='';
        if($sellerimageid==0){
            $res2=mysqli_query($connect, "SELECT im.imagefilename from sellercategory sc, categorymaster cm, imagemaster im  where sc.categoryid=cm.categoryid and cm.imageid=im.imageid and sc.sellerid=".$_GET['sellerid']." LIMIT 1");
            if($row2 = mysqli_fetch_array($res2)) {
                $imagefile="images\\".$row2["imagefilename"];
            }
        }else{
            $imageid=$row1["imageid"];
            $imagefile="images\\".$row1["imagefilename"];
        }
        ?>

        <div class='divdash1'  style='position:absolute; z-index:-1; top:70px; width:99%;' >


        <div class='divdash2'>
            <span class='divdash6'><label>
            <?php echo "<img src=$imagefile class='img2' >" ?>
            </label></span>
            <span class='divdash4'><label>
            <?php echo $row1["sellernamemarathi"]; ?>
            </label></span>
        </div>
            <hr>

        <div class='divdash2'>
            <span class='divdash5'>Address</span>
            <span class='divdash3'><label>
            <?php echo $row1["address"]; ?>
            </label></span>
        </div>

        <div class='divdash2'>
            <span class='divdash5'>Contact</span>
            <span class='divdash3'><label>
            <?php echo $row1["contactperson"]; ?>
            </label></span>
        </div>

        <div class='divdash2'>
            <span class='divdash5'>Call</span>
            <span class='divdash3'><label>
            <?php echo $row1["mobileno"]." ". $row1["othermobilenos"]; ?>
            </label></span>
        </div>



        <div class='divdash2'>
            <span class='divdash5'>Email</span>
            <span class='divdash3'><label>
            <?php echo $row1["emailid"]; ?>
            </label></span>
        </div>

        <div class='divdash2'>
            <span class='divdash5'>Website</span>
            <span class='divdash3'><label>
            <?php 
            $website=$row1["website"];
            echo "<a href='#' onclick='openWebsite(\"$website\");'>$website</a>";
            ?>
            </label></span>
        </div>



        <div class='divdash2'>
            <span class='divdash5'>Close Day</span>
            <span class='divdash3'><label>
            <?php echo $row1["closeday"]; ?>
            </label></span>
        </div>

        </div>

	
<?php 	
}
?>

</body>
</html>
