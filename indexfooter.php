<?php session_start(); ?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Footer</title>
<style>

<?php 
$isMobile=is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));
include 'css/atpost.css'; 

$actionbutton='';
if(isset($_GET['actionbutton'])) { $actionbutton=$_GET['actionbutton']; };

if($actionbutton=="SignOut") $_SESSION["sellerid"]=0;
?>
</style>
</head>

<script>
    function openWindow(mypage){
        if(mypage=='-'){
            alert('Under Design !')
        }else{
            window.open(mypage);
        }
            
    }

    function newRegistration(){
        window.open("registration.php");
    }
    
    function signIn(){
        window.open("signin.php");
    }
    function openSellerEdit(){
            window.open("sellermain.php");
    }
    function signOut(){
        //document.getElementById("actionbutton").value='SignOut';
        //frm1.submit();
        location.href='indexfooter.php?actionbutton=SignOut';
    }
    
</script>

<body class='bdfoot'>
<?php 
require_once 'connection.php'; 
?>

<div class="divfootmain1"> 
    
    <div class="divfoot1"> 

        <span class='divfoot2'><label style='cursor:pointer' onclick='openWindow("-");' >नोकरी संदर्भ</label></span>
        <span class='divfoot2'><label style='cursor:pointer' onclick='openWindow("-");' >वधु-वर</label></span>
        <span class='divfoot2'><label style='cursor:pointer' onclick='openWindow("mybazar.php");' >बझार</label></span>
        
        <span class='divfoot2'><label ></label></span>

        <span class='divfoot2'><label style='cursor:pointer' onclick='newRegistration();' >Registration</label></span>
        <?php
        /*
        $sellerid=0;
        if(isset($_SESSION["sellerid"])) $sellerid=$_SESSION["sellerid"];
        if($sellerid>0){
            $sellername=getData("Select sellername from sellermaster where sellerid=".$sellerid,$connect);
            echo "<span class='divfoot2'><label style='cursor:pointer' onclick='openSellerEdit();' >$sellername</label></span>";
            echo "<span class='divfoot2'><label style='cursor:pointer' onclick='signOut();' >Sign Out</label></span>";
        }
         * 
         */
        ?>
        <input type='hidden' id='actionbutton' name='actionbutton' value=''>
    </div>
    
    
    <?php
        //if($sellerid==0){
            //echo "<div class='divfoot1'>"; 
            //echo "<span class='divfoot2a'><label >FREE WEBSITE FOR EVERYONE</label></span>";
            //echo "</div>";
        //}
    ?>
    
    
</div>
</body>
</html>
