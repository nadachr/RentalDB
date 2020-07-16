<?php 
    include "connrent.php";

    function fetchPlace(){
        include "connrent.php";
       
        $val= $_GET['value'];

        $val_M = mysqli_real_escape_string($conn, $val);

        $query = mysqli_query($conn, "SELECT * FROM vdplaceDetail WHERE DPlaceStatus = 1 AND DTID = $val_M");
        $resultArray = array();
  
        while($result = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            array_push($resultArray, $result);
        }
        mysqli_close($conn);
        return $resultArray;
    }

    $fetchPlace = fetchPlace();

    echo "<label for='placeT'>ชื่อสถานที่</label>";
    echo "<select class='form-control'>";
    
    foreach($fetchPlace as $result){

        echo "<option>".$result['DPlaceTName']."</option>";
    }            
        
    echo "</select>";

?>