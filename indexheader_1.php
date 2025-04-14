<?php session_start(); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>ATPOST</title>
<style>
<?php 
$areaid=0;
if(isset($_GET["areaid"])){
    $areaid=$_GET["areaid"];
} else {
    if(isset($_SESSION['areaid'])){
        $areaid=$_SESSION['areaid'];
    }
}   

$isMobile=is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));
include 'css/atpost.css'; 

?>

</style>
<script>
    /*
    function changeArea(areaid){
        //'<%Session["areaid"] = "' + areaid + '"; %>';
        //setcookie("areaid", areaid, time()+(86400*365),"/");
        parent.indexmain.location='indexmain.php?areaid='+areaid;
        parent.indexheader.location='indexheader.php?areaid='+areaid;
        parent.indexfooter.location='indexfooter.php?areaid='+areaid;
        //parent.location.reload();
    }

    function changeArea1(){
        parent.indexmain.location='indexmain.php?areaid='+document.getElementById('areamaster').value;
        parent.indexheader.location='indexheader.php?areaid='+document.getElementById('areamaster').value;
        parent.indexfooter.location='indexfooter.php?areaid='+document.getElementById('areamaster').value;
        //parent.location.reload();
    }
    */
    function openArea(){
        //window.open('selectarea.php');
        //parent.window.close();
        
        //window.top.location='index.php?areaid='+areaid;

        
        var str=JSON.stringify(top.indexmain.location);
        if(str.includes("indexmain")){
            top.indexmain.location='selectarea.php';
        }else{
            top.indexmain.location='indexmain.php';
        }
        
    }
    
    function closeMe(){
        top.close();
    }
    
    
    function openMenu() {
        if(top.indexmain.document.getElementById('menu1').style.display=='none'){
            
            var xmlhttp=new XMLHttpRequest();
            xmlhttp.onreadystatechange=function() {
              if (this.readyState==4 && this.status==200) {
                top.indexmain.document.getElementById("menu1").innerHTML=this.responseText;
              }
            }
            //xmlhttp.open("GET","indexheader.php?q="+str,true);
            xmlhttp.open("GET","indexmenu.php",true);
            xmlhttp.send();
            
            top.indexmain.document.getElementById('menu1').style.display='block';
        }else{
            top.indexmain.document.getElementById('menu1').style.display='none';
        }
        
        /*
        if(top.indexmain.document.getElementById('divcat1').style.display=='none'){
            top.indexmain.document.getElementById('divcat1').style.display='block';
        }else{
            top.indexmain.document.getElementById('divcat1').style.display='none';
        }
        */
    }
    
</script>
</head>
<body class='bdhead'>

<?php 
    require_once 'connection.php'; 
    if($areaid>0){

        echo "<div class='divheader1' >";
        $sql1 = " Select areaid,areaheading,pincode from areamaster where areaid=$areaid ";

        $res1 = mysqli_query($connect, $sql1);
        while ($row1 = mysqli_fetch_array($res1,MYSQLI_BOTH)) {
            $areaheading = $row1["areaheading"].' '.$row1["pincode"];
            $xareaid=$row1["areaid"];
            $imagefile="images\\menu.png";
            echo "<div>";
            echo "<label class='divheader3' onclick='openArea();'><img src=$imagefile class='imgindex1' ></label>";
            echo "<label class='divheader2' onclick='openArea();'><b>$areaheading</b></label>";
            echo "</div>";

            echo "<div style='display:flex; padding:5px;'>";
            $imagefile="images\\signin.png";
            echo "<div class='divheader3' ><img src=$imagefile class='imgindex1' onclick='openMenu();'></div>";
            $imagefile="images\\close.png";
            echo "<div class='divheader3' ><img src=$imagefile class='imgindex1' onclick='closeMe();'></div>";
            echo "</div>";
            
        }
        echo "</div>";
        
    }
?>
</body>
</html>
