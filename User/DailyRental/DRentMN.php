<?php 
  session_start();
  include "connrent.php";
  if (!isset($_SESSION['id'])) {
      $_SESSION['msg'] = "You must log in first";
      header('location: http://localhost/rentaldb/index.php');
  }
?>
<?php 

  $AccNo = '';  

  function Account(){
    if(isset($_SESSION['name'])){
    $accname = $_SESSION['name'];
    }else{
      $accname = '';
    }
    include "connrent.php";
    $query = mysqli_query($conn, "SELECT AccNo, AccName FROM vofferdetail WHERE MOfferStatus = 0 AND AccEName = '$accname';");
    $resultArray = array();

    while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
        array_push($resultArray, $row);
    }
    mysqli_close($conn);
    return $resultArray;
  }

  $Account = Account();
  foreach($Account as $row){
    $AccNo = $row['AccNo'];
  }

    function searchDP(){
        include "connrent.php";

        if(isset($_GET['dprent'])){
          $search = $_GET['dprent'];
        }else{
          if (isset($_POST['search']) == 0) {
            $search = '';
          } else {
            $search = $_POST['search'];
          }
        }
         
        #ส่วนการแสดงข้อมูล 10 record ต่อหน้า
        $perpage = 10;
        if(isset($_GET['p'])){
          $p = $_GET['p'];
        }else{
          $p = 1;
        }
        $start = ($p-1) * $perpage;
        #--------------------------

        $query = mysqli_query($conn, "CALL searchDRent('$search', $start, $perpage)");
        $resultArray = array();

        while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            array_push($resultArray, $row);
        }
        mysqli_close($conn);
        return $resultArray;
    }

    if($AccNo != 0){
      function fetchRent($AccNo){
        include "connrent.php";

        $query = mysqli_query($conn, "SELECT * FROM vdrent WHERE AccNo = $AccNo;");
        $resultArray = array();

        while($result = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            array_push($resultArray, $result);
        }
        mysqli_close($conn);
        return $resultArray;
      }
      $fetchRent = fetchRent($AccNo);
    }

    if(isset($_GET['p'])){
      $p = $_GET['p'];
    }else{
      $p = 1;
    }    

    $i = 0;

    $fetchDP = searchDP();
    
    
    foreach ($fetchDP as $row) {

    };
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
    <nav class="main-header navbar navbar-expand navbar-light navbar-warning">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="http://localhost/rentaldb/user/index.php" class="nav-link">Home</a>
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
    <aside class="main-sidebar elevation-4 sidebar-light-navy">
      <!-- Brand Logo -->
      <a href="index.php" class="brand-link navbar-dark-navi" align='center'>
        <span class="brand-text font-weight-bold">USER</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="img/undraw_male_avatar_323b.svg" class="img-circle elevation-2" alt="User Image">
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
            <li class="nav-header">Menu</li>        
            
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
                  <a href="http://localhost/rentaldb/user/DailyRental/DailyType.php?p=1" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>สถานที่เช่ารายวัน</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="http://localhost/rentaldb/user/MonthlyRental/MonthlyType.php?p=1" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>สถานที่เช่ารายเดือน(ปี)</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="http://localhost/rentaldb/user/equipment/Equipment.php" class="nav-link">
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
                  <a href="http://localhost/rentaldb/user/DailyRental/DailyRent.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>แบบฟอร์มขอเช่ารายวัน</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="http://localhost/rentaldb/user/MonthlyRental/MonthlyOffer.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>รายการเปิดประมูล</p>
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
                  <a href="http://localhost/rentaldb/user/Payment.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>แจ้งชำระเงิน</p>
                  </a>
                </li>
              </ul>
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
            <div class="col-sm-6">
              <h1>รายการขอเช่าสถานที่</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Refresh</a></li>
                <li class="breadcrumb-item active">User</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row justify-content-center">
            <!-- /.col -->
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">รายการขอเช่าสถานที่นี้และสถานะการเช่า</h3>
                  <div class="card-tools">
                  <form action="" method="POST">
                    <div class="input-group input-group-sm" style="width: 250px;"> 
                      <input type="text" name="search" class="form-control float-right" placeholder="Search">
                      <div class="input-group-append">
                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                      </div>
                    </div>
                  </form>
                </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th style="width: 10px">#</th>
                        <th >รหัส</th>
                        <th>ชื่อสถานที่</th>
                        <th>ที่ตั้ง</th>
                        <th style="width: 100px">ระยะเวลา</th>
                        <th>วัน/เวลาเริ่มต้นการเช่า</th>
                        <th>สถานะ</th>
                        <th style="width: 120px">รายละเอียด</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        foreach($fetchDP as $row){
                          if(($row['DRentBe']<=0)&($row['DRentLeft']>0)){
                      ?>
                      <tr>
                        <td><?php $i++; echo $i; ?></td>
                        <td><?php echo $row["DRentID"]; ?></td>
                        <td><?php echo $row["DPlaceTName"]; ?></td>
                        <td><?php echo $row["LocTName"]; ?></td>
                        <td><?php echo $row["DRentDay"]; ?> วัน</td>
                        <td><?php echo $row["DRentStart"]; ?></td>
                        <td class="text-success">อยู่ระหว่างการเช่า</td>
                        <td align="center">
                          <a class="btn btn-info" data-slide="true" href="DailyRentDetailShow.php?rents=<?php echo $row['DRentID']?>" role="button">
                            <i class="nav-icon fas fa-info-circle"></i>
                          </a>
                        </td>
                      </tr>
                      <?php }else if(($row['DRentBe']>0)&($row['DRentLeft']>0)){ ?>
                      <tr>
                        <td>3</td>
                        <td><?php echo $row["DRentID"]; ?></td>
                        <td><?php echo $row["DPlaceTName"]; ?></td>
                        <td><?php echo $row["LocTName"]; ?></td>
                        <td><?php echo $row["DRentDay"]; ?> วัน</td>
                        <td><?php echo $row["DRentStart"]; ?></td>
                        <td class="text-primary">ยังไม่ถึงวันเช่า</td>
                        <td align="center">
                          <a class="btn btn-info" data-slide="true" href="DailyRentDetailShow.php?rent=<?php echo $row['DRentID']?>" role="button">
                            <i class="nav-icon fas fa-info-circle"></i>
                          </a>
                        </td>
                      </tr>
                      <?php }else{ ?>
                        <tr>
                        <td>3</td>
                        <td><?php echo $row["DRentID"]; ?></td>
                        <td><?php echo $row["DPlaceTName"]; ?></td>
                        <td><?php echo $row["LocTName"]; ?></td>
                        <td><?php echo $row["DRentDay"]; ?> วัน</td>
                        <td><?php echo $row["DRentStart"]; ?></td>
                        <td>สิ้นสุดการเช่า</td>
                        <td align="center">
                          <a class="btn btn-info" data-slide="true" href="DailyRentDetailShow.php?rent=<?php echo $row['DRentID']?>" role="button">
                            <i class="nav-icon fas fa-info-circle"></i>
                          </a>
                        </td>
                      </tr>
                      <?php }} ?>
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
        </div>
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