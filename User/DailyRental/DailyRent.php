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

        $query = mysqli_query($conn, "SELECT * FROM vLogin WHERE AccName = '$user';");
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
        $query = mysqli_query($conn, "SELECT * FROM vAccount WHERE LogUser = '$id';");
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
       
        $query = mysqli_query($conn, "SELECT * FROM vDPlaceDetail WHERE DPlaceStatus = 1 AND DPlaceID = $DPlace");
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
        $query = mysqli_query($conn, "SELECT * FROM vDPlaceDetail WHERE DPlaceStatus = 1 AND LocTName = '$LocTName'");
        $resultArray = array();
  
        while($result = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            array_push($resultArray, $result);
        }
        mysqli_close($conn);
        return $resultArray;
    }

    function fetchDT(){
        include "connrent.php";
       
        $query = mysqli_query($conn, "SELECT DISTINCT DTID, DTTName FROM vDPlaceDetail WHERE DPlaceStatus = 1");
        $resultArray = array();
  
        while($result = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            array_push($resultArray, $result);
        }
        mysqli_close($conn);
        return $resultArray;
    }

    function fetchEq(){
        include "connrent.php";
       
        $query = mysqli_query($conn, "SELECT * FROM Equipment WHERE EqStatus = 1");
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
    
    $i = 0;

    require_once "editDType.php";

    $fetchName = fetchName();
    foreach($fetchName as $row){
        $AccNo = $row['AccNo'];
    }
    $fetchPlace = fetchPlace();
    #$fetchDP = fetchDP();
    $fetchAcc = fetchAcc();
    $fetchEq = fetchEq();
    $fetchDT = fetchDT();

    if(isset($_POST['upload'])){

        $target = "img/".basename($_FILES['img']['name']);

        $img = $_FILES['img']['name'];
        
        $sql = "UPDATE DailyPlace SET DPlaceImg = '$img' WHERE DPlaceID = $DPlace";
        mysqli_query($conn, $sql);

        if(move_uploaded_file($_FILES['img']['tmp_name'], $target)){
            $msg = "Image uploaded successfully";
        }else{
            $msg = "There was a problem uploading image";
        }

        header("location: DPlaceDetail.php?show=$DPlace");
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
            <div class="col-sm-8">
              <h1>การเช่าสถานที่ประเภทรายวัน : <small><?php foreach($fetchPlace as $result){ echo $result['DPlaceNo'].' '.$result['DPlaceTName']; }?></small></h1>
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
                                    <h3 class="card-title">#</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <?php if($DPlace > 0) {?> <!------กดเช่าจากหน้าข้อมูลสถานที่------->
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
                                                <label class="lead text-primary"><?php echo $result["AccPhone"];?></label>                                          <?php } ?>
                                            </div>
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
                                        </div>
                                    </div> 
                                    <hr>
                                    <label><a href="prof.php" class="text-danger">แก้ไขข้อมูลส่วนตัว</a><small> หากข้อมูลส่วนตัวไม่ถูกต้อง</small></label>
                                    <div class="row justify-content-center">
                                        <div class="form-group">
                                            <a class="btn btn-info btn-lg" data-slide="true" href="DailyRentSent.php?dprent=<?php echo $DPlace?>&accno=<?php echo $AccNo?>" role="button" onclick="return confirm('กรอกรายละเอียดการเช่าสถานที่ราชการ');">
                                              ต่อไป<i class="nav-icon far fa-arrow-alt-circle-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php }else{ ?>             <!------เข้าจากหน้าเว็บ------->    
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
                                                <label class="lead text-primary"><?php echo $result["AccPhone"];?></label>                                          <?php } ?>
                                            </div>
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
                                        </div>
                                    </div> 
                                    <hr>
                                    <label><a href="prof.php" class="text-danger">แก้ไขข้อมูลส่วนตัว</a><small> หากข้อมูลส่วนตัวไม่ถูกต้อง</small></label>
                                    <div class="row justify-content-center">
                                        <div class="form-group">
                                            <a class="btn btn-info btn-lg" data-slide="true" href="DailyType.php?p=1" role="button">
                                            <i class="nav-icon fas fa-warehouse"></i> ดูสถานที่ 
                                            </a>
                                        </div>
                                        <div class="form-group">
                                        &emsp;<a class="btn btn-success btn-lg" data-slide="true" href="DailyRentDetail.php" role="button" onclick="return confirm('กรอกรายละเอียดการขอเช่าสถานที่ราชการ');">
                                          ต่อไป <i class="nav-icon far fa-arrow-alt-circle-right"></i>
                                            </a>
                                        </div>
                                    </div>
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