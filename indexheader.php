<?php 
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
            //$imagefile="images\\close.png";
            //echo "<div class='divheader3' ><img src=$imagefile class='imgindex1' onclick='window.close();'></div>";
            echo "</div>";
            
        }
        echo "</div>";
        
    }
?>
