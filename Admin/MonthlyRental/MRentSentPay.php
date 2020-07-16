<?php 

include "connrent.php";

    if((isset($_GET['rent']))&(isset($_GET['accno']))&(isset($_GET['offer']))){
        $offer = $_GET['offer'];
        $AccNo = $_GET['accno'];
        $rent = $_GET['rent'];

        $query2 = mysqli_query($conn, "INSERT INTO mpayment(MRentID) VALUE ($rent);");
        #echo "INSERT INTO MPayment(MRentID) VALUE ($rent);";
        header("location:MRentDetail.php?accno=$AccNo&offer=$offer");
    }

?>