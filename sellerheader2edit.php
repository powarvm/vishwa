<script>
function SubmitButton(sellerid,menupage){
    document.frm1.action = menupage+'?sellerid='+sellerid;
    document.frm1.submit();
}
function signOut(){
    document.frm1.action = 'sellerhomeedit.php?actionbutton=signout';
    document.frm1.submit();
}

</script>

<?php
$sellerid=0;
if(isset($_SESSION["sellerid"])) $sellerid=$_SESSION["sellerid"];


echo "<div class='divsmenu0' >";
echo "<div class='divsmenu1' >";

$sql1 = "select mm.menuname,mm.menupage,mm.imagefilename from sellermenu sm, menumaster mm where sm.menuid=mm.menuid and sm.sellerid=".$sellerid." order by sm.seq";
$res1 = mysqli_query($connect, $sql1);
while ($row1 = mysqli_fetch_array($res1)) {
    $menuname=$row1["menuname"];
    $menupage=$row1["menupage"].'edit.php';
    $imagefilename="images\\".$row1["imagefilename"];
    
    echo "<a href='#' onclick='SubmitButton($sellerid, \"$menupage\")' title='$menuname'><img src=$imagefilename class='imgindex2' ><div class='divsmenu3'>$menuname</div></a>";
}
//echo "<sapn class='divmenu2' ><label class='labelmenu1' onclick='SubmitButton($sellerid, \"imagemaster.php\")' ><u>Images</u></label></span>";
$imagefilename="images\\images.png";
echo "<a href='#' onclick='SubmitButton($sellerid, \"imagemaster.php\")' title='Image Master'><img src=$imagefilename class='imgindex2' ><div class='divsmenu3'>Images</div></a>";

if($sellerid==1){
    /*
    echo "<sapn class='divmenu2' ><label class='labelmenu1' onclick='SubmitButton(1, \"areamaster.php\")' ><u>Area</u></label></span>";
    echo "<sapn class='divmenu2' ><label class='labelmenu1' onclick='SubmitButton(1, \"categorymaster.php\")' ><u>Category</u></label></span>";
    echo "<sapn class='divmenu2' ><label class='labelmenu1' onclick='SubmitButton(1, \"itemtypemaster.php\")' ><u>ItemType</u></label></span>";
    echo "<sapn class='divmenu2' ><label class='labelmenu1' onclick='SubmitButton(1, \"sellermaster.php\")' ><u>Seller</u></label></span>";
    */

    $imagefilename="images\\master.png";
    echo "<a href='#' onclick='SubmitButton(1, \"areamaster.php\")' title='Area Master'><img src=$imagefilename class='imgindex2' ><div class='divsmenu3'>Area</div></a>";
    echo "<a href='#' onclick='SubmitButton(1, \"categorymaster.php\")' title='Category Master'><img src=$imagefilename class='imgindex2' ><div class='divsmenu3'>Category</div></a>";
    echo "<a href='#' onclick='SubmitButton(1, \"itemtypemaster.php\")' title='Item Type Master'><img src=$imagefilename class='imgindex2' ><div class='divsmenu3'>Item Type</div></a>";
    echo "<a href='#' onclick='SubmitButton(1, \"sellermaster.php\")' title='Seller Master'><img src=$imagefilename class='imgindex2' ><div class='divsmenu3'>Seller</div></a>";

}
//echo "<span class='divmenu2' ><label class='labelmenu1' onclick='SubmitButton($sellerid, \"changepassword.php\")'  ><u>Password</u></label></span>";
//echo "<span class='divmenu2' ><label class='labelmenu1' onclick='signOut()' ><u>Sign Out</u></label></span>";
//echo "<span class='divmenu2' ><label class='labelmenu1' onclick='top.close();' ><u>Close</u></label></span>";


$imagefilename="images\\password.png";
echo "<a href='#' onclick='SubmitButton($sellerid, \"changepassword.php\")' title='Password Change'><img src=$imagefilename class='imgindex2' ><div class='divsmenu3'>Password</div></a>";

$imagefilename="images\\signout.png";
echo "<a href='#' onclick='signOut()' title='Sign Out'><img src=$imagefilename class='imgindex2' ><div class='divsmenu3'>Sign Out</div></a>";


echo "</div>";
echo "</div>";


?>

