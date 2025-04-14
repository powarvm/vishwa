<?php session_start(); 
header('Cache-Control: max-age=900');
?>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>ATPOST</title>
<style type="text/css">

<?php 

$areaid=0;
if(isset($_SESSION["areaid"])) $areaid=$_SESSION["areaid"];
if(isset($_GET["areaid"])){
    $areaid=$_GET["areaid"];
    $_SESSION["areaid"]=$areaid;
    setcookie("areaid", $areaid, time()+(86400*30),"/");
}

$isMobile=is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));
require_once 'css/atpost.css'; 
require_once 'connection.php'; 


$sellerid=0;
$actionbutton='';
if(isset($_POST['actionbutton'])) { $actionbutton=$_POST['actionbutton']; };

$selcategoryid=0;
if(isset($_POST['selcategoryid'])) { $selcategoryid=$_POST['selcategoryid']; };

if($actionbutton=="SignOut") $_SESSION["sellerid"]=0;
if(isset($_SESSION["sellerid"])){
    $sellerid=$_SESSION["sellerid"];
}else {
    $_SESSION["sellerid"]=0;
    $sellerid=0;
}
?>
</style>


<script> src="js/jquery-1.12.4.min.js"; </script>
<script>
    /*
    jQuery(document).ready(function($) {
    if (window.history && window.history.pushState) {
    window.history.pushState('forward', null, './#forward');
    $(window).on('popstate', function() {
        if( confirm('May I Close this window') ){
            top.close();
        }
        });
      }
    });
    */
    /*
    $(document).click(function() {
        var container = $("#menu1");
        if (!container.is(event.target) && !container.has(event.target).length) {
            container.hide();
        }
    });
    */
    /*
    document.addEventListener('mouseup', function(e) {
      var container = document.getElementById('menu1');
      if (!container.contains(e.target)) {
        container.style.display = 'none';
      }
    });
    */
    
        /*
        window.onload = function(){
            var menu1 = document.getElementById('menu1');
            document.onclick = function(e){
               if(e.target.id !== 'menu1'){
                  menu1.style.display = 'none';
               }
            };
         };    
         */
   
    function setCategory(catid){
        //document.getElementById("selcategoryid").value = catid; 
        //document.getElementById("tsearch").value = ""; 
        //document.getElementById("frm1").submit();
        
        var catdivobj='category'+catid;
        document.getElementById("divseller0").innerHTML =document.getElementById(catdivobj).innerHTML;
    }

    function openSeller(sellerilink){
        window.open(encodeURI(sellerilink),"_blank");
    }
    
    function newRegistration(){
        window.open("registration.php","_self");
    }
    
    function signIn(){
        window.open("signin.php","_blank");
    }
    
    function signOut(){
        document.getElementById("actionbutton").value='SignOut';
        frm1.submit();
        //location.href='indexfooter.php?actionbutton=SignOut';
    }
    

    function openSellerEdit(){
            window.open("sellermain.php","_self");
    }

    function handleCategory(){

        if(document.getElementById('divcat1').style.display=='none'){
            document.getElementById('divcat1').style.display='block';
            //top.indexmain.document.getElementById('divcat1').style.width='28%';
            document.getElementById('divseller0').style.width='68%';
            document.getElementById('catimg1').src='images\\left.png';
        }else{
            document.getElementById('divcat1').style.display='none';
            document.getElementById('divseller0').style.width='100%';
            document.getElementById('catimg1').src='images\\right.png';
            
        }
    }

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
        window.top.location='selectarea.php';
        //parent.window.close();
        
        //window.top.location='index.php?areaid='+areaid;

        /*
        var str=JSON.stringify(top.indexmain.location);
        if(str.includes("indexmain")){
            top.indexmain.location='selectarea.php';
        }else{
            top.indexmain.location='indexmain.php';
        }
        */
    }
    
    function closeMe(){
        //top.close();
        window.close();
    }
    
    
    function openMenu() {
        if(document.getElementById('menu1').style.display=='none'){
            var xmlhttp=new XMLHttpRequest();
            xmlhttp.onreadystatechange=function() {
              if (this.readyState==4 && this.status==200) {
                document.getElementById('menu1').innerHTML=this.responseText;
              }
            }
            //xmlhttp.open("GET","indexheader.php?q="+str,true);
            xmlhttp.open("GET","indexmenu.php",true);
            xmlhttp.send();
            
            document.getElementById('menu1').style.display='block';
        }else{
            document.getElementById('menu1').style.display='none';
        }
        
        /*
        if(top.indexmain.document.getElementById('divcat1').style.display=='none'){
            top.indexmain.document.getElementById('divcat1').style.display='block';
        }else{
            top.indexmain.document.getElementById('divcat1').style.display='none';
        }
        */
    }
    
    function hideMenu(){
        document.getElementById('menu1').style.display='none';
    }
    
    
