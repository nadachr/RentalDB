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

    function fetchO(){
        include "connrent.php";
        
        if (isset($_GET['offer'])) {
            $offerid = $_GET['offer'];
          } else {
            $offerid = 0;
          }
       
        $query = mysqli_query($conn, "SELECT * FROM vofferdetail WHERE MOfferID = $offerid");
        $resultArray = array();
  
        while($result = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            array_push($resultArray, $result);
        }
        mysqli_close($conn);
        return $resultArray;
    }

    function fetchBank(){
        include "connrent.php";
       
        $query = mysqli_query($conn, "SELECT * FROM banks");
        $resultArray = array();
  
        while($result = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            array_push($resultArray, $result);
        }
        mysqli_close($conn);
        return $resultArray;
    }

    if ((isset($_GET['offer']))&(isset($_GET['rent']))) {
        $offerid = $_GET['offer'];
        $rentid = $_GET['rent'];
      } else {
        $offerid = 0;
        $rentid = 0;
      }

    $fetchName = fetchName();
    $fetchO = fetchO();
    $fetchBank = fetchBank();
    $pricey = 0;

    foreach($fetchO as $result){
      $pricey = $result['MOfferPrice'];
    }

    $pricem = $pricey/12;

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PRMS | Monthly Payment</title>
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

