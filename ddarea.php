<?php 
    echo "<select name='areaid' id='areaid' onchange='frm1.submit()' class='dropdown1' >";
    echo "<option value='0' >Select Area</option>";	

    $sql1 = "Select * from areamaster order by areaname";
    $res1 = mysqli_query($connect, $sql1);
    
    $selareaid=0;
    if(isset($_POST["areaid"])) {
        $selareaid=$_POST["areaid"];
    }else{
        if($selareaid==0){
            if(isset($_SESSION["areaid"])) $selareaid=$_SESSION["areaid"];
        }
    }

    while ($row1 = mysqli_fetch_array($res1)) {
            $catid=$row1["areaid"];
            $item1=$row1["areaname"];
            if($row1["areaid"]==$selareaid){
                echo "<option value='".$row1["areaid"]."' selected >".$row1["areaname"]."</option>";	
            } else {
                echo "<option value='".$row1["areaid"]."' >".$row1["areaname"]."</option>";	
            }
    }
    echo "</select>";

?>
