<?php 
    include "connrent.php";

    if((isset($_GET['mprent']))&(isset($_GET['accno']))){
        $AccNo = $_GET['accno'];
        $mplace = $_GET['mprent'];

        echo $AccNo.' '.$mplace;
        header("location:MOfferDetail.php?mplace=$mplace&acc=$AccNo");
    }

    if(isset($_POST['sent'])){
        $accno = $_POST['accno'];
        $place = $_POST['place'];
        $price = $_POST['price'];
        $descrip = $_POST['descrip'];

        $query2 = mysqli_query($conn, "INSERT INTO MonthlyOffer(AccNo, MPlaceID, MOfferPrice, MOfferPurpose) VALUE($accno, $place, $price, '$descrip')");

        #echo "INSERT INTO MonthlyOffer(AccNo, MPlaceID, MOfferPrice, MOfferPurpose) VALUE($accno, $place, $price, '$descrip')";

        header("location:MOfferSuccess.php?accno=$accno&place=$place");
    }

?>