<body class="hold-transition sidebar-mini layout-fixed">
  
  <!------DATABASE CONNECTION AND EXECUTING------------>
  <?php 
    include "connrent.php";
    ini_set('display_errors', 1);
    error_reporting(~0);
    $query = mysqli_query($conn, "SELECT COUNT(*) FROM dailyrental WHERE DRentStatus = 0;");
  ?>
  <!---------END DATABASE------------>

  <!---------MAIN SPACE------------->
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
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">แจ้งชำระค่าเช่าพื้นที่รายเดือน(ปี)</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <section class="content">
        <!-- /.card -->
            <a  name="move" >
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <!---EDIT AND DELETE PART---->
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h3 class="card-title">ยืนยันการชำระเงิน</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <div class="card-body">
                                    <div class="row justify-content-center">
                                        <h1>ข้อมูลการชำระเงิน</h1>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5>
                                            <?php if($offerid!=0){ ?>
                                                <div class="form-group">
                                                    <div class="row justify-content-center">
                                                        <form action="MonthlyPayDetail.php" method="POST">
                                                            <input type="hidden" name="rentid" id="rentid" value="<?php echo $_GET['rent']?>">
                                                            <div class="col-md-12">
                                                              <div class="form-group">
                                                                <label>ชื่อผู้ชำระเงิน</label>
                                                                <?php foreach($fetchName as $row){ ?>
                                                                <label class="lead text-primary"><?php echo $row["AccTName"];}?></label>
                                                              </div>
                                                              <div class="form-group">
                                                                <label for="offerid">รหัสการเช่า</label>
                                                                <div class="input-group mb-3">
                                                                  <input type="text" name="rentid" value="<?php echo $_GET['rent']?>" class="form-control" disabled>
                                                                </div>
                                                              </div>
                                                              <div class="form-group">
                                                                <label for="offerid">ราคาที่เสนอ(ต่อปี)</label>
                                                                <div class="input-group mb-3">
                                                                  <input type="text" name="offerid" value="<?php echo $pricey?> บาท" class="form-control" disabled>
                                                                </div>
                                                              </div>
                                                             <div class="form-group">
                                                                <label for="offerid">ค่าชำระ(ต่อเดือน)</label>
                                                                <div class="input-group mb-3">
                                                                  <input type="text" name="offerid" value="<?php echo $pricem?> บาท" class="form-control" disabled>
                                                                </div>
                                                              </div>
                                                              <div class="form-group">
                                                                <label for="private">มูลค่าที่ชำระ</label>
                                                                <div class="input-group mb-3">
                                                                    <input type="text" name="paytotal" class="form-control" placeholder="0.00" required>
                                                                    <div class="input-group-append ">
                                                                    <span class="btn btn-primary">บาท</span>
                                                                    </div>
                                                                </div>
                                                              </div>
                                                              <div class="form-group">
                                                                <label for="seat">จากธนาคาร</label>
                                                                <select class="form-control" name="bankid" id="seat">
                                                                <?php foreach($fetchBank as $result){ 
                                                                echo "<option value=".$result['BankID'].">".$result['BankTName']."</option> required";
                                                                } ?>
                                                                </select>
                                                              </div>
                                                              <div class="form-group">
                                                                <label>วันเวลาที่ชำระ <small class="text-danger">ระบุตามใบเสร็จ</small></label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="btn btn-primary"><i class="far fa-clock"></i></span>
                                                                    </div>
                                                                    <input type="datetime-local" class="form-control float-right" name="paydatetime" id="reservationtime" required>
                                                                </div>
                                                              </div>
                                                              <div class="form-group">
                                                                <label for="envi">หลักฐานการโอนเงิน</label>
                                                                <div class="input-group mb-3">
                                                                    <input type="file" id="envi" name="envi" required>
                                                                </div>
                                                              </div>
                                                              <div class="row justify-content-center">
                                                                <div class="form-group">
                                                                    <input type="submit" class="btn btn-success btn-lg" name="paid" value="ยืนยันการชำระเงิน" role='button' onclick="return confirm('ยืนยันการชำระเงิน');">
                                                                </div>
                                                              </div>
                                                            </form>
                                                          </div>
                                                      </div>
                                                      <?php }else{ ?>
                                                      <div class="form-group">
                                                          <div class="row justify-content-center">
                                                              <form action="MonthlyPayDetail.php" method="POST">
                                                                <div class="col-md-12">
                                                                  <div class="form-group">
                                                                    <label>ชื่อผู้ชำระเงิน</label>
                                                                    <?php foreach($fetchName as $row){ ?>
                                                                    <label class="lead text-primary"><?php echo $row["AccTName"];}?></label>
                                                                  </div>
                                                                <div class="form-group">
                                                                  <label for="private">รหัสการเช่า</label>
                                                                  <div class="input-group mb-3">
                                                                    <input type="text" name="rentid" class="form-control" required>
                                                                  </div>
                                                                </div>
                                                                <div class="form-group">
                                                                  <label for="offerid">ราคาที่เสนอ(ต่อปี)</label>
                                                                    <div class="input-group mb-3">
                                                                      <input type="text" name="offerid" placeholder="บาท/ปี" class="form-control" required>
                                                                    </div>
                                                                  </div>
                                                                <div class="form-group">
                                                                  <label for="offerid">ค่าชำระ(ต่อเดือน)</label>
                                                                  <div class="input-group mb-3">
                                                                    <input type="text" name="offerid" placeholder="บาท/เดือน" บาท" class="form-control" required>
                                                                  </div>
                                                                </div>
                                                                <div class="form-group">
                                                                  <label for="private">มูลค่าที่ชำระ</label>
                                                                  <div class="input-group mb-3">
                                                                      <input type="text" name="paytotal" class="form-control" placeholder="0.00" required>
                                                                      <div class="input-group-append ">
                                                                        <span class="btn btn-primary">บาท</span>
                                                                      </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                  <label for="bankid">จากธนาคาร</label>
                                                                  <select class="form-control" name="bankid" id="bankid">
                                                                  <?php foreach($fetchBank as $result){ 
                                                                    echo "<option value=".$result['BankID'].">".$result['BankTName']."</option>";
                                                                  } ?>                                      
                                                                  </select>
                                                                </div>
                                                                <div class="form-group">
                                                                  <label>วันเวลาที่ชำระ</label>
                                                                  <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                      <span class="btn btn-primary"><i class="far fa-clock"></i></span>
                                                                    </div>
                                                                    <input type="datetime-local" class="form-control float-right" name="paydatetime" id="reservationtime" required>
                                                                  </div>
                                                                </div>
                                                                <div class="form-group">
                                                                  <label for="envi">หลักฐานการโอนเงิน</label>
                                                                  <div class="input-group mb-3">
                                                                    <input type="file" id="envi" name="envi" required>
                                                                  </div>
                                                                </div>
                                                                <div class="row justify-content-center">
                                                                  <div class="form-group">
                                                                    <input type="submit" class="btn btn-success btn-lg" name="paid" value="ยืนยันการชำระเงิน" role='button' onclick="return confirm('ยืนยันการชำระเงิน');">
                                                                  </div>
                                                                </div>
                                                              </form>
                                                          </div>
                                                      </div>
                                                  <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div><!-- /.container-fluid -->
                        </div>
                    <!--- /.EDIT AND DELETE PART---->
                    </div>
                </div>
            </a>
        </section>
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
      All rights reserved.
    </footer>

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
