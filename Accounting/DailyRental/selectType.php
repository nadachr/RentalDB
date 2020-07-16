<?php 
    session_start();

    include "connrent.php";

    function fetchPlace(){
        include "connrent.php";
       
        $val= $_GET['value'];

        $val_M = mysqli_real_escape_string($conn, $val);

        $query = mysqli_query($conn, "SELECT LocTName FROM vdplacedetail WHERE DPlaceStatus = 1 AND DTID = $val_M");
        $resultArray = array();
  
        while($result = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            array_push($resultArray, $result);
        }
        mysqli_close($conn);
        return $resultArray;
    }

    $fetchPlace = fetchPlace();

    echo "<label for='placeT'>ที่ตั้งสถานที่</label>";
    echo "<select class='form-control' onchange='my_place(this.value);>'";
    
    foreach($fetchPlace as $result){

        echo "<option>".$result['LocTName']."</option>";
        $_SESSION['LocTName'] = $result['LocTName'];
    }            
        
    echo "</select>";

?>