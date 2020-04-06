<?php 
  session_start();

  if (!isset($_SESSION['id'])) {
      $_SESSION['msg'] = "You must log in first";
      header('location: http://localhost/rentaldb/index.php');
  }
?>
<?php 
    function fetchRent(){
      include "connrent.php";

      $rent = $_GET['rent'];

      $query = mysqli_query($conn, "SELECT * FROM MonthlyRental WHERE MRentID = $rent");
      $resultArray = array();

      while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
          array_push($resultArray, $row);
      }
      mysqli_close($conn);
      return $resultArray;
    }
    
    function fetchMP($offerid){
        include "connrent.php";

        $query = mysqli_query($conn, "SELECT * FROM vOfferDetail  WHERE MOfferID = $offerid");
        $resultArray = array();

        while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            array_push($resultArray, $row);
        }
        mysqli_close($conn);
        return $resultArray;
    }

    function fetchMPay(){
        include "connrent.php";

        $rent = $_GET['rent'];

        $query = mysqli_query($conn, "SELECT * FROM mpayment d
                                      INNER JOIN Banks b
                                      ON b.BankID = d.BankID
                                      WHERE MRentID = $rent");
        $resultArray = array();

        while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            array_push($resultArray, $row);
        }
        mysqli_close($conn);
        return $resultArray;
    }

    $i = 0;

    $fetchRent = fetchRent();
    foreach($fetchRent as $row){
      $rentid = $row['MRentID'];
      $offerid = $row['MOfferID'];
      $start = $row['MRentStart'];
      $end = $row['MRentEnd'];
    }

    $offerid = $offerid;

    $fetchMP = fetchMP($offerid);
    foreach($fetchMP as $row){
        $name = $row['AccName'];
        $place = $row['MPlaceTName'];
        $lo = $row['LocTName'];
        $total = $row['MOfferPrice'];
    }
    $fetchMPay = fetchMPay();

    foreach($fetchMPay as $row){
        $payid = $row['MPayID'];
        $envi = $row['MPayEnvi'];
        $datetime = $row['MPayDate'];
        $paid = $row['MPayTotal'];
        $bank = $row['BankTName'];
        $status = $row['MPayStatus'];
    }
?>

<!DOCTYPE html>
<html>
<head>
  <style>
    @import url('https://fonts.googleapis.com/css?family=Kanit&display=swap');
  </style>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>RPRMS | Monthly Place</title>
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
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Kanit -->
  <link href="https://fonts.googleapis.com/css?family=Kanit&display=swap" rel="stylesheet">
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
              <h1>รายละเอียดการเช่า : รหัสที่ <?php echo $payid;?></h1>
            </div>
            <div class="col-sm-4">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="http://localhost/rentaldb/admin/PayOfferRent.php?p=1">Back</a></li>
                <li class="breadcrumb-item active">Mangement</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <section class="content">
      <!-- Default box -->
      <div class="card card-solid">
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-sm-6">
                <h4><i class="fas fa-image"></i> หลักฐานการชำระค่าเช่า</h4>
              <div class="col-12">
                <img src="MonthlyRental/img/<?php echo $envi;?>" class="product-image" alt="Product Image">
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <h2 class="my-3"><?php echo $place ?></h2>
              <hr>
              <h4><i class="fas fa-map-marker-alt"></i> ที่ตั้งสถานที่ <small>Location</small>
                <label class="btn btn-default text-center">
                    <span class="text-xm"><?php echo $lo ?></span>
                </label></h4>
              <hr>
              <h4><i class="fas fa-user"></i> ผู้เช่าสถานที่
                <label class="btn btn-default text-center">
                  <span class="text-xm"><?php echo $name; ?></span>
                </label>
              </h4>
              <hr>
              <h4 class="mt-3"><i class="far fa-clock"></i> ระยะเวลาการเช่า
                <label class="btn btn-default text-center">
                  <span class="text-xm">เริ่มต้น <?php echo $start; ?></span><br>
                  <span class="text-xm">สิ้นสุด <?php echo $end; ?></span>
                </label>
              </h4>
              <h4 class="mt-3"><i class="fas fa-file-invoice-dollar"></i> ค่าเช่ารายปี
                <label class="btn btn-default text-center"><span class="text-xm">ปีละ <?php echo $total; ?> บาท</span></label>
              </h4>
              <h4 class="mt-3"><i class="fas fa-file-invoice-dollar"></i> ค่าเช่ารายเดือน
                <label class="btn btn-default text-center"><span class="text-xm">เดือนละ <?php echo $total/12; ?> บาท</span></label>
              </h4>
              <h4 class="mt-3"><i class="fas fa-hand-holding-usd"></i> ค่าเช่าที่ชำระ
                <label class="btn btn-warning text-center"><span class="text-xm"><?php echo $paid; ?> บาท</span><br></label>
              </h4>
              <h4 class="mt-3"><i class="far fa-calendar-alt"></i> วัน/เวลาที่ชำระค่าเช่า
                <label class="btn btn-warning text-center"><span class="text-xm"><?php echo $datetime; ?></span><br></label>
              </h4>
              <h4 class="mt-3"><i class="fas fa-money-check-alt"></i> ธนาคารที่ชำระค่าเช่า
                <label class="btn btn-warning text-center"><span class="text-xm"><?php echo $bank; ?></span><br></label>
              </h4>
              <hr>              
            </div>
          </div>
          <?php if($status == 0){ ?>
          <br><div class="row justify-content-center">
              <div class="row">
                <a class="btn btn-success btn-lg" data-slide="true" href="PayProcess.php?mpayid=<?php echo $payid?>" role="button">
                    <i class="nav-icon fas fa-edit"></i> 
                    ยืนยันความถูกต้อง    
                </a>
              </div>
            </div>
          <?php }else{ ?>
            <br><div class="row justify-content-center">
              <div class="row">
                <a class="btn btn-success btn-lg disabled" data-slide="true" href="PayProcess.php?mpayid=<?php echo $payid?>" role="button">
                    <i class="nav-icon fas fa-edit"></i> 
                    ยืนยันความถูกต้อง    
                </a>
              </div>
            </div>
          <?php } ?>
        </div>
        <!-- /.card-body -->

        
      </div>
      <!-- /.card -->

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
  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="plugins/moment/moment.min.js"></script>
  <script src="plugins/daterangepicker/daterangepicker.js"></script>
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
</body>
</html>