<?php 
//ini_set('session.cache_limiter','public');
//session_cache_limiter(false);
session_start(); 
header('Cache-Control: max-age=900');
?>
<html>
<head>
<!--
mobile browser sathi ghatak
<meta name="viewport" content="width=device-width, initial-scale=1.0">
-->    
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>seller</title>
<style>

<?php 
require_once 'connection.php'; 

$sellerid=0;
if(isset($_POST["sellerid"])) $sellerid=$_POST["sellerid"];
if(isset($_GET["sellerid"])) $sellerid=$_GET["sellerid"];

$selproductid=0;
if(isset($_POST["selproductid"])) $selproductid=$_POST["selproductid"];

if($selproductid==0){
    $product="";
    if(isset($_GET["product"])) {
        $product=$_GET["product"];
        $idandqty=explode("_",$product);
        $selproductid=$idandqty[0];
        $qty=$idandqty[1];
    }
    
    
    
    if($selproductid>0) {
        $sellerid=getData("select sellerid from sellerproducts where productid=$selproductid", $connect);
        if($sellerid>0) {
            $areaid=getData("select areaid from sellermaster where sellerid=$sellerid", $connect);
            $_SESSION["areaid"]=$areaid;
        }
    }
}


$isMobile=is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));
include 'css/avantikablue1.css'; 
?>


</style>

<script>
    
    
    function wapporder(productid,phoneno,productname,productlink){
        var objorderqty='ordqty'+productid;
        var objwapp='wapp'+productid;
        productlink=productlink+'_'+document.getElementById(objorderqty).value;
        //document.getElementById(objwapp).href='whatsapp://send?phone='+phoneno+'&text=Please submit my order of '+productname+' [ Qty : '+document.getElementById(objorderqty).value+']';
        document.getElementById(objwapp).href=encodeURI('whatsapp://send?phone='+phoneno+'&text='+productlink);
    }

    function smsorder(productid,phoneno,productname,productlink){
        var objorderqty='ordqty'+productid;
        var objsms='sms'+productid;
        productlink=productlink+'_'+document.getElementById(objorderqty).value;

        //var msg='Please submit my order of ['+productname+'][ Qty:'+document.getElementById(objorderqty).value+']';
        var uri='sms:'+phoneno+'?body='+encodeURI(productlink);
        document.getElementById(objsms).href=uri;
    }
    
    function selectProduct(productid){
        document.getElementById('selproductid').value=productid;
        frm1.submit();
    }

    function goBack(){
        document.getElementById('selproductid').value='';
        frm1.submit();
    }

    function noBack()
    {
        window.history.forward();
    }

</script>



</head>
<body  class='bd1'>
<form name='frm1' id='frm1' action="sellerproducts.php" method="post">
    
<?php 
require_once 'sellerheader.php'; 

/*

$token = 'WoYbAK4hBltiMg7u9fGxDHTQdPspFJvSzynX5a1mCcE8062ZO33WZIGTDgomRvyuO47swt2FcpnziP6b';
$mobile = '9890215475';
$msg = 'Hi .....';
$site = 'www.waranakodoli.com';
$url = "http://api.fast2sms.com/sms.php?token=".$token."&mob=".$mobile."&mess=".$msg."&sender=".$site."&route=0";
$homepage = file_get_contents($url);
if($homepage)
{
  echo "Message Send Compleated...";
}
else{
  echo "Something Went Wrong...";
}

*/


