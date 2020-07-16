<?php 
  session_start();

  if (!isset($_SESSION['id'])) {
      $_SESSION['msg'] = "You must log in first";
      header('location: http://localhost/rentaldb/index.php');
  }
?>
<?php 
    function fetchName(){
        include "connrent.php";

        $user = $_SESSION['name'];

        $query = mysqli_query($conn, "SELECT * FROM vlogin WHERE AccName = '$user';");
        $resultArray = array();

        while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            array_push($resultArray, $row);
        }
        mysqli_close($conn);
        return $resultArray;
    }

    function fetchAcc(){
        include "connrent.php";
  
        $id = $_SESSION['id'];
        $query = mysqli_query($conn, "SELECT * FROM vaccount WHERE LogUser = '$id';");
        $resultArray = array();
  
        while($result = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            array_push($resultArray, $result);
        }
        mysqli_close($conn);
        return $resultArray;
    }

    function fetchPlace(){
        include "connrent.php";
        
        if (isset($_GET['dprent'])) {
            $DPlace = $_GET['dprent'];
        } else {
            $DPlace = 0;
        }
       
        $query = mysqli_query($conn, "SELECT * FROM vdplacedetail WHERE DPlaceStatus = 1 AND DPlaceID = $DPlace");
        $resultArray = array();
  
        while($result = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            array_push($resultArray, $result);
        }
        mysqli_close($conn);
        return $resultArray;
    }
  
    function fetchDP(){
        include "connrent.php";
       
        $LocTName = $_SESSION['LocTName'];
        $query = mysqli_query($conn, "SELECT * FROM vdplacedetail WHERE DPlaceStatus = 1 AND LocTName = '$LocTName'");
        $resultArray = array();
  
        while($result = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            array_push($resultArray, $result);
        }
        mysqli_close($conn);
        return $resultArray;
    }

    function fetchDT(){
        include "connrent.php";
       
        $query = mysqli_query($conn, "SELECT DISTINCT DTID, DTTName FROM vdplacedetail WHERE DPlaceStatus = 1");
        $resultArray = array();
  
        while($result = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            array_push($resultArray, $result);
        }
        mysqli_close($conn);
        return $resultArray;
    }

    function fetchEq(){
        include "connrent.php";
       
        $query = mysqli_query($conn, "SELECT * FROM equipment WHERE EqStatus = 1");
        $resultArray = array();
  
        while($eq = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            array_push($resultArray, $eq);
        }
        mysqli_close($conn);
        return $resultArray;
    }

    if (isset($_GET['dprent'])) {
        $DPlace = $_GET['dprent'];
    } else {
        $DPlace = 0;
    }
    
    if (isset($_GET['rent'])) {
      $RentID = $_GET['rent'];
    } else {
        $RentID = 0;
    }
    $i = 0;

    require_once "editDType.php";

    $fetchName = fetchName();

    foreach($fetchName as $row){}
    $fetchPlace = fetchPlace();
    #$fetchDP = fetchDP();
    $fetchAcc = fetchAcc();
    $fetchEq = fetchEq();
    $fetchDT = fetchDT();
?>

<!DOCTYPE html>
<html>
<head>
  <style>
    @import url('https://fonts.googleapis.com/css?family=Kanit&display=swap');
  </style>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>RPRMS | Daily Place</title>

  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Kanit -->
  <link href="https://fonts.googleapis.com/css?family=Kanit&display=swap" rel="stylesheet">
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
  <script type="text/javascript">
    function showHideInfo(){
        if(document.getElementById('chk').checked){
            document.getElementById('checkeq').style.display='block';
        }else{
            document.getElementById('checkeq').style.display='none'; 
        }
    }
  </script>
  <script>
      function my_fun(str){
        if(window.XMLHttpRequest){
          keyword = new XMLHttpRequest();
        }else{
          keyword = new ActiveXObject("Microsoft.XMLHTTP");
        }

        keyword.onreadystatechange=function(){
          if(this.readyState==4 && this.status==200){
                document.getElementById('eq').innerHTML = this.responseText;
          }
        }
        keyword.open("GET","selectEQ.php?value="+str, true);
        keyword.send();
      }
  </script>
  <script>
      function my_type(str){
        if(window.XMLHttpRequest){
          keyword = new XMLHttpRequest();
        }else{
          keyword = new ActiveXObject("Microsoft.XMLHTTP");
        }

        keyword.onreadystatechange=function(){
          if(this.readyState==4 && this.status==200){
                document.getElementById('ty').innerHTML = this.responseText;
          }
        }
        keyword.open("GET","selectType.php?value="+str, true);
        keyword.send();
      }
  </script>
  <script>
      function my_place(str){
        if(window.XMLHttpRequest){
          keyword = new XMLHttpRequest();
        }else{
          keyword = new ActiveXObject("Microsoft.XMLHTTP");
        }

        keyword.onreadystatechange=function(){
          if(this.readyState==4 && this.status==200){
                document.getElementById('pl').innerHTML = this.responseText;
          }
        }
        keyword.open("GET","selectPlace.php?value="+str, true);
        keyword.send();
      }
  </script>
