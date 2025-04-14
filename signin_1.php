<?php session_start(); ?>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Seller</title>
<style>
<?php 
$areaid=$_SESSION["areaid"];
$isMobile=is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));
include 'css/atpost.css'; 
?>
</style>

<?php 

require_once 'connection.php'; 

$sellerid=0;
$actionbutton='';
if(isset($_POST['actionbutton'])) { $actionbutton=$_POST['actionbutton']; };

if($actionbutton=="Submit"){
    
    $userid=$_POST["userid"]-1111;
    $userpassword=$_POST["userpassword"];
    
    $res1 = $connect->query("select sellerid from sellermaster where sellerid='".$userid."' and password='".$userpassword."'");
    if($row1 = mysqli_fetch_array($res1)) { 
        $sellerid=$row1["sellerid"];
        $_SESSION["sellerid"]=$sellerid;
        //echo "<script>opener.frm1.submit();</script>";
        //echo "<script>opener.top.document.getElementById('mainframe').location.reload();</script>";
        //echo "<script>opener.top.location.reload();</script>";
        //header("Location:'sellermain.php'");
        //echo "<script>location.href='sellermain.php'</script>";
        //echo "<script>window.location.replace('sellermain.php');</script>";
        echo "<script>window.location.href='sellermain.php';</script>";
        
    }
}


?>
<script>
    function newRegistration(){
        window.open("registration.php");
    }

    function submitForm(){
        document.getElementById('actionbutton').value='Submit';
        frm1.submit();
    }

</script>

</head>

<body class='bd1'>
<form name='frm1' id='frm1' action='signin.php' method='post' >

<div class='divsignin0' >
<label class='divsignin1' style='cursor:pointer;' onclick='window.open("index.php");'><b>atpost.in</b></label>
<label class='divsignin1' ><b>SIGN IN</b></label>
<label class='divsignin1' style='cursor:pointer;' onclick='newRegistration();'><b>Registration</b></label>

<?php //require_once 'indexheader1.php'; 
//python
//$tmp = exec("p.py");
//echo "<label class='divsignin1' style='cursor:pointer;' onclick='newRegistration();'><b>$tmp</b></label>"


?>    


</div>

<div style='position:absolute;  top:200px; width:99%;' >

    <div class='divsignin2'>
        <span class='divsignin3'>User ID</span>
        <span class='divsignin4'>
        <?php 
            $myValue="";
            if(isset($_POST['userid'])) { $myValue=$_POST['userid']; };
            echo "<input type='text' name='userid' id='userid' value='$myValue' class='intext1' >";
        ?>
        </span>
    </div>
    <div class='divsignin2'>
        <span class='divsignin3'>Password</span>
        <span class='divsignin4'>
        <?php 
            $myValue="";
            echo "<input type='password' name='userpassword' id='userpassword' value='$myValue' class='intext1' >";
        ?>
        </span>
    </div>
    <?php 
    if($actionbutton=="Submit" && $sellerid==0){
        echo "<div class='divsignin2'>";
        echo "Invalid User Id or Password ";
        echo "</div>";
    }

    if($actionbutton=="Submit" && $sellerid>0){
        echo "<div class='divsignin2'>";
        echo "Login Successful !";
        echo "</div>";
    }
    ?>
    
    
    <div class='divsignin5'><input type='button' value='Submit' class='btn2' onclick='submitForm()'></div>            
    
    
    <div class='divsignin100' >
        <input type='button' value='Close Window' class='btn2' onclick='window.close();' >
    </div>
    <input type='hidden' name='actionbutton' id='actionbutton' value='' >
    
</div>

</form>
</body>
</html>