?>

    
<div class='divsp0'  >

    <?php
        $hostname="https://".$_SERVER["HTTP_HOST"];
        $sellermobileno="+91".getData("select mobileno from sellermaster where sellerid=".$sellerid,$connect);
        
        $sql1 = "Select cp.*, (select imagefilename from productimages pi, imagemaster im where pi.imageid=im.imageid and pi.productid=cp.productid order by seq limit 1) as imagefilename from sellerproducts cp where cp.sellerid=".$sellerid;
        if($selproductid>0){
            $sql1 = $sql1." and cp.productid=".$selproductid;
        }
	$res1 = mysqli_query($connect, $sql1);
	while ($row1 = mysqli_fetch_array($res1,MYSQLI_BOTH)) {
            $productid=$row1["productid"];
            $productname=trim($row1["productname"]);
            $description=$row1["description"];
            $price=$row1["price"];
            $mrp=$row1["mrp"];
            $pricedetail=$row1["pricedetail"];
            $imagefile = "images\\".$row1["imagefilename"];
            
            if($selproductid>0){
                
                echo "<div class='divsp1a' >";

                    echo "<div class='divsp2a'>";
                        echo "<img src=$imagefile class='imgsp2a' >";
                    echo "</div>";

                    echo "<div class='divsp3a'>";
                        echo "<div class='divsp7'>$productname</div>";
                        echo "<div class='divsp8'>$description</div>";
                        echo "<div class='divsp8'>Price : <b>Rs $price</b>&nbsp;<del>$mrp</del>&nbsp;$pricedetail</div>";

                        $orderQty=0;
                        $objorderqty='ordqty'.$productid;
                        if(isset($_POST[$objorderqty])) {
                            $orderQty=$_POST[$objorderqty];
                        }else{
                            if(isset($_GET["product"])) $orderQty=$qty;
                        }
                        if($orderQty==0) $orderQty=1;

                        $imagewapp = "images\\whatsapp.png";
                        $imagesms = "images\\sms.png";
                        $imagemail = "images\\email.png";
                        $imagephone = "images\\phone.png";
                        $imageback = "images\\back.png";

                        echo "<div class='divsp7'>ORDER NOW $sellermobileno</div>";
                        echo "<div class='divsp6'>Quantity <input type='number' id='ordqty$productid' name='ordqty$productid' min='1' max='100' size=5 class='intextsp1' value='$orderQty'></div>";
                        echo "<div class='divsp6'>";
                            $productlink=$hostname."/sellerproducts.php?product=".$productid;
                            echo "<div class='divsp9'><a href='#' id='wapp$productid' name='wapp$productid' onclick='wapporder($productid,$sellermobileno,\"$productname\",\"$productlink\");' title='Whatsapp your order'><img src=$imagewapp class='imgsp1' ></a></div>";
                            echo "<div class='divsp9'><a href='#' id='sms$productid' name='sms$productid' onclick='smsorder($productid,$sellermobileno,\"$productname\",\"$productlink\");'><img src=$imagesms class='imgsp1' title='SMS your order' ></a></div>";
                            echo "<div class='divsp9'><img src=$imagephone class='imgsp1' title='Call' ></div>";
                            echo "<div class='divsp9'><img src=$imageback class='imgsp1' title='Back' onclick='goBack();' ></div>";
                        echo "</div>";


                    echo "</div>";

                echo "</div>";
                
            } else {
            
                echo "<div class='divsp1' onclick='selectProduct($productid)' style='cursor:pointer;'>";

                    echo "<div class='divsp2'>";
                        echo "<img src=$imagefile class='imgsp2' >";
                    echo "</div>";

                    echo "<div class='divsp3'>";
                        echo "<div class='divsp7'>$productname</div>";
                        echo "<div class='divsp8'>$description</div>";
                        echo "<div class='divsp8'>Price : <b>Rs $price</b>&nbsp;<del>$mrp</del>&nbsp;$pricedetail</div>";
                    echo "</div>";
                echo "</div>";
            }
        }
        
    
    ?>

</div>    

<?php echo "<input type='hidden' name='sellerid' id='sellerid' value='$sellerid'>" ?> 
<?php echo "<input type='hidden' name='selproductid' id='selproductid' value='$selproductid'>" ?>    

<?php //require_once 'sellerfooter.php';     ?>        
</form>

</body>
</html>
