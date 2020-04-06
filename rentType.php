<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        function returnResult(){
            include "connrent.php";
            ini_set('display_errors',1);
            error_reporting(~0);

            $sqlMF = "CALL typePrice(1)";
            $sqlDF = "CALL typePrice(2)";
            $sqlOF = "CALL typePrice(3)";
            $query = mysqli_query($conn, $sqlMF);
            $resultArray = array();
            while($result = mysqli_fetch_array($query, MYSQLI_ASSOC)){
                array_push($resultArray, $result);
            }
            mysqli_close($conn);
            return $resultArray;
        }

        $resultPush = returnResult();
    ?>
    
    <div class="container">
        <h1 align='center'>สถานที่ราชการภายในมหาวิทยาลัยเทคโนโลยีราชมงคลศรีวิชัย</h1>
        <p>ทดสอบระบบ</p>
        <h2>อัตราค่าเช่าประเภทจ่ายเงินรายเดือน (3ปี)</h2>
        <table class="table table-dark table-striped">
            <thead>
                <tr align="center">
                    <th>ประเภทสถานที่</th>
                    <th>Place Type</th>
                    <th>เปิดภาคเรียน(บาท/เดือน)</th>
                    <th>ปิดภาคเรียน(บาท/เดือน)</th>
                    <th>ค่าบำรุงรักษา(บาท/เดือน)</th>
                </tr>
            </thead>
                    
            <tbody>
                <?php 
                    foreach($resultPush as $result){
                ?>
                <tr>
                    <td><?php echo $result["TypeTName"] ?></td>
                    <td><?php echo $result["TypeEname"] ?></td>
                    <td><?php echo $result["inTerm"] ?></td>
                    <td><?php echo $result["offTerm"] ?></td>
                    <td><?php echo $result["MaintainFee"] ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="container">
        <h2>อัตราค่าเช่าประเภทรายวัน</h2>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>ประเภทสถานที่</th>
                    <th>Place Type</th>
                    <th>จำนวนที่นั่ง</th>
                    <th>หน่วยงานเอกชน(บาท/วัน)</th>
                    <th>หน่วยงานราชการ(บาท/วัน)</th>
                </tr>
            </thead>
                        
            <tbody>
                <?php 
                    while($resultDF = mysqli_fetch_array($queryDF, MYSQLI_ASSOC)){
                ?>
                <tr>
                    <td><?php echo $resultDF["TypeTName"] ?></td>
                    <td><?php echo $resultDF["TypeEname"] ?></td>
                    <td><?php echo $resultDF["TypeSeat"] ?></td>
                    <td><?php echo $resultDF["DFagency"] ?></td>
                    <td><?php echo $resultDF["DFprivate"] ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>