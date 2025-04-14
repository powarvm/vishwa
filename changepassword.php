<?php session_start(); 
header('Cache-Control: max-age=900');
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>seller</title>
<style>

<?php 

$sellerid=0;
if(isset($_SESSION["sellerid"])) $sellerid=$_SESSION["sellerid"];

$isMobile=is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));
include 'css/avantikablue1.css'; 

?>


</style>

<script>
</script>
</head>

<?php 
require_once 'connection.php'; 
$actionbutton="";
$msg="";

$actionbutton='';
if(isset($_POST['actionbutton'])) { $actionbutton=$_POST['actionbutton']; };

if($actionbutton=="Change Password"){
    
    $userid=$_POST["userid"]-1111;
    $userpassword=$_POST["userpassword"];
    $newpassword=$_POST["newpassword"];
    $confirmpassword=$_POST["confirmpassword"];
    
    $msg="Paswword Changed Successfully !!!";
    
    $cnt= getData("select count(*) as cnt from sellermaster where sellerid='".$userid."' and password='".$userpassword."'", $connect);
    
    if($cnt==0){
        $msg="Invalid UserID or Password";
    } else {
        if(strlen($newpassword)<5){
            $msg="Password must be minimum 5 characters".$newpassword;
        } else {
            if($newpassword!=$confirmpassword ){
                $msg="New and Confirm Password not matching";
            } else {
                $res1 = $connect->query("UPDATE sellermaster set password='".$newpassword."' where sellerid=$sellerid");
            }
        }
    }
}


?>


<body class='bd1'>
    <form name='frm1' id='frm1' action="changepassword.php" method="post" >
<?php require_once 'sellerheaderedit.php'; ?>
    
<div class='divsignin0' >
    
    
    <?php 
    if(strlen($msg)>0){
        echo "<div class='divreg8'>";
        echo "<span class='divreg9'><label><h2><b>".$msg."</b></h2></label></span>";
        echo "</div>";
    }else{
    ?>    
    <div class='divsignin2'>
        <span class='divsignin3'>User ID</span>
        <span class='divsignin4'>
        <?php 
            $myValue="";
            if(isset($_POST['userid'])) { $myValue=$_POST['userid']; };
            echo "<input type='text' name='userid' id='userid' value='$myValue' class='intext2' size='10'>";
        ?>
        </span>
    </div>
    <div class='divsignin2'>
        <span class='divsignin3'>Current Password</span>
        <span class='divsignin4'>
        <?php 
            echo "<input type='password' name='userpassword' id='userpassword' value='$myValue' class='intext2' size='10'>";
        ?>
        </span>
    </div>
    
    <div class='divsignin2'>
        <span class='divsignin3'>New Password</span>
        <span class='divsignin4'>
        <?php 
            echo "<input type='password' name='newpassword' id='newpassword' value='' class='intext2' size='10'>";
        ?>
        </span>
    </div>
    
    <div class='divsignin2'>
        <span class='divsignin3'>Confirm Password</span>
        <span class='divsignin4'>
        <?php 
            echo "<input type='password' name='confirmpassword' id='confirmpassword' value='' class='intext2' size='10'>";
        ?>
        </span>
    </div>
    <br>
    <hr>
    <div class='divsignin2'>
    <input type='submit' name='actionbutton' id='actionbutton' value='Change Password' class='btn2' >
    </div>
    
    <?php 
    } 
    ?>
</div>


</form>

</body>
</html>
