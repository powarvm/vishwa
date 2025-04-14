    <script>    
    function openMenu() {
        if(document.getElementById('menu1').style.display=='none'){
            
            var xmlhttp=new XMLHttpRequest();
            xmlhttp.onreadystatechange=function() {
              if (this.readyState==4 && this.status==200) {
                document.getElementById("menu1").innerHTML=this.responseText;
              }
            }
            //xmlhttp.open("GET","indexheader.php?q="+str,true);
            xmlhttp.open("GET","sellermenu.php",true);
            xmlhttp.send();
            
            
            document.getElementById('menu1').style.display='block';
            
            
        }else{
            document.getElementById('menu1').style.display='none';
        }
    }
    
    function hideMenu(){
        document.getElementById('menu1').style.display='none';
    }
    
    </script>
        
<div class='divs0' >
        
<?php 

$sql1  = " SELECT sm.sellernamemarathi, sm.address, sm.mobileno,sm.othermobilenos, coalesce(ims.imageid, 0) as imageid, coalesce(sim.sellerimageid,0) as sellerimageid, coalesce(ims.imagefilename,'x') as imagefilename, am.areaheading, am.pincode  ";
$sql1  = $sql1." FROM `sellermaster` sm ";
$sql1  = $sql1." inner join areamaster am on am.areaid=sm.areaid ";
$sql1  = $sql1." left join sellerimagemaster sim on sim.sellerid=sm.sellerid and imagetypeid=2 ";
$sql1  = $sql1." left join imagemaster ims on ims.imageid=sim.imageid ";
$sql1  = $sql1." WHERE sm.sellerid=".$sellerid;

//echo $sql1;

$res1 = mysqli_query($connect, $sql1);
if($row1 = mysqli_fetch_array($res1)) {
    $sellername=$row1["sellernamemarathi"];
    echo "<div width='100%' class='divs1'>";
            echo "<div class='divs4'>";
                $imagefile="images\\menu.png";
                echo "<div class='divs2' onclick='openMenu();'><img src=$imagefile class='imgindex1' ></div>";
                echo "<div class='divs3' ><b>$sellername</b></div>";
            echo "</div>";
            
            echo "<div>";
                $signin="images\\close.png";
                echo "<div class='divs4' ><img src=$signin class='imgindex1' onclick='top.close();'></div>";
            echo "</div>";
    echo "</div>";
        
}
include_once 'sellerheader2.php';
?>	
</div>
<?php
echo "<div id='menu1' name='menu1' class='divmenu1'  style='display:none;' >";
echo "</div>";
?>
