<?php 
    include "connrent.php";

    if(isset($_GET['accept'])){
        $AccNo = $_GET['accept'];

        $query = mysqli_query($conn, "UPDATE account SET AccStatus = 1 WHERE AccNo = $AccNo;");
        #echo $offer;
    }

    if(isset($_GET['reject'])){
        $offer = $_GET['reject'];
        $AccNo = $_GET['accno'];

        $query = mysqli_query($conn, "UPDATE monthlyoffer SET MOfferResult = 'rejected' WHERE MOfferID = $offer;");
        $query2 = mysqli_query($conn, "INSERT INTO monthlyrental(MOfferID) VALUE ($offer);");
        #echo $offer;
        header("location:MRentDetail.php?accno=$AccNo&offer=$offer");
    }


?>

<?php 
  session_start();

  if (!isset($_SESSION['id'])) {
      $_SESSION['msg'] = "You must log in first";
      header('location: http://localhost/rentaldb/index.php');
  }
?>

<?php 
    function fetchAcc(){
        include "connrent.php";

        $accno = $_GET['show'];

        $query = mysqli_query($conn, "SELECT * FROM vaccount  WHERE AccNo = $accno");
        $resultArray = array();

        while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            array_push($resultArray, $row);
        }
        mysqli_close($conn);
        return $resultArray;
    }
  
    function fetchRole(){
        include "connrent.php";
  
        $query = mysqli_query($conn, "SELECT * FROM role");
        $resultArray = array();
  
        while($result = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            array_push($resultArray, $result);
        }
        mysqli_close($conn);
        return $resultArray;
    }

    function fetchAccRole(){
        include "connrent.php";
  
        $accno = $_GET['show'];

        $query = mysqli_query($conn, "SELECT * FROM accrole ar INNER JOIN Role r ON r.RoleID = ar.RoleID WHERE AccNo = $accno");
        $resultArray = array();
  
        while($result = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            array_push($resultArray, $result);
        }
        mysqli_close($conn);
        return $resultArray;
    }
    $status = 1;
    $accno = $_GET['show'];
    $i = 0;
    $RoleName = 'รอยืนยัน';

    require_once "editMType.php";

    $fetchAcc = fetchAcc();
    $fetchRole = fetchRole();
    $fetchAccRole = fetchAccRole();
    foreach($fetchAccRole as $result){
        $RoleID = $result['RoleID'];
        $RoleName = $result['RoleTName'];
        $status = $result['ArStatus'];
    }

    foreach($fetchAcc as $row){
      $accName = $row['AccTName'];
      $accUser = $row['LogUser'];
      $email = $row['LogEmail'];
      $accid  = $row['AccID'];
      $bdate  = $row['AccBirthdate'];
      $age = $row['AccAge'];
      $phone = $row['AccPhone'];
      $inst = $row['AccInst'];
      $addr = $row['AccAddress'];
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
              <h1>ข้อมูลผู้ใช้ : <?php echo $accUser;?></h1>
            </div>
            <div class="col-sm-4">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="http://localhost/rentaldb/admin/userManagement/NewUser.php?p=1">ผู้ลงทะเบียนใหม่</a></li>
                <li class="breadcrumb-item active"><a href="http://localhost/rentaldb/admin/userManagement/userManage.php?p=1">บทบาทผู้ใช้</a></li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <section class="content">
      <!-- Default box -->
      <div class="card card-solid">
        <div class="card-body">
          <div class="container">
            <div class="row">
              <div class="col-12 col-sm-6">
                  <?php if($status == 1){ ?>
                <h4><i class="fas fa-user"></i> ชื่อผู้ใช้
                  <label class="btn btn-default text-center">
                      <span class="text-lg"><?php echo $accName ?></span>
                  </label>
                </h4>
                  <?php }else{ ?>
                <h4 class="text-danger"><i class="fas fa-user text-danger"></i> ชื่อผู้ใช้
                  <label class="btn btn-danger text-center">
                      <span class="text-lg"><?php echo $accName ?></span>
                  </label>
                </h4>
                <?php } ?>
                <?php if($status == 1){ ?>
                <h4><i class="fas fa-at"></i> E-mail
                  <label class="btn btn-default text-center">
                      <span class="text-lg"><?php echo $email ?></span>
                  </label>
                </h4>
                <?php }else{ ?>
                <h4 class="text-danger"><i class="fas fa-at text-danger"></i> E-mail
                  <label class="btn btn-danger text-center">
                      <span class="text-lg"><?php echo $email ?></span>
                  </label>
                </h4>
                <?php } ?>
                <?php if($status == 1){ ?>
                <h4><i class="far fa-calendar-alt"></i> วันเกิด
                  <label class="btn btn-default text-center">
                      <span class="text-lg"><?php echo $bdate ?></span>
                  </label>
                </h4>
                <?php }else{ ?>
                <h4 class="text-danger"><i class="fas fa-calendar-alt"></i> วันเกิด
                  <label class="btn btn-danger text-center">
                      <span class="text-lg"><?php echo $bdate ?></span>
                  </label>
                </h4>
                <?php } ?>
                <?php if($status == 1){ ?>
                <h4><i class="fas fa-birthday-cake"></i> อายุ
                  <label class="btn btn-default text-center">
                      <span class="text-lg"><?php echo $age ?> ปี</span>
                  </label>
                </h4>
                <?php }else{ ?>
                <h4 class="text-danger"><i class="fas fa-birthday-cake"></i> อายุ
                  <label class="btn btn-danger text-center">
                      <span class="text-lg"><?php echo $age ?> ปี</span>
                  </label>
                </h4>
                <?php } ?>
                <?php if($status == 1){ ?>
                <h4><i class="fas fa-id-card"></i> รหัสประจำตัวประชาชน
                  <label class="btn btn-default text-center">
                      <span class="text-lg"><?php echo $accid ?></span>
                  </label>
                </h4>
                <?php }else{ ?>
                <h4 class="text-danger"><i class="fas fa-id-card"></i> รหัสประจำตัวประชาชน
                  <label class="btn btn-danger text-center">
                      <span class="text-lg"><?php echo $accid ?></span>
                  </label>
                </h4>
                <?php } ?>
              </div>
              <div class="col-12 col-sm-6">
                <?php if($status == 1){ ?>
                <h4><i class="fas fa-id-card-alt"></i> หน่วยงานที่สังกัด
                  <label class="btn btn-default text-center">
                      <span class="text-lg"><?php echo $inst ?></span>
                  </label>
                </h4>
                <?php }else{ ?>
                <h4 class="text-danger"><i class="fas fa-id-card-alt"></i> หน่วยงานที่สังกัด
                  <label class="btn btn-danger text-center">
                      <span class="text-lg"><?php echo $inst ?></span>
                  </label>
                </h4>
                <?php } ?>
                <?php if($status == 1){ ?>
                <h4><i class="fas fa-map-marker-alt"></i> ที่อยู่
                  <label class="btn btn-default text-center">
                      <span class="text-lg"><?php echo $addr ?></span>
                  </label>
                </h4>
                <?php }else{ ?>
                <h4 class="text-danger"><i class="fas a-map-marker-alt"></i> ที่อยู่
                  <label class="btn btn-danger text-center">
                      <span class="text-lg"><?php echo $addr ?></span>
                  </label>
                </h4>
                <?php } ?>
                <?php if($status == 1){ ?>
                <h4><i class="fas fa-user-circle"></i> บทบาท
                  <label class="btn btn-default text-center">
                      <span class="text-lg"><?php echo $RoleName ?></span>
                  </label>
                </h4>
                <?php }else{ ?>
                <h4 class="text-danger"><i class="fas a-map-marker-alt"></i> บทบาท
                  <label class="btn btn-danger text-center">
                      <span class="text-lg">แบน</span>
                  </label>
                </h4>
                <?php } ?>

                <?php if($row['AccStatus']==0){ ?>
                <div class="mt-4">
                  <a class="btn btn-success btn-lg" data-slide="true" href="userSent.php?accept=<?php echo $accno?>?" role="button">
                      <i class="fas fa-plus-circle fa-lg mr-2"></i> 
                      ตอบรับการลงทะเบียน    
                  </a>
                  <?php }else{ ?>
                  <div class="mt-4">
                    <a class="btn btn-success disabled btn-lg" data-slide="true" href="#" role="button">
                    <i class="fas fa-plus-circle fa-lg mr-2"></i> 
                    ตอบรับการลงทะเบียน    
                  </a>
                  <?php } ?>
                </div>

                <div class="mt-4 product-share">
                  <a class="btn btn-danger" data-slide="true" href="userRoleEdit.php?bann=<?php echo $accno?>" role="button" onclick="return confirm('ยืนยันการแบนผู้ใช้');">
                    <i class="fas fa-times-circle"></i>
                      แบนผู้ใช้นี้    
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
         
      </div>
      <!-- /.card -->
      <!---EDIT AND DELETE PART---->
      <div class="row justify-content-center">
        <div class="col-md-4">
            <!-- general form elements -->
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">แก้ไขบทบาทผู้ใช้</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" action="userRoleEdit.php" method="POST">
                        <input type="hidden" name="accno" value="<?php echo $row['AccNo']?>">
                        <div class="card-body">
                                    <div class="form-group">
                                        <label for="role">บทบาทของผู้ใช้</label>
                                        <select class="form-control" name="role" id="role">
                                            <?php foreach($fetchRole as $result){ 
                                            echo "<option value=".$result['RoleID'].">".$result['RoleTName']." ".$result['RoleEName']."</option>";
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="form-group" align="center">
                                        <button type="submit" class="btn btn-warning" name="update" onclick="return confirm('ยืนยันการแก้ไข');">ยืนยันการแก้ไข</button>
                                    </div>
                                </div>
                            </form>
                            <!-- /.card-body -->
                        </div><!-- /.container-fluid -->
                    </div>
                    <!--- /.EDIT AND DELETE PART----> 
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