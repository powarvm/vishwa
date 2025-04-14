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
$sessionsellerid=0;
if(isset($_SESSION["sellerid"])) $sessionsellerid=$_SESSION["sellerid"];

$sellerid=0;
if($sessionsellerid==1){
    if(isset($_POST["xsellerid"])) {
        $sellerid=$_POST["xsellerid"];
    }else{
        if(isset($_GET["xsellerid"])) $sellerid=$_GET["xsellerid"];
    }
}


require_once 'connection.php'; 

$isMobile=is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));
include 'css/avantikablue1.css'; 

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
        document.getElementById('actionbutton').value='Update';
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
    
    function setCancelflag(actionbutton){
        document.getElementById('actionbutton').value=actionbutton;
        frm1.submit();
    }
    
    
    
</script>
</head>

<body class='bd1'>

<?php 



$actionbutton="";
if(isset($_POST["actionbutton"])) $actionbutton=$_POST["actionbutton"];
if($actionbutton=='Update'){ 
    
    $sellername=$_POST["sellername"];
    $sellernamemarathi=$_POST["sellernamemarathi"];
    $contactperson=$_POST["contactperson"];
    $mobileno=$_POST["mobileno"];
    $othermobilenos=$_POST["othermobilenos"];
    $emailid=$_POST["emailid"];
    $website=$_POST["website"];
    $address=$_POST["address"];
    $subdomain=$_POST["subdomain"];
    $subdomain1=$_POST["subdomain1"];
    $domainname=$_POST["domainname"];
    
    if($sellernamemarathi=="") $sellernamemarathi=$sellername;

            
    $connect->query("UPDATE sellermaster set sellername='$sellername',sellernamemarathi='$sellernamemarathi',contactperson='$contactperson',mobileno='$mobileno',othermobilenos='$othermobilenos',emailid='$emailid',website='$website',address='$address',subdomain='$subdomain',subdomain1='$subdomain1',domainname='$domainname' where sellerid=$sellerid"); 
    
    $nCat=$_POST["ncat"];
    while ($nCat>=1) {
        $cat='cat'.$nCat;
        $prvcat='prvcat'.$nCat;
        if(isset($_POST["$cat"])){
            if($_POST["$prvcat"]==0){
                $categoryid=$_POST["$cat"];
                $connect->query("INSERT into sellercategory (sellerid,categoryid) VALUES ($sellerid,$categoryid)"); 
            }
        }else{
            if($_POST["$prvcat"]>0){
                $connect->query("DELETE from sellercategory where id=".$_POST["$prvcat"]); 
            }
        }
        $nCat--;
    }

    $nmenu=$_POST["nmenu"];
    while ($nmenu>=1) {
        $menu='menu'.$nmenu;
        $prvmenu='prvmenu'.$nmenu;
        if(isset($_POST["$menu"])){
            if($_POST["$prvmenu"]==0){
                $menuid=$_POST["$menu"];
                $connect->query("INSERT into sellermenu (sellerid,menuid,seq) VALUES ($sellerid,$menuid,10)"); 
            }
        }else{
            if($_POST["$prvmenu"]>0){
                $connect->query("DELETE from sellermenu where sellermenuid=".$_POST["$prvmenu"]); 
            }
        }
        $nmenu--;
    }

    
} 


if($actionbutton=='setcancelflag1'){ 
    $connect->query("UPDATE sellermaster set cancelflag=1 where sellerid=$sellerid"); 
}

if($actionbutton=='setcancelflag0'){ 
    $connect->query("UPDATE sellermaster set cancelflag=0 where sellerid=$sellerid"); 
}


?>

<form name='frm1' id='frm1' action='sellermasteredit.php' method='post' >
    
    
<div class='divreg0' >
<label class='divreg1' style='cursor:pointer;' onclick='window.open("index.php");'><b>atpost.in</b></label>
<label class='divreg1' ><b>SELLER PROFILE</b></label>
<label class='divreg1' style='cursor:pointer;' onclick='window.open("index.php");'><b>atpost.in</b></label>
</div>
    
<div class='divreg0e'  >
    
