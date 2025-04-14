<?php 
//ini_set('session.cache_limiter','public');
//session_cache_limiter(false);
session_start(); 
header('Cache-Control: max-age=900');
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Seller</title>
<style>
<?php
$areaid=$_SESSION["areaid"];

require_once 'connection.php'; 

$isMobile=is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));
include 'css/avantika.css'; 

?>


</style>

<script>
    function submitForm(){
        if(document.getElementById('sellername').value==''){ 
            alert('Trading Name must not empty'); 
            document.getElementById('sellername').focus();
            return false;
        }
        
        if(document.getElementById('contactperson').value==''){ 
            alert('Contact Name must not empty'); 
            document.getElementById('contactperson').focus();
            return false;
        }
        
        if(document.getElementById('mobileno').value==''){ 
            alert('Mobile Number must not empty'); 
            document.getElementById('mobileno').focus();
            return false;
        }

        if(document.getElementById('address').value==''){ 
            alert('Address must not empty'); 
            document.getElementById('address').focus();
            return false;
        }
        
        var nCat=eval(document.getElementById('ncat').value);
        var obj='';
        while(nCat>=1){
            obj='cat'+nCat;
            if(document.getElementById(obj).checked){
                break;
            }
            nCat--;
        }
        
        if(nCat==0){
            alert('Minimum one Category must selected'); 
            return false;
        }
        document.getElementById('actionbutton').value='Submit';
        frm1.submit();
        return true;

    }
    
    function selCategory(ncat){
        var obj='cat'+ncat;
        if(document.getElementById(obj).checked){
            document.getElementById(obj).checked= false;
        }else{
            document.getElementById(obj).checked= true;
        }
        setClass(ncat);
    }
    
    function setClass(ncat){
        var obj='cat'+ncat;
        var divobj='divcat'+ncat;
        if(document.getElementById(obj).checked){
            document.getElementById(divobj).className='divreg5sel' ;
        }else{
            document.getElementById(divobj).className='divreg5' ;
        }
    }
    
    function noBack()
    {
        window.close();
    }
    
    function signIn(){
        window.open("sellersignin.php");
    }
    
    
    
</script>
</head>

<?php 
$sellerid=0;
$actionbutton="";
if(isset($_POST["actionbutton"])) $actionbutton=$_POST["actionbutton"];
if($actionbutton=='Submit'){ 
    
    $res1 = $connect->query("select max(sellerid)+1 as sellerid from sellermaster");
    if($row1 = mysqli_fetch_array($res1)) { $sellerid=$row1["sellerid"]; }

    $sellername=$_POST["sellername"];
    $contactperson=$_POST["contactperson"];
    $mobileno=$_POST["mobileno"];
    $othermobilenos=$_POST["othermobilenos"];
    $emailid=$_POST["emailid"];
    $website=$_POST["website"];
    $address=$_POST["address"];

    $password=rand(1000,9999);
    
    $connect->query("INSERT into sellermaster (sellerid,areaid,sellername,sellernamemarathi,contactperson,mobileno,othermobilenos,emailid,website,address,password,flashdate) VALUES ($sellerid,'$areaid','$sellername','$sellername','$contactperson','$mobileno','$othermobilenos','$emailid','$website','$address','$password',CURRENT_DATE + INTERVAL 15 DAY)"); 
    
    
    $nCat=$_POST["ncat"];
    while ($nCat>=1) {
        $cat='cat'.$nCat;
        if(isset($_POST["$cat"])){
            $categoryid=$_POST["$cat"];
            $connect->query("INSERT into sellercategory (sellerid,categoryid) VALUES ($sellerid,$categoryid)"); 
        }
        $nCat--;
    }
    
    $connect->query("INSERT into sellermenu (sellerid,menuid,seq) VALUES ($sellerid,1,10), ($sellerid,2,20)"); 
    
} 
?>


<body  class='bd1'>
<form name='frm1' id='frm1' action='sellerregistration.php' method='post' >

<div style='position: fixed; top:0; width:100%; background-color:  #ffffff; z-index: 1;' >
<div class='divreg1'><label style='font-size:150%'><u><b>NEW REGISTRATION</b></u></label></div>    
<?php //require_once 'indexheader1.php'; ?>    
<div class='divreg0' >
<label style='cursor:pointer' onclick='signIn();' >Already Registered ? </label>    
</div>
</div>
    
<div style='position:absolute; top:160px; width:100%;' >
<?php    