</head>

<body class="hold-transition sidebar-mini">

  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark navbar-navy">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="http://localhost/rentaldb/admin/index.php" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="https://www.rmutsv.ac.th/" class="nav-link">Contact</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar elevation-4 sidebar-dark-navy">
      <!-- Brand Logo -->
      <a href="index.php" class="brand-link navbar-warning" align='center'>
        <span class="brand-text font-weight-bold">ADMINISTRATOR</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="http://localhost/rentaldb/img/avatar.svg" class="img-circle elevation-2" alt="User Image">
          </div>
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <?php if(isset($_SESSION['name'])){ ?>
                  <p><?php echo $_SESSION['name'];} ?></p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="http://localhost/rentaldb/logout.php" class="nav-link">
                      <p>Logout</p>
                    </a>
                  </li>
                </ul>
              </li>
          </ul>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
            <li class="nav-header">MANAGEMENT</li>        
            
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-warehouse"></i>
                <p>
                   ประเภทการเช่า
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="http://localhost/rentaldb/admin/DailyRental/DailyType.php?p=1" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>สถานที่เช่ารายวัน</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="http://localhost/rentaldb/admin/MonthlyRental/MonthlyType.php?p=1" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>สถานที่เช่ารายเดือน(ปี)</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="http://localhost/rentaldb/admin/equipment/Equipment.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>การเช่าอุปกรณ์</p>
                  </a>
                </li>
              </ul>
            </li>
            
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                <p>
                  รายการเช่าสถานที่
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="http://localhost/rentaldb/admin/DailyRental/DailyRent.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>แบบฟอร์มขอเช่ารายวัน</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="http://localhost/rentaldb/admin/MonthlyRental/MonthlyOffer.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>รายการเปิดประมูล</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-edit"></i>
                <p>
                  การจัดการข้อเสนอ
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="http://localhost/rentaldb/admin/DailyRental/DRentMN.php?p=1" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>ข้อเสนอเช่า 
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="http://localhost/rentaldb/admin/MonthlyRental/MOfferRent.php?p=1" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>ข้อเสนอราคา
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="http://general.rmutsv.ac.th/sites/general.rmutsv.ac.th/files/Home/2559/01_05_2559.pdf?fbclid=IwAR3bRSpX6UHl9W4MBF9g22EZwNs_2jSp5gTq3trxn63_6ryg3djr2E9a0mU" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>เอกสารอ้างอิง</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tree"></i>
                <p>
                  การชำระเงิน
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="http://localhost/rentaldb/admin/PayOfferRent.php?p=1" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>รายการชำระเงิน
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="http://localhost/rentaldb/admin/Payment.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>แจ้งชำระเงิน</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-header">ADJUSTMENT</li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>
                  การจัดการบัญชีผู้ใช้
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="http://localhost/rentaldb/admin/userManagement/userManage.php?p=1" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>บทบาทผู้ใช้</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="http://localhost/rentaldb/admin/userManagement/NewUser.php?p=1" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>ผู้ลงทะเบียนใหม่ 
                    </p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="https://www.instagram.com/nada_the_unknown/" class="nav-link">
                <i class="nav-icon fas fa-book"></i>
                <p>
                  Contact
                </p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>
    <!-- /Main Sidebar Container -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-8">
              <h1>การเช่าสถานที่ประเภทรายวัน</h1>
            </div>
            <div class="col-sm-4">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="DPlaceDetail.php?show=<?php echo $DPlace?>">Back</a></li>
                <li class="breadcrumb-item active">Mangement</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <section class="content">
      <!-- /.card -->
        <a  name="move" >
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <!---EDIT AND DELETE PART---->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card">
                            <div class="card-header">
                                <h3 class="card-title">เอกสารที่#<?php echo $RentID?></h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="DailyRentSent.php" method="POST">
                              <input type="hidden" name="rent" value="<?php echo $RentID?>">
                              <input type="hidden" name="placeID" value="<?php echo $DPlace?>">
                              <div class="card-body">
                                <div class="row justify-content-center">
                                  <h2>แบบฟอร์มการขอเช่าสถานที่ราชการ</h2>
                                </div>
                                <hr>
                                <?php if($DPlace > 0) {?> <!------กดเช่าจากหน้าข้อมูลสถานที่------->
                                    <div class="row">
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label>ชื่อ-สกุล</label>
                                          <label class="lead text-primary"><?php echo $row["AccTName"];?></label>
                                        </div>
                                    <div class="form-group">
                                      <label>รหัสประจำตัวประชาชน</label>
                                      <?php foreach($fetchAcc as $result){ ?>
                                      <label class="lead text-primary"><?php echo $result["AccID"];?></label>
                                      <?php } ?>
                                    </div>
                                    <div class="form-group">
                                      <label>เบอร์ติดต่อ</label>
                                      <?php foreach($fetchAcc as $result){ ?>
                                      <label class="lead text-primary"><?php echo $result["AccPhone"];?></label>                                          <?php } ?>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                      <label for="typeT">ประเภทสถานที่</label>
                                      <select class="form-control" name="typeT" id="typeT" disabled>
                                        <?php foreach($fetchPlace as $result){ 
                                        echo "<option value=".$result['DPlaceID'].">".$result['DTTName']."</option>";
                                      } ?>
                                      </select>
                                    </div>
                                    <div class="form-group">
                                      <label for="placeT">ชื่อสถานที่</label>
                                      <select class="form-control" name="placeT" id="placeT" disabled>
                                        <?php foreach($fetchPlace as $result){ 
                                        echo "<option value=".$result['DPlaceID'].">".$result['DPlaceNo'].' '.$result['DPlaceTName']." ".$result['DPlaceEName']."</option>";
                                        } ?>
                                      </select>
                                    </div>
                                    <div class="form-group">
                                      <label for="loc">ที่ตั้งสถานที่</label>
                                      <select class="form-control" name="loc" id="loc" disabled>
                                        <?php foreach($fetchPlace as $result){ 
                                        echo "<option value=".$result['DPlaceID'].">".$result['LocID'].' '.$result['LocTName']."</option>";
                                        } ?>
                                      </select>
                                    </div>
                                    <div class="form-group">
                                      <label for="seat">จำนวนที่นั่ง</label>
                                      <select class="form-control" name="seat" id="seat" disabled>
                                        <?php foreach($fetchPlace as $result){ 
                                        echo "<option value=".$result['DPlaceID'].">".$result['DTSeat']."</option>";
                                        } ?>
                                      </select>
                                    </div>
                                    <div class="form-group">
                                      <label for="agency">ค่าเช่าหน่วยงานราชการ</label>
                                      <select class="form-control" name="agency" id="agency" disabled>
                                        <?php foreach($fetchPlace as $result){ 
                                        echo "<option value=".$result['DPlaceID'].">".$result['DTAgency']." บาท/วัน</option>";
                                        } ?>
                                      </select>
                                    </div>
                                    <div class="form-group">
                                      <label for="private">ค่าเช่าหน่วยงานเอกชน</label>
                                      <select class="form-control" name="private" id="private" disabled>
                                        <?php foreach($fetchPlace as $result){ 
                                        echo "<option value=".$result['DPlaceID'].">".$result['DTPrivate']." บาท/วัน</option>";
                                        } ?>
                                      </select>
                                    </div>
                                    <!-- Date and time range -->
                                    <div class="form-group">
                                      <label>ระยะเวลาการเช่าสถานที่</label>
                                      <div class="form-group">
                                        <div class="input-group">
                                          <div class="input-group-prepend">
                                            <span class="btn btn-primary"><i class="far fa-clock"></i> ตั้งแต่</span>
                                          </div>
                                          <input type="datetime-local" class="form-control float-right" name="start" id="reservationtime" required>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <div class="input-group">
                                          <div class="input-group-prepend">
                                            <span class="btn btn-danger"><i class="far fa-clock"></i> จนถึง</span>
                                          </div>
                                          <input type="datetime-local" class="form-control float-right" name="end" id="reservationtime" required>
                                        </div>
                                      </div>
                                    </div>
                                    <!-- /.form group -->
                                  </div>
                                  <div class="col-md-6">    <!-----left row form------->
                                      <div class="form-group">
                                        <label>สังกัด</label>
                                        <?php foreach($fetchAcc as $result){ ?>
                                          <label class="lead text-primary"><?php echo $result["AccInst"];?></label>
                                        <?php } ?>
                                      </div>
                                      <div class="form-group">
                                        <label>ที่อยู่</label>
                                        <?php foreach($fetchAcc as $result){ ?>
                                        <label class="lead text-primary"><?php echo $result["AccAddress"];?></label>
                                         <?php } ?>
                                      </div>
                                      <div class="form-group">
                                        <label>E-mail</label>
                                        <?php foreach($fetchAcc as $result){ ?>
                                        <label class="lead text-primary"><?php echo $result["LogEmail"];?></label>
                                        <?php } ?>
                                      </div>
                                      <hr>
                                      <label for="">รูปสถานที่</label>
                                      <div class="row justify-content-center">
                                        <div class="form-group col-9">
                                          <div class="col-6">
                                            <?php foreach($fetchPlace as $result){ ?>
                                            <img src="http://localhost/rentaldb/personel/dailyrental/img/<?php echo $result['DPlaceImg'];?>" class="product-image" alt="Product Image">
                                            <?php } ?>
                                          </div>
                                        </div>
                                      </div>
                                      <hr>
                                      <input type="checkbox" name="chk" id="chk" checked onclick="showHideInfo()"> 
                                      <label for="chk">อุปกรณ์เสริม</label>
                                      <div class="form-group" name="checkeq" id="checkeq">
                                        <div class="form-group">
                                          <select class="form-control" name="equip" onchange="my_fun(this.value);">
                                          <?php foreach($fetchEq as $eq){ 
                                            echo "<option value=".$eq['EqID'].">".$eq['EqTName']."</option>";
                                          } ?>
                                          </select>
                                        </div>
                                        <div class="form-group" id="eq">
                                          <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" value="หน่วยงานราชการ" disabled>
                                            </div>
                                            <div class="col-md-6">
                                              <input type="text" class="form-control" value="หน่วยงานเอกชน" disabled>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label for="private">ค่าเช่ารวม</label>
                                          <div class="input-group mb-3">
                                            <input type="text" name="total" class="form-control" placeholder="0.00" required>
                                            <div class="input-group-append ">
                                              <span class="btn btn-primary">บาท</span>
                                            </div>
                                          </div>
                                      </div>
                                  </div>
                                  </div>
                                </div>
                                <div class="row justify-content-center">
                                  <div class="form-group">
                                    <button type="submit" class="btn btn-success btn-lg" name="sent" onclick="return confirm('ยืนยันการส่งคำขอเช่า');"><i class="nav-icon fas fa-file-import"></i> ส่งคำขอเช่า</button>
                                  </div>
                                </div>
                              </div>
                            </form>
                    </div>
                            <?php }else{ ?>             <!------เข้าจากหน้าเว็บ------->
                            <div class="card card-secondary">
                              <div class="card-header">
                                <h3 class="card-title">#</h3>
                              </div>
                              <!-- /.card-header -->
                              <!-- form start -->
                              <form role="form" action="DailyRentSent.php" method="POST">
                                <input type="hidden" name="page" value="<?php echo $DPlace?>">
                                <input type="hidden" name="placeID" value="<?php echo $row['DPlaceID']?>">
                                <div class="card-body">
                                  <div class="row justify-content-center">
                                    <h2>แบบฟอร์มการขอเช่าสถานที่ราชการ</h2>
                                  </div>
                                  <hr>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label>ชื่อ-สกุล</label>
                                                    <label class="lead text-primary"><?php echo $row["AccTName"];?></label>
                                                </div>
                                                <div class="form-group">
                                                    <label>รหัสประจำตัวประชาชน</label>
                                                    <?php foreach($fetchAcc as $result){ ?>
                                                    <label class="lead text-primary"><?php echo $result["AccID"];?></label>
                                                    <?php } ?>
                                                </div>
                                                <div class="form-group">
                                                    <label>เบอร์ติดต่อ</label>
                                                    <?php foreach($fetchAcc as $result){ ?>
                                                    <label class="lead text-primary"><?php echo $result["AccPhone"];?></label>
                                                    <?php } ?>
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                    <label for="placeType">ประเภทสถานที่</label>
                                                    <select class="form-control" name="" id="" onchange="my_type(this.value);">
                                                        <?php foreach($fetchDT as $result){ 
                                                        echo "<option value=".$result['DTID'].">".$result['DTTName']."</option>";
                                                        } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group" id="ty">
                                                    <label for="placeT">ที่ตั้งสถานที่</label>
                                                    <select class="form-control" onchange="my_place(this.value);">
                                                        <?php foreach($fetchDT as $result){ 
                                                        echo "<option value=".$result['DTID'].">เลือกประเภทสถานที่</option>";
                                                        } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group" id="pl">
                                                    <label for="placeType">ชื่อสถานที่</label>
                                                    <select class="form-control" name="placeType" id="placeType">
                                                        <?php foreach($fetchPlace as $result){ 
                                                        echo "<option value=".$result['DPlaceID'].">เลือกสถานที่</option>";
                                                        } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="placeType">จำนวนที่นั่ง</label>
                                                    <select class="form-control" name="placeType" id="placeType" >
                                                        <?php foreach($fetchPlace as $result){ 
                                                        echo "<option value=".$result['DPlaceID'].">".$result['DTSeat']."</option>";
                                                        } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="placeType">ค่าเช่าหน่วยงานราชการ</label>
                                                    <select class="form-control" name="placeType" id="placeType" >
                                                        <?php foreach($fetchPlace as $result){ 
                                                        echo "<option value=".$result['DPlaceID'].">".$result['DTAgency']."</option>";
                                                        } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="placeType">ค่าเช่าหน่วยงานเอกชน</label>
                                                    <select class="form-control" name="placeType" id="placeType" >
                                                        <?php foreach($fetchPlace as $result){ 
                                                        echo "<option value=".$result['DPlaceID'].">".$result['DTPrivate']."</option>";
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>สังกัด</label>
                                                    <?php foreach($fetchAcc as $result){ ?>
                                                    <label class="lead text-primary"><?php echo $result["AccInst"];?></label>
                                                    <?php } ?>
                                                </div>
                                                <div class="form-group">
                                                    <label>ที่อยู่</label>
                                                    <?php foreach($fetchAcc as $result){ ?>
                                                    <label class="lead text-primary"><?php echo $result["AccAddress"];?></label>
                                                    <?php } ?>
                                                </div>
                                                <div class="form-group">
                                                    <label>E-mail</label>
                                                    <?php foreach($fetchAcc as $result){ ?>
                                                    <label class="lead text-primary"><?php echo $result["LogEmail"];?></label>
                                                    <?php } ?>
                                                </div>
                                                <hr>
                                                <label for="">รูปสถานที่</label>
                                                <div class="row justify-content-center">
                                                    <div class="form-group col-9">
                                                        <div class="col-12">
                                                            <?php foreach($fetchPlace as $result){ ?>
                                                            <img src="http://localhost/rentaldb/personel/dailyrental/img/<?php echo $result['DPlaceImg'];?>" class="product-image" alt="Product Image">
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <input type="checkbox" name="chk" id="chk" checked onclick="showHideInfo()"> 
                                                <label for="chk">อุปกรณ์เสริม</label>
                                                <div class="form-group" name="checkeq" id="checkeq">
                                                    <div class="form-group">
                                                        <select class="form-control" value="เลือกอุปกรณ์เสริม" onchange="my_fun(this.value);">
                                                            <?php foreach($fetchEq as $eq){ 
                                                            echo "<option value=".$eq['EqID'].">".$eq['EqTName']."</option>";
                                                            } ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group" id="eq">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" value="หน่วยงานราชการ" disabled>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" value="หน่วยงานเอกชน" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="row justify-content-center">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success btn-lg" name="sent" onclick="return confirm('ยืนยันการส่งคำขอเช่า');">ส่งคำขอเช่า</button>
                                        </div>
                                    </div>
                                </div>
                              </form>
                            </div>
                            <?php } ?>
                            <!-- /.card-body -->
                        </div><!-- /.container-fluid -->
                    </div>
                    <!--- /.EDIT AND DELETE PART---->
                </div>
            </div>
        </a>
    </section>
    </div>
    <footer class="main-footer">
      <div class="float-right d-none d-sm-block">
        <b>Version</b> 3.0.3-pre
      </div>
      <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
      reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Select2 -->
  <script src="plugins/select2/js/select2.full.min.js"></script>
  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- InputMask -->
  <script src="plugins/moment/moment.min.js"></script>
  <script src="plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="dist/js/pages/dashboard.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>  
  <!-- date-range-picker -->
  <script src="plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Bootstrap4 Duallistbox -->
  <script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
  <!-- bootstrap color picker -->
  <script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
  <!-- Bootstrap Switch -->
  <script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
  <!-- Select2 -->
  <script src="plugins/select2/js/select2.full.min.js"></script>
  <!-- Bootstrap4 Duallistbox -->
  <script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>                                                      
</body>
</html>