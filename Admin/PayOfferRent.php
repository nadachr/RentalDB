<?php 
  session_start();
  include "connrent.php";
  if (!isset($_SESSION['id'])) {
      $_SESSION['msg'] = "You must log in first";
      header('location: http://localhost/rentaldb/index.php');
  }
?>
<?php 
    function searchDP(){
        include "connrent.php";

        if (isset($_POST['search1']) == 0) {
          $search = '';
        } else {
          $search = $_POST['search1'];
        }

        #ส่วนการแสดงข้อมูล 5 record ต่อหน้า
        $perpage = 5;
        if(isset($_GET['p'])){
          $p = $_GET['p'];
        }else{
          $p = 1;
        }
        $start = ($p-1) * $perpage;
        #--------------------------

        $query = mysqli_query($conn, "CALL searchDPay('$search', $start, $perpage)");
        $resultArray = array();

        while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            array_push($resultArray, $row);
        }
        mysqli_close($conn);
        return $resultArray;
    }

    function searchMP(){
      include "connrent.php";

      if (isset($_POST['search2']) == 0) {
        $search = '';
      } else {
        $search = $_POST['search2'];
      }

      #ส่วนการแสดงข้อมูล 5 record ต่อหน้า
      $perpage = 5;
      if(isset($_GET['p'])){
        $p = $_GET['p'];
      }else{
        $p = 1;
      }
      $start = ($p-1) * $perpage;
      #--------------------------

      $query = mysqli_query($conn, "CALL searchMPay('$search', $start, $perpage)");
      $resultArray = array();

      while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
          array_push($resultArray, $row);
      }
      mysqli_close($conn);
      return $resultArray;
  }

    function fetchRent(){
      include "connrent.php";
      
      $query = mysqli_query($conn, "SELECT * FROM vdrent;");
      $resultArray = array();

      while($result = mysqli_fetch_array($query, MYSQLI_ASSOC)){
          array_push($resultArray, $result);
      }
      mysqli_close($conn);
      return $resultArray;
     }

    if (isset($_GET['show']) == 0) {
      $pType = 0;
    } else {
      $pType = $_GET['show'];
    }

    if(isset($_GET['p'])){
      $p = $_GET['p'];
    }else{
      $p = 1;
    }    

    $i = 0;

    $searchDP = searchDP();
    
    foreach ($searchDP as $row) {
      
    }

    $searchMP = searchMP();
    
    foreach ($searchMP as $row) {
      
    }

    $fetchRent = fetchRent();
?>

