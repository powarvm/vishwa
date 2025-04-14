<?php session_start();
require_once 'connection.php';

$areaid=0;
$sellerid=0;

$areaname="";
if(isset($_GET["post"])) $areaname=$_GET["post"];
if($areaname!=""){
    $areaid=getData("select coalesce((select areaid from areamaster where domainname='$areaname'),0) as areaid", $connect);
    if($areaid>0){
        $_SESSION["areaid"]=$areaid;
        setcookie("areaid", $areaid, time()+(86400*30),"/");

        $clientname="";
        if(isset($_GET["client"])) $clientname=$_GET["client"];
        if(isset($_GET["id"])) $clientname=$_GET["id"];
        if($clientname!=""){
            $sellerid=getData("select coalesce((select sellerid from sellermaster where subdomain1='$clientname'),0) as sellerid", $connect);
        }
    }
}





if(isset($_POST["areaid"])){
    $areaid=$_POST["areaid"];
    $_SESSION["areaid"]=$areaid;
    setcookie("areaid", $areaid, time()+(86400*30),"/");
} else {
    if(isset($_GET["areaid"])){
        $areaid=$_GET["areaid"];
        $_SESSION["areaid"]=$areaid;
        setcookie("areaid", $areaid, time()+(86400*30),"/");
    }else{
        if(isset($_SESSION["areaid"])) {
            $areaid=$_SESSION["areaid"];
        }else{
            if(isset($_COOKIE["areaid"])) {
                $areaid=$_COOKIE["areaid"];
                $_SESSION["areaid"]=$areaid;
            }
        }
    }
}
if($areaid=='') $areaid=0;
$areacnt=getData("select count(*) as cnt from areamaster where cancelflag=0 and areaid=$areaid", $connect);
if($areacnt==0) $areaid=0;
?>
<html>
<head>
    
</head>
<body style='margin:0px;'>
<?php

$isMobile=is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));
if($isMobile==1){
    if($areaid==0){
        echo "<iframe id='indexmain' name='indexmain' src='selectarea.php' width='100%' height='100%' style='border:none;'></iframe>"; 
    }else{
        if($sellerid>0){
            echo "<iframe id='indexmain' name='indexmain' src='home.php?id=$sellerid' width='100%' height='100%' style='border:none;'></iframe>"; 
        }else{
            //echo "<iframe id='indexheader' name='indexheader' src='indexheader.php' width='100%' height='7%' style='border:none;'></iframe>"; 
            echo "<iframe id='indexmain' name='indexmain' src='indexmain.php' width='100%' height='90%' style='border:none;'></iframe>"; 
            echo "<iframe id='indexfooter' name='indexfooter' src='indexfooter.php' width='100%' height='10%' style='border:none;'></iframe>"; 
        }
    }
}else{
    if($areaid==0){
        echo "<iframe id='indexmain' name='indexmain' src='selectarea.php' width='100%' height='100%' style='border:none;'></iframe>"; 
    }else{
        if($sellerid>0){
            echo "<iframe id='indexmain' name='indexmain' src='home.php?id=$sellerid' width='100%' height='100%' style='border:none;'></iframe>"; 
        }else{
            //echo "<iframe id='indexheader' name='indexheader' src='indexheader.php' width='100%' height='10%' style='border:none;'></iframe>"; 
            echo "<iframe id='indexmain' name='indexmain' src='indexmain.php?areaid=$areaid' width='100%' height='90%' style='border:none;'></iframe>"; 
            echo "<iframe id='indexfooter' name='indexfooter' src='indexfooter.php' width='100%' height='10%' style='border:none;'></iframe>"; 
        }
    }
}

?>

</body>
</html>