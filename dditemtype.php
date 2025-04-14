<?php 
    echo "<select name='itemtypeid' id='itemtypeid' onchange='frm1.submit()' class='dropdown1' >";
    echo "<option value='0' >Select Category</option>";	

    $sql1 = "Select * from itemtypemaster order by itemtype";
    $res1 = mysqli_query($connect, $sql1);
    
    if(isset($_POST["itemtypeid"])) $selitemtypeid=$_POST["itemtypeid"];

    while ($row1 = mysqli_fetch_array($res1)) {
            $catid=$row1["itemtypeid"];
            $item1=$row1["itemtype"];
            if($row1["itemtypeid"]==$selitemtypeid){
                echo "<option value='".$row1["itemtypeid"]."' selected >".$row1["itemtype"]."</option>";	
            } else {
                echo "<option value='".$row1["itemtypeid"]."' >".$row1["itemtype"]."</option>";	
            }
    }
    echo "</select>";

?>
