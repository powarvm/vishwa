<script>
 function SubmitButton(sellerid,menupage){
    document.frm1.action = menupage+'?sellerid='+sellerid;
    document.frm1.submit();
}

function signOut(){
    document.frm1.action = 'sellerhome.php?actionbutton=signout';
    document.frm1.submit();
}


</script>

<?php
if(isset($_GET["sellerid"])) $sellerid=$_GET["sellerid"];
if(isset($_POST["sellerid"])) $sellerid=$_POST["sellerid"];

/*
 * 11-02-2021 OFF --- Not required.
if($sellerid==0){
    if(isset($_SESSION["sellerid"])) $sellerid=$_SESSION["sellerid"];
}
*/

echo "<div class='divsmenu0' >";
echo "<div class='divsmenu1' >";

$sql1 = "select mm.menuname,mm.menupage,mm.imagefilename from sellermenu sm, menumaster mm where sm.menuid=mm.menuid and sm.sellerid=".$sellerid." order by sm.seq";
$res1 = mysqli_query($connect, $sql1);
while ($row1 = mysqli_fetch_array($res1)) {
    $menuname=$row1["menuname"];
    $menupage=$row1["menupage"].'.php';
    $imagefilename="images\\".$row1["imagefilename"];
    
    echo "<a href='#' onclick='SubmitButton($sellerid, \"$menupage\")' title='$menuname'><img src=$imagefilename class='imgindex2' ><div class='divsmenu3'>$menuname</div></a>";
}


if(isset($_SESSION["sellerid"])) {
    if($sellerid==$_SESSION["sellerid"]){
        $imagefilename="images\\signout.png";
        echo "<a href='#' onclick='signOut()' title='Sign Out'><img src=$imagefilename class='imgindex2' ><div class='divsmenu3'>Sign Out</div></a>";
    }
}



//echo "<span class='divmenu2' ><label class='labelmenu1' onclick='top.close();' >Close</label></span>";
//echo "<a href='#' onclick='top.close();'  >Close</a>";

echo "</div>";
echo "</div>";

?>