<?php    
if($sellerid>0){
    $res1 = $connect->query("select * from sellermaster where sellerid=".$sellerid);
    if($row1 = mysqli_fetch_array($res1)) { 
        $sellername=$row1["sellername"];
        $sellernamemarathi=$row1["sellernamemarathi"];
        $contactperson=$row1["contactperson"];
        $mobileno=$row1["mobileno"];
        $othermobilenos=$row1["othermobilenos"];
        $emailid=$row1["emailid"];
        $website=$row1["website"];
        $address=$row1["address"];
        $cancelflag=$row1["cancelflag"];
        $subdomain=$row1["subdomain"];
        $subdomain1=$row1["subdomain1"];
        $domainname=$row1["domainname"];
        $password=$row1["password"];
        
    }

    ?>

    <div class='divreg2'>
        <span class='divreg3'>Business Name</span>
        <span class='divreg4'>
        <?php 
            echo "<input type='text' name='sellername' id='sellername' value='$sellername' class='intext2' size='20'>";
        ?>
        </span>
    </div>

    <div class='divreg2'>
        <span class='divreg3'>व्यवसायाचे नाव</span>
        <span class='divreg4'>
        <?php 
            echo "<input type='text' name='sellernamemarathi' id='sellernamemarathi' value='$sellernamemarathi' class='intext2' size='20'>";
        ?>
        </span>
    </div>
    
    
    <div class='divreg2'>
        <span class='divreg3'>Contact Person</span>
        <span class='divreg4'>
        <?php 
            echo "<input type='text' name='contactperson' id='contactperson' value='$contactperson' class='intext2' size='20'>";
        ?>
        </span>
    </div>


    <div class='divreg2'>
        <span class='divreg3'>Mobile No</span>
        <span class='divreg4'>
        <?php 
            echo "<input type='text' name='mobileno' id='mobileno' value='$mobileno' class='intext2' size='20'>";
        ?>
        </span>
    </div>

    <div class='divreg2'>
        <span class='divreg3'>Other Mobile No</span>
        <span class='divreg4'>
        <?php 
            echo "<input type='text' name='othermobilenos' id='othermobilenos' value='$othermobilenos' class='intext2' size='20'>";
        ?>
        </span>
    </div>

    <div class='divreg2'>
        <span class='divreg3'>Address</span>
        <span class='divreg4'>
        <?php 
            echo "<input type='text' name='address' id='address' value='$address' class='intext2' size='20'>";
        ?>
        </span>
    </div>

    <div class='divreg2'>
        <span class='divreg3'>Email</span>
        <span class='divreg4'>
        <?php 
            echo "<input type='text' name='emailid' id='emailid' value='$emailid' class='intext2' size='20'>";
        ?>
        </span>
    </div>

    <div class='divreg2'>
        <span class='divreg3'>WebSite</span>
        <span class='divreg4'>
        <?php 
            echo "<input type='text' name='website' id='website' value='$website' class='intext2' size='20'>";
        ?>
        </span>
    </div>
    
    
    <div class='divreg2'>
        <span class='divreg3'>Sub Domain</span>
        <span class='divreg4'>
        <?php 
            echo "<input type='text' name='subdomain' id='subdomain' value='$subdomain' class='intext2' size='20'>";
        ?>
        </span>
    </div>
    
    <div class='divreg2'>
        <span class='divreg3'>Sub Domain Tag</span>
        <span class='divreg4'>
        <?php 
            echo "<input type='text' name='subdomain1' id='subdomain1' value='$subdomain1' class='intext2' size='20'>";
        ?>
        </span>
    </div>

    <div class='divreg2'>
        <span class='divreg3'>Domain Name</span>
        <span class='divreg4'>
        <?php 
            echo "<input type='text' name='domainname' id='domainname' value='$domainname' class='intext2' size='20'>";
        ?>
        </span>
    </div>
    
    
    <div class='divreg2'>
        <span class='divreg3'>User ID</span>
        <span class='divreg4'>
            <?php 
            echo $sellerid+1111;
            ?>
        </span>
    </div>
    
    <div class='divreg2'>
        <span class='divreg3'>Password</span>
        <span class='divreg4' >
        <?php 
            echo "<input type='text' name='password' id='password' value='$password' class='intext2' >";
        ?>
        </span>
    </div>
    
    

    <div class='divreg2'>
        <span class='divreg6'>Business Category</span>
    </div>

    <div class='divreg2'>

        <?php 

            $sql1 = " Select cm.*, coalesce(sc.id,0) as id  from categorymaster cm ";
            $sql1 = $sql1." left join sellercategory sc on cm.categoryid=sc.categoryid and sc.sellerid=".$sellerid;
            $sql1 = $sql1." order by sequence";
            $res1 = mysqli_query($connect, $sql1);
            
            $ncat=0;
            while ($row1 = mysqli_fetch_array($res1)) {
                $categoryid=$row1["categoryid"];
                $categoryname=$row1["categoryname"];
                $id=$row1["id"];
                
                $ncat++;
                if($id==0){
                    echo "<div id='divcat$ncat' class='divreg5'><input type='checkbox' id='cat$ncat' name='cat$ncat' value='$categoryid' onclick='setClass($ncat)'><label style='margin:5px;' onclick='selCategory($ncat)'>".$categoryname."</label></div>";
                }else{
                    echo "<div id='divcat$ncat' class='divreg5sel'><input checked type='checkbox' id='cat$ncat' name='cat$ncat' value='$categoryid' onclick='setClass($ncat)'><label style='margin:5px;' onclick='selCategory($ncat)'>".$categoryname."</label></div>";
                }
                echo "<input type='hidden' id='prvcat$ncat' name='prvcat$ncat' value='$id'>";
            }
            echo "<input type='hidden' name='ncat' id='ncat' value='$ncat' >";
        ?>
    </div>    
    

    <div class='divreg2'>
        <span class='divreg6'>Menu</span>
    </div>

    <div class='divreg2'>

        <?php 
        
            $sql1 = " SELECT mm.*, coalesce(sm.sellermenuid,0) as sellermenuid FROM `menumaster` mm left join sellermenu sm on mm.menuid=sm.menuid and sm.sellerid=$sellerid order by mm.seq";

            $res1 = mysqli_query($connect, $sql1);
            
            $nmenu=0;
            while ($row1 = mysqli_fetch_array($res1)) {
                $menuid=$row1["menuid"];
                $menuname=$row1["menuname"];
                $sellermenuid=$row1["sellermenuid"];
                
                $nmenu++;
                if($sellermenuid==0){
                    echo "<div id='divmenu$nmenu' class='divreg5'><input type='checkbox' id='menu$nmenu' name='menu$nmenu' value='$menuid' onclick='setClass($nmenu)'><label style='margin:5px;' onclick='selMenu($nmenu)'>".$menuname."</label></div>";
                }else{
                    echo "<div id='divmenu$nmenu' class='divreg5sel'><input checked type='checkbox' id='menu$nmenu' name='menu$nmenu' value='$menuid' onclick='setClass($nmenu)'><label style='margin:5px;' onclick='selMenu($nmenu)'>".$menuname."</label></div>";
                }
                echo "<input type='hidden' id='prvmenu$nmenu' name='prvmenu$nmenu' value='$sellermenuid'>";
            }
            echo "<input type='hidden' name='nmenu' id='nmenu' value='$nmenu' >";
        ?>
    </div>    


    </div>
    <input type='hidden' name='actionbutton' id='actionbutton' value='' >
    
    <div class='divsfoot100' >
    <?php    


        echo "<div class='divam4e'>";
            echo "<div ><input type='button' class='btn2' value='Submit' onclick='submitForm()' ></div>";

            if($cancelflag==2){
                echo "<div><input type='button' value='Approve' class='btn2' onclick='setCancelflag(\"setcancelflag0\")'></div>";
            }
            if($cancelflag==1){
                echo "<div><input type='button' value='Open View' class='btn2' onclick='setCancelflag(\"setcancelflag0\")'></div>";
            }else{
                echo "<div><input type='button' value='Stop View' class='btn2' onclick='setCancelflag(\"setcancelflag1\")'></div>";
            }
            
            echo "<div><input type='button' class='btn2' value='Close' onclick='window.close()' ></div>";
            
        echo "</div>";


    ?>    
    </div>
    
    
    <?php
    echo "<input type='hidden' name='xsellerid' id='xsellerid' value='$sellerid' >";    
}
?>
   

</form>
</body>
</html>
