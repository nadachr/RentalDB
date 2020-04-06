<?php 
    include "connrent.php";

    function fetchEQ(){
        include "connrent.php";
       
        $val= $_GET['value'];

        $val_M = mysqli_real_escape_string($conn, $val);

        $query = mysqli_query($conn, "SELECT * FROM Equipment WHERE EqID = $val_M");
        $resultArray = array();
  
        while($result = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            array_push($resultArray, $result);
        }
        mysqli_close($conn);
        return $resultArray;
    }

    $fetchEQ = fetchEQ();
    foreach($fetchEQ as $result){
        echo "<div class='row'>
                <div class='col-md-6'>
                    <input type='text' class='form-control' value= 'หน่วยงานราชการ ".$result['EqAgency']." บาท/วัน' disabled>
                </div>
                <div class='col-md-6'>";
        echo "      <input type='text' class='form-control' value= 'หน่วยงานเอกชน ".$result['EqPrivate']." บาท/วัน' disabled>
                </div>
            </div>";        
    }
?>