if($sellerid>0){
    
    $newsellerid=$sellerid+1111;
    $password="9999";
    $sellername="";
    $res1 = $connect->query("select sellername, password from sellermaster where sellerid=".$sellerid);
    if($row1 = mysqli_fetch_array($res1)) { $sellername=$row1["sellername"]; $password=$row1["password"]; }

    echo "<div class='divreg8'>";
    echo "<span class='divreg9'><label><h1><b><u>$sellername</u></b></h1></label></span>";
    echo "<span class='divreg9'><label><h2><b>Thank you for Registration</b></h2></label></span>";
    echo "<span class='divreg9'><label><h3>Your User ID is <b>$newsellerid</b>&nbsp;and Password is <b><u>$password</u></h3></label></span>";
    echo "</div>";

    echo "<hr>";
    
    echo "<div class='divreg2'>";
        echo "<span class='divreg7'><input type='button' value='Close' class='btn2' onclick='window.close();' ></span>";
    echo "</div>";
    
} else {
?>

    
    <div class='divreg2'>
        <span class='divreg3'>Area Name</span>
        <span class='divreg4'><label style='font-size:150%'><u>
        <?php 
            echo getData("select areaheading from areamaster where areaid=$areaid", $connect);
        ?>
        </u></label></span>
    </div>
    

    <div class='divreg2'>
        <span class='divreg3'>Business/Company Name</span>
        <span class='divreg4'>
        <?php 
            echo "<input type='text' name='sellername' id='sellername' value='' class='intext2' size='20'>";
        ?>
        </span>
    </div>

    <div class='divreg2'>
        <span class='divreg3'>Contact Person</span>
        <span class='divreg4'>
        <?php 
            echo "<input type='text' name='contactperson' id='contactperson' value='' class='intext2' size='20'>";
        ?>
        </span>
    </div>


    <div class='divreg2'>
        <span class='divreg3'>Mobile No</span>
        <span class='divreg4'>
        <?php 
            echo "<input type='text' name='mobileno' id='mobileno' value='' class='intext2' size='20'>";
        ?>
        </span>
    </div>

    <div class='divreg2'>
        <span class='divreg3'>Other Mobile No</span>
        <span class='divreg4'>
        <?php 
            echo "<input type='text' name='othermobilenos' id='othermobilenos' value='' class='intext2' size='20'>";
        ?>
        </span>
    </div>

    <div class='divreg2'>
        <span class='divreg3'>Address</span>
        <span class='divreg4'>
        <?php 
            echo "<input type='text' name='address' id='address' value='' class='intext2' size='20'>";
        ?>
        </span>
    </div>

    <div class='divreg2'>
        <span class='divreg3'>Email</span>
        <span class='divreg4'>
        <?php 
            echo "<input type='text' name='emailid' id='emailid' value='' class='intext2' size='20'>";
        ?>
        </span>
    </div>

    <div class='divreg2'>
        <span class='divreg3'>WebSite</span>
        <span class='divreg4'>
        <?php 
            echo "<input type='text' name='website' id='website' value='' class='intext2' size='20'>";
        ?>
        </span>
    </div>


    <div class='divreg2'>
        <span class='divreg6'>Business Category</span>
    </div>

    <div class='divreg2'>

        <?php 

            $sql1 = "Select * from categorymaster order by sequence";
            $res1 = mysqli_query($connect, $sql1);

            $ncat=0;
            $ncol=0;

            while ($row1 = mysqli_fetch_array($res1)) {
                $ncat++;
                $categoryid=$row1["categoryid"];
                $categoryname=$row1["categoryname"];

                echo "<div id='divcat$ncat' class='divreg5'><input type='checkbox' id='cat$ncat' name='cat$ncat' value='$categoryid' onclick='setClass($ncat)'><label style='margin:5px;' onclick='selCategory($ncat)'>".$categoryname."</label></div>";
            }
            echo "<input type='hidden' name='ncat' id='ncat' value='$ncat' >";
        ?>
    </div>    
    <hr>
    <div class='divreg2'>
        <span class='divreg7'><input type='button' value='Submit' class='btn2' onclick='submitForm()'></span>            
        <span class='divreg7'><input type='button' value='Close Window' class='btn2' onclick='window.close();' ></span>
    </div>

    </div>
    <input type='hidden' name='actionbutton' id='actionbutton' value='' >
<?php
}
?>
   

</form>
</body>
</html>