<!DOCTYPE html>
<html>
<head>
  <style>
    @import url('https://fonts.googleapis.com/css?family=Kanit&display=swap');
  </style>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>RPRMS | Payment Management</title>
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
            <div class="col-sm-6">
              <h1>การจัดการแจ้งชำระค่าเช่ารายวัน / รายเดือน(ปี)</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Refresh</a></li>
                <li class="breadcrumb-item active">Management</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row"> <!--------รายวัน-------->
            <!-- /.col -->
            <div class="col-md-12">
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">รายการแจ้งชำระค่าเช่ารายวัน</h3>
                  <div class="card-tools">
                  <form action="" method="POST">
                    <div class="input-group input-group-sm" style="width: 250px;"> 
                      <input type="text" name="search1" class="form-control float-right" placeholder="Search">
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
                        <th>#</th>
                        <th>รหัสการชำระ</th>
                        <th>รหัสการเช่า</th>
                        <th>เวลาชำระ</th>
                        <th>สถานะ</th>
                        <th style="width: 120px">รายละเอียด</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        foreach($searchDP as $row){
                          if($row['DPayStatus'] == 1 & $row['DPayEnvi'] != NULL){
                      ?>
                      <tr>
                        <td><?php $i++; echo $i; ?></td>
                        <td><?php echo $row["DPayID"]; ?></td>
                        <td><?php echo $row["DRentID"]; ?></td>
                        <td><?php echo $row["DPayDateTime"]; ?></td>
                        <td>จ่ายแล้ว</td>
                        <td align="center">
                          <a class="btn btn-info" data-slide="true" href="PayDdetail.php?rent=<?php echo $row['DRentID']?>&pay=<?php echo $row['DPayID']?>" role="button">
                            <i class="nav-icon fas fa-info-circle"></i>
                          </a>
                        </td>
                      </tr>
                        <?php }else{ ?>
                      <tr>
                        <td class="text-primary">ใหม่</td>
                        <td class="text-primary"><?php echo $row["DPayID"]; ?></td>
                        <td class="text-primary"><?php echo $row["DRentID"]; ?></td>
                        <td class="text-primary"><?php echo $row["DPayDateTime"]; ?></td>
                        <td class="text-primary">ยังไม่ตรวจสอบ</td>
                        <td align="center">
                          <a class="btn btn-info" data-slide="true" href="PayDdetail.php?rent=<?php echo $row['DRentID']?>&pay=<?php echo $row['DPayID']?>" role="button">
                            <i class="nav-icon fas fa-info-circle"></i>
                          </a>
                        </td>
                      </tr>
                      <?php }} ?>
                    </tbody>
                  </table>
                  <?php 
                    $perpage = 5;
                    $sql = "SELECT * FROM DPayment;";
                    $query2 = mysqli_query($conn, $sql);
                    $total_record = mysqli_num_rows($query2);
                    $total_page = ceil(($total_record / $perpage));
                  ?>
                  <div class="card-footer clearfix">
                    <nav>
                      <ul class="pagination pagination0sm m-0 float-right">
                        <li class="page-item">
                          <a class="page-link" href="PayOfferRent.php?p=1" aria-label="Previous"> <span aria-hidden="true">&laquo;</span></a>
                        </li>
                        <?php for($i=1;$i<=$total_page;$i++){ ?>
                        <li class="page-item"><a class="page-link" href="PayOfferRent.php?p=<?php echo $i?>"><?php echo $i;?></a></li>
                        <?php } ?>
                        <li class="page-item">
                          <a class="page-link" href="PayOfferRent.php?p=<?php echo $total_page?>" aria-label="Next"> <span aria-hidden="true">&raquo;</span></a>
                        </li>
                      </ul>
                    </nav>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <div class="row"> <!----------รายเดือน---------->
            <!-- /.col -->
            <div class="col-md-12">
              <div class="card card-warning">
                <div class="card-header">
                  <h3 class="card-title">รายการแจ้งชำระค่าเช่ารายเดือน(ปี)</h3>
                  <div class="card-tools">
                  <form action="" method="POST">
                    <div class="input-group input-group-sm" style="width: 250px;"> 
                      <input type="text" name="search2" class="form-control float-right" placeholder="Search">
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
                        <th>#</th>
                        <th>รหัสการชำระ</th>
                        <th>รหัสการเช่า</th>
                        <th>เวลาชำระ</th>
                        <th>สถานะ</th>
                        <th style="width: 120px">รายละเอียด</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        foreach($searchMP as $row){
                          if($row['MPayStatus'] == 1){
                      ?>
                      <tr>
                        <td><?php $i++; echo $i; ?></td>
                        <td><?php echo $row["MPayID"]; ?></td>
                        <td><?php echo $row["MRentID"]; ?></td>
                        <td><?php echo $row["MPayDate"]; ?></td>
                        <td>จ่ายแล้ว</td>
                        <td align="center">
                          <a class="btn btn-info" data-slide="true" href="PayMdetail.php?rent=<?php echo $row['MRentID']?>" role="button">
                            <i class="nav-icon fas fa-info-circle"></i>
                          </a>
                        </td>
                      </tr>
                        <?php }else{ ?>
                      <tr>
                        <td class="text-primary">ใหม่</td>
                        <td class="text-primary"><?php echo $row["MPayID"]; ?></td>
                        <td class="text-primary"><?php echo $row["MRentID"]; ?></td>
                        <td class="text-primary"><?php echo $row["MPayDate"]; ?></td>
                        <td class="text-primary">ยังไม่ตรวจสอบ</td>
                        <td align="center">
                          <a class="btn btn-info" data-slide="true" href="PayMdetail.php?rent=<?php echo $row['MRentID']?>" role="button">
                            <i class="nav-icon fas fa-info-circle"></i>
                          </a>
                        </td>
                      </tr>
                      <?php }} ?>
                    </tbody>
                  </table>
                  <?php 
                    $perpage = 5;
                    $sql = "SELECT * FROM mpayment;";
                    $query2 = mysqli_query($conn, $sql);
                    $total_record = mysqli_num_rows($query2);
                    $total_page = ceil(($total_record / $perpage));
                  ?>
                  <div class="card-footer clearfix">
                    <nav>
                      <ul class="pagination pagination0sm m-0 float-right">
                        <li class="page-item">
                          <a class="page-link" href="PayOfferRent.php?p=1" aria-label="Previous"> <span aria-hidden="true">&laquo;</span></a>
                        </li>
                        <?php for($i=1;$i<=$total_page;$i++){ ?>
                        <li class="page-item"><a class="page-link" href="PayOfferRent.php?p=<?php echo $i?>"><?php echo $i;?></a></li>
                        <?php } ?>
                        <li class="page-item">
                          <a class="page-link" href="PayOfferRent.php?p=<?php echo $total_page?>" aria-label="Next"> <span aria-hidden="true">&raquo;</span></a>
                        </li>
                      </ul>
                    </nav>
                  </div>
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