</script>



</head>
    
<body class='bd1' onmouseup='hideMenu();' >
<form name='frm1' id='frm1' action="indexmain.php" method="post">


    
<?php

require_once 'indexheader.php';     

        echo "<div id='menu1' name='menu1' class='divmenu1'  style='display:none;' >";
        echo "</div>";
        

	
	$tsearch="";
	if(isset($_POST["tsearch"])) $tsearch=$_POST["tsearch"];

        echo "<div class='divsearch1' >";

            echo "<div class='divsearch1a' >";
            echo "<input type='text' name='tsearch' id='tsearch' value='$tsearch' class='intext3' >";
            echo "</div>";
            
            echo "<div class='divsearch1b' >";
            $imagefile="images\\search.png";
            echo "<img src=$imagefile class='imgindex1' onclick='frm1.submit();'>";
            echo "</div>";

        echo "</div>";
       
	echo "<div class='divmain1'  >";
        
        
        
            $tsearch=strtoupper($tsearch);
            
            
            $sql1 = " Select * from ( ";
            $sql1 = $sql1." Select categoryid, categoryname, sequence, case when id=0 then 1 else 0 end as id from ( ";
            $sql1 = $sql1." Select cg.categoryid, cg.categoryname, cg.sequence, coalesce(max(cm.sellerid),0) as id ";
            $sql1 = $sql1." from categorymaster cg  ";
            $sql1 = $sql1." left join sellercategory cc on cg.categoryid=cc.categoryid ";
            $sql1 = $sql1." left join sellermaster cm on cc.sellerid=cm.sellerid and cm.cancelflag!=1 and cm.areaid=$areaid";
            $sql1 = $sql1." where 1=1 ";            
            if($selcategoryid>0){
                $sql1 = $sql1." and cg.categoryid!=$selcategoryid ";
            }
            if($tsearch!="") $sql1 = $sql1." and ((upper(cm.sellername) like '%$tsearch%') or (upper(cg.categoryname) like '%$tsearch%'))";
            
            
            $sql1 = $sql1." group by cg.categoryid, cg.categoryname, cg.sequence ";
            $sql1 = $sql1." order by cg.sequence, cg.categoryname ";
            $sql1 = $sql1." ) as q1 ";
            $sql1 = $sql1." ) as q2 ";
            $sql1 = $sql1." order by id , sequence, categoryname  ";
            
            
            /*
            
            $sql1 = " Select distinct cg.categoryid, cg.categoryname, cg.sequence ";
            $sql1 = $sql1." from sellermaster cm, sellercategory cc, categorymaster cg,  imagemaster im, areamaster am ";
            $sql1 = $sql1." where cm.cancelflag!=1 and cc.sellerid=cm.sellerid and cc.categoryid=cg.categoryid and im.imageid=cg.imageid and cm.areaid=am.areaid ";
            $sql1 = $sql1." and cm.areaid=".$areaid;
            if($selcategoryid>0){
                $sql1 = $sql1." and cg.categoryid!=$selcategoryid ";
            }
            
            if($tsearch!="") $sql1 = $sql1." and ((upper(cm.sellername) like '%$tsearch%') or (upper(cg.categoryname) like '%$tsearch%'))";
            $sql1 = $sql1." order by cg.sequence, cg.categoryname ";
             * 
             */

            /*
            $sql1 = " Select cg.categoryid, cg.categoryname,cg.sequence ";
            $sql1 = $sql1." from categorymaster cg  where 1=1 ";
            if($selcategoryid>0){
                $sql1 = $sql1." and cg.categoryid!=$selcategoryid ";
            }
            
            if($tsearch!="") $sql1 = $sql1." and ((upper(cg.categoryname) like '%$tsearch%'))";
            $sql1 = $sql1." order by cg.sequence, cg.categoryname ";
             * 
             */

            
	
            $res1 = mysqli_query($connect, $sql1);
            echo "<div id='divcat1' name='divcat1' class='divcat1' >";
                while ($row1 = mysqli_fetch_array($res1,MYSQLI_BOTH)) {
                    $category = $row1["categoryname"];
                    $categoryid = $row1["categoryid"];
                    //$imagefile = "images\\".$row1["imagefilename"];

                    if($row1["id"]==0){
                        echo "<div class='divcat2'><label style='cursor:pointer;' onclick='setCategory($categoryid)'>$category ▶</label></div>";
                    }else{
                        echo "<div class='divcat2'><label style='cursor:pointer;' onclick='setCategory(0)'>$category</label></div>";
                    }
                }
            echo "</div>";
            
            echo "<div name='category0' id='category0' style='display:none'>";

                echo "<div class='divseller1'>";
                    $imagefile="images\\left.png";
                    echo "<div class='divcat2a'><label style='cursor:pointer;margin-left:10px;' onclick='handleCategory();'><img id='catimg1' name='catimg1' src=$imagefile class='imgindex1' ></label><label ><b>atpost.in</b></label><label ></label></div>";
                echo "</div>";

                echo "<div class='divseller1' >";
                    if($isMobile==1){
                        $imagefile = "images\\atpost.jpg";
                    }else{
                        $imagefile = "images\\atpost1.jpg";
                    }
                    echo "<img src=$imagefile class='divmainimage'  onclick='newRegistration();' >";
                echo "</div>";
            echo "</div>";
            
            echo "<div id='divseller0' name='divseller0'  class='divseller0'  >";

                echo "<div class='divseller1'>";
                    $imagefile="images\\left.png";
                    echo "<div class='divcat2a'><label style='cursor:pointer;margin-left:10px;' onclick='handleCategory();'><img id='catimg1' name='catimg1' src=$imagefile class='imgindex1' ></label><label  ><b>atpost.in</b></label><label ></label></div>";
                echo "</div>";

                echo "<div class='divseller1' >";
                    if($isMobile==1){
                        $imagefile = "images\\atpost.jpg";
                    }else{
                        $imagefile = "images\\atpost1.jpg";
                    }
                    echo "<img src=$imagefile class='divmainimage'  onclick='newRegistration();' >";
                echo "</div>";

            echo "</div>";
            
            
            $sql1 = " SELECT distinct cm.categoryid, cm.categoryname ";
            $sql1 = $sql1." FROM sellercategory sc, sellermaster sm, categorymaster cm ";
            $sql1 = $sql1." WHERE sc.sellerid=sm.sellerid and cm.categoryid=sc.categoryid and sm.areaid=$areaid";
            if($tsearch!="") $sql1 = $sql1." and ((upper(cm.sellername) like '%$tsearch%') or (upper(cg.categoryname) like '%$tsearch%'))";
            $sql1 = $sql1." order by cm.categoryid ";
            $res2 = mysqli_query($connect, $sql1);
            while ($row2 = mysqli_fetch_array($res2,MYSQLI_BOTH)) {
                $categoryid=$row2["categoryid"];
                
                echo "<div name='category$categoryid' id='category$categoryid' style='display:none'>";
                
                    echo "<div class='divseller1'>";
                        $imagefile="images\\left.png";
                        echo "<div class='divcat2a'><label style='cursor:pointer;margin-left:10px;'  onclick='handleCategory();'><img id='catimg1' name='catimg1' src=$imagefile class='imgindex1' ></label><label style='cursor:pointer;' onclick='setCategory(0)'>".$row2["categoryname"]."</label><label></label></div>";
                    echo "</div>";

                    $sql1 = " Select cm.sellerid, cm.sellernamemarathi, im.imagefilename, coalesce(cm.directlink,'') as directlink ";
                    $sql1 = $sql1." from sellermaster cm, sellercategory cc, categorymaster cg,  imagemaster im, areamaster am ";
                    $sql1 = $sql1." where cm.cancelflag!=1 and cc.sellerid=cm.sellerid and cc.categoryid=cg.categoryid and im.imageid=cg.imageid and cm.areaid=am.areaid ";
                    $sql1 = $sql1." and cm.areaid=".$areaid;
                    $sql1 = $sql1." and (date_add(cm.registerdate,INTERVAL 5 DAY)>=CURRENT_DATE or cm.flashdate>=CURRENT_DATE)";

                    if($tsearch!="") $sql1 = $sql1." and ((upper(cm.sellername) like '%$tsearch%') or (upper(cg.categoryname) like '%$tsearch%'))";
                    $sql1 = $sql1." and cc.categoryid=".$row2["categoryid"];
                    $sql1 = $sql1." order by cm.registerdate desc, cg.sequence, cm.sellername ";
                    $res1 = mysqli_query($connect, $sql1);

                    while ($row1 = mysqli_fetch_array($res1,MYSQLI_BOTH)) {

                            $seller = $row1["sellernamemarathi"];
                            if(strlen($seller)>50) $seller = substr($seller,0,50).'...';

                            $sellerid = $row1["sellerid"];
                            $imagefile = "images\\".$row1["imagefilename"];

                            echo "<div class='divseller2' onclick='openSeller(\"home.php?id=$sellerid\");'>$seller</div>";
                    }


                    $sql1 = " Select cm.sellerid, cm.sellernamemarathi, im.imagefilename, coalesce(cm.directlink,'') as directlink ";
                    $sql1 = $sql1." from sellermaster cm, sellercategory cc, categorymaster cg,  imagemaster im, areamaster am ";
                    $sql1 = $sql1." where cm.cancelflag!=1 and cc.sellerid=cm.sellerid and cc.categoryid=cg.categoryid and im.imageid=cg.imageid and cm.areaid=am.areaid ";
                    $sql1 = $sql1." and cm.areaid=".$areaid;
                    $sql1 = $sql1." and cc.categoryid=".$row2["categoryid"];
                    $sql1 = $sql1." and !(date_add(cm.registerdate,INTERVAL 5 DAY)>=CURRENT_DATE or cm.flashdate>=CURRENT_DATE)";
                    if($tsearch!="") $sql1 = $sql1." and ((upper(cm.sellername) like '%$tsearch%') or (upper(cg.categoryname) like '%$tsearch%'))";
                    $sql1 = $sql1." order by cm.registerdate desc, cg.sequence, cm.sellername ";

                    $res1 = mysqli_query($connect, $sql1);

                    echo "<div class='divseller1'>";
                    $prvcatg="";
                    while ($row1 = mysqli_fetch_array($res1,MYSQLI_BOTH)) {

                            $seller = $row1["sellernamemarathi"];
                            if(strlen($seller)>50) $seller = substr($seller,0,50).'...';

                            $sellerid = $row1["sellerid"];
                            $imagefile = "images\\".$row1["imagefilename"];

                            echo "<div class='divseller3' onclick='openSeller(\"home.php?id=$sellerid\");'>$seller</div>";
                    }
                    echo "</div>";
                echo "</div>";
            }

        echo "</div>";
        echo "<input type='hidden' id='actionbutton' name='actionbutton' value=''>";
        echo "<input type='hidden' id='selcategoryid' name='selcategoryid' value='$selcategoryid'>";
        
	
?>			


</form>
</body>
</html>
