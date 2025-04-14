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
$areaid=0;
if(isset($_SESSION["areaid"])) $areaid=$_SESSION["areaid"];
if(isset($_POST["areaid"])) $areaid=$_POST["areaid"];

require_once 'connection.php'; 

$isMobile=is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));
include 'css/atpost.css'; 

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
        window.open("signin.php");
    }
    
    
    
</script>
</head>

<?php 
$sellerid=0;
$actionbutton="";
if(isset($_POST["actionbutton"])) $actionbutton=$_POST["actionbutton"];
if($actionbutton=='Submit'){ 
    
   

    $sellername=$_POST["sellername"];
    //$sellernamemarathi=$_POST["sellernamemarathi"];
    $sellernamemarathi=$_POST["sellername"];
    $contactperson=$_POST["contactperson"];
    $mobileno=$_POST["mobileno"];
    $othermobilenos=$_POST["othermobilenos"];
    $emailid=$_POST["emailid"];
    $website=$_POST["website"];
    $address=$_POST["address"];
    
    //if($sellernamemarathi=="") $sellernamemarathi=$sellername;
    

    $password=rand(1000,9999);
    $sellerid=getData("select max(sellerid)+1 as sellerid from sellermaster", $connect);
    
    if ($connect->query("INSERT into sellermaster (sellerid,areaid,sellername,sellernamemarathi,contactperson,mobileno,othermobilenos,emailid,website,address,password,flashdate, subdomain1) VALUES ($sellerid,'$areaid','$sellername','$sellernamemarathi','$contactperson','$mobileno','$othermobilenos','$emailid','$website','$address','$password',CURRENT_DATE + INTERVAL 15 DAY, replace(lower('$sellername'),' ',''))")){ 
    
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
    }else{
        $sellerid=0;
        echo "<script>alert('Sorry, Some thing is wrong ... ')</script>";
    }
} 
?>


<body  class='bd1'>
<form name='frm1' id='frm1' action='registration.php' method='post' >


<div class='divreg0' >
<label class='divreg1' style='cursor:pointer;' onclick='window.open("index.php");'><b>atpost.in</b></label>
<label class='divreg1' ><b>REGISTRATION</b></label>
<label class='divreg1' style='cursor:pointer;' onclick='signIn();'><b>Sign In</b></label>
</div>
 
   
<div class='divreg0a'  >
<?php    

if($sellerid>0){
    
    $newsellerid=$sellerid+1111;
    $password="9999";
    $sellername="";
    $res1 = $connect->query("select sellername, password,directlink from sellermaster where sellerid=".$sellerid);
    if($row1 = mysqli_fetch_array($res1)) { 
        $sellername=$row1["sellername"]; 
        $password=$row1["password"]; 
        $directlink="https://www.".$_SERVER["HTTP_HOST"]."/".$row1["directlink"]; 
    }

    echo "<div class='divreg8'>";
    echo "<div class='divreg9'><label><h1><b><u>$sellername</u></b></h1></label></div>";
    echo "<div class='divreg9'><label><h2><b>Thank you for Registration</b></h2></label></div>";
    echo "<div class='divreg9'><label><h3>Your User ID is <b>$newsellerid</b>&nbsp;and Password is <b><u>$password</u></h3></label></div>";
    echo "<div class='divreg9'><label><h2><b><u>Your website link is</u></b></h2></label></div>";
    echo "<div class='divreg10'><label onclick='window.open(\"$directlink\")' style='cursor:pointer;'><h3>$directlink</h3></label></div>";
    echo "<div class='divreg9'><label><h3>You have to Sign in to Update your Website</h3></label></div>";
    echo "</div>";

    echo "<hr>";
    
    echo "<div class='divreg2a'>";
        echo "<div class='divreg7'><input type='button' value='Sign In' class='btn2' onclick='signIn();' >&nbsp;<input type='button' value='Close' class='btn2' onclick='window.close();' ></div>";
    echo "</div>";
    
} else {
?>

    <div class='divreg2'>
        <div class='divreg3'>Area Name</div>
        <div class='divreg4'><label onclick='window.open("selectarea.php?backpage=registration.php")'><b>
        <?php 
            $areaname="Select";
            if($areaid>0) $areaname=getData("select areaheading from areamaster where areaid=$areaid", $connect);
            echo $areaname;
            echo "<input type='hidden' name='areaid' id='areaid' value='$areaid'>"
        ?>
        </b></label></div>
    </div>
    
    
    

    <div class='divreg2'>
        <div class='divreg3'>Business</div>
        <div class='divreg4'>
        <?php 
            echo "<input type='text' name='sellername' id='sellername' value='' placeholder='Business Name ... ' class='intext2' >";
        ?>
        </div>
    </div>
    <!--
    <div class='divreg2'>
        <div class='divreg3'>व्यवसाय</div>
        <div class='divreg4'>
        <?php 
       //     echo "<input type='text' name='sellernamemarathi' id='sellernamemarathi' value='' placeholder='व्यवसायाचे मराठी मध्ये नाव .... ' class='intext2' >";
        ?>
        </div>
    </div>
    -->

    <div class='divreg2'>
        <div class='divreg3'>Name</div>
        <div class='divreg4'>
        <?php 
            echo "<input type='text' name='contactperson' id='contactperson' value='' placeholder='Contact Person Name ...' class='intext2' >";
        ?>
        </div>
    </div>


    <div class='divreg2'>
        <div class='divreg3'>Mobile No</div>
        <div class='divreg4'>
        <?php 
            echo "<input type='text' name='mobileno' id='mobileno' value='' class='intext2' >";
        ?>
        </div>
    </div>

    <div class='divreg2'>
        <div class='divreg3'>Mobile No</div>
        <div class='divreg4'>
        <?php 
            echo "<input type='text' name='othermobilenos' id='othermobilenos' value='' placeholder='Other Mobile No ... '  class='intext2' >";
        ?>
        </div>
    </div>

    <div class='divreg2'>
        <div class='divreg3'>Address</div>
        <div class='divreg4'>
        <?php 
            echo "<input type='text' name='address' id='address' value='' class='intext2' >";
        ?>
        </div>
    </div>

    <div class='divreg2'>
        <div class='divreg3'>Email</div>
        <div class='divreg4'>
        <?php 
            echo "<input type='text' name='emailid' id='emailid' value='' class='intext2' >";
        ?>
        </div>
    </div>

    <div class='divreg2'>
        <div class='divreg3'>WebSite</div>
        <div class='divreg4'>
        <?php 
            echo "<input type='text' name='website' id='website' value='' class='intext2' >";
        ?>
        </div>
    </div>


    <div class='divreg2'>
        <div class='divreg6'>Business Category</div>
    </div>

    <div class='divreg2a'>

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

    <div class='divreg100' >
        <div class='divreg11'><input type='button' value='Close Window' class='btn2' onclick='window.close();' ></div>
        <div class='divreg11'><input type='button' value='Submit' class='btn2' onclick='submitForm()'></div>            
    </div>
    


</div>
<input type='hidden' name='actionbutton' id='actionbutton' value='' >
<?php
}
?>
   

</form>
</body>
</html>
