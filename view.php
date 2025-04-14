<?php 
// Include the database configuration file  
require_once 'dbconfig.php'; 
 
// Get image data from database 
$result = $db->query("SELECT imagefile FROM imagemaster where imageid=17"); 
?>

<?php if($result->num_rows > 0){ ?> 
    <div class="gallery"> 
        <?php while($row = $result->fetch_assoc()){ ?> 
            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['imagefile']); ?>" /> 
        <?php } ?> 
    </div> 
<?php }else{ ?> 
    <p class="status error">Image(s) not found...</p> 
<?php } ?>