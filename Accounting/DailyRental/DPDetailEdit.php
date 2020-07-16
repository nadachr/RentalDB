<?php 
  session_start();

  if (!isset($_SESSION['id'])) {
      $_SESSION['msg'] = "You must log in first";
      header('location: http://localhost/rentaldb/index.php');
  }
?>
<?php 
    function fetchDP(){
        include "connrent.php";

        $DPlace = $_GET['pedit'];

        $query = mysqli_query($conn, "CALL showDetailDPlace($DPlace)");
        $resultArray = array();

        while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            array_push($resultArray, $row);
        }
        mysqli_close($conn);
        return $resultArray;
    }

    function fetchLoc(){
        include "connrent.php";
  
        $query = mysqli_query($conn, "SELECT * FROM location;");
        $resultArray = array();
  
        while($result = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            array_push($resultArray, $result);
        }
        mysqli_close($conn);
        return $resultArray;
      }
  
    function fetchType(){
        include "connrent.php";
  
        $query = mysqli_query($conn, "SELECT DTID, DTTName FROM dailytype;");
        $resultArray = array();
  
        while($result = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            array_push($resultArray, $result);
        }
        mysqli_close($conn);
        return $resultArray;
    }

    $DPlace = $_GET['pedit'];
    $i = 0;

    require_once "editDType.php";

    $fetchDP = fetchDP();
    $fetchLoc = fetchLoc();
    $fetchType = fetchType();

    foreach ($fetchDP as $row) {
    }

    if(isset($_POST['upload'])){

        $target = "img/".basename($_FILES['img']['name']);

        $img = $_FILES['img']['name'];
        
        $sql = "UPDATE dailyplace SET DPlaceImg = '$img' WHERE DPlaceID = $DPlace";
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
          <a href="http://localhost/rentaldb/accounting/index.php" class="nav-link">Home</a>
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
        <span class="brand-text font-weight-bold">BOARDS</span>
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
                  <a href="http://localhost/rentaldb/accounting/DailyRental/DailyType.php?p=1" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>สถานที่เช่ารายวัน</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="http://localhost/rentaldb/accounting/MonthlyRental/MonthlyType.php?p=1" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>สถานที่เช่ารายเดือน(ปี)</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="http://localhost/rentaldb/accounting/equipment/Equipment.php" class="nav-link">
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
                  <a href="http://localhost/rentaldb/accounting/DailyRental/DailyRent.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>แบบฟอร์มขอเช่ารายวัน</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="http://localhost/rentaldb/accounting/MonthlyRental/MonthlyOffer.php" class="nav-link">
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
                  <a href="http://localhost/rentaldb/accounting/DailyRental/DRentMN.php?p=1" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>ข้อเสนอเช่า 
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="http://localhost/rentaldb/accounting/MonthlyRental/MOfferRent.php?p=1" class="nav-link">
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
                  <a href="http://localhost/rentaldb/accounting/PayOfferRent.php?p=1" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>รายการชำระเงิน
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="http://localhost/rentaldb/accounting/Payment.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>แจ้งชำระเงิน</p>
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
              <h1>รายละเอียดสถานที่ : ประเภท<?php echo $row['DTTName'];?></h1>
            </div>
            <div class="col-sm-4">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="DailyPlace.php?show=<?php echo $row['DTID']?>">Back</a></li>
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
              <h3 class="d-inline-block d-sm-none"></h3>
              <div class="col-12">
                <img src="http://localhost/rentaldb/personel/monthlyrental/img/<?php echo $row['DPlaceImg'];?>" class="product-image" alt="Product Image">
              </div>
              <div class="col-12 product-image-thumbs">
                <div class="product-image-thumb active"><img src="http://localhost/rentaldb/personel/monthlyrental/img/<?php echo $row['DPlaceImg'];?>" alt="Product Image"></div>
              </div>
              <form active="" method="post" enctype="multipart/form-data"> 
                <div class="col-12 product-image-thumbs">
                  <input type="file" value="<?php echo $row['DPlaceImg'];?>" name="img" class="form-control-file border"> 
                  <input type="submit" class=" btn bg-primary btn-flat" name="upload" value="Upload" onclick="return confirm('ยืนยันการแก้ไขรูปภาพ');"> 
                </div>
              </form>
            </div>
            <div class="col-12 col-sm-6">
              <h2 class="my-3"><?php echo $row["DPlaceNo"].' '.$row["DPlaceTName"] ?></h2>
              <h3><?php echo $row["DPlaceNo"].' '.$row["DPlaceEName"] ?></h3>
              <hr>
              <h4><i class="fas fa-map-marker-alt"></i> ที่ตั้งสถานที่ <small>Location</small>
                <label class="btn btn-default text-center">
                    <span class="text-xm"><?php echo $row["LocID"].' '.$row["LocTName"] ?></span>
                </label></h4>
              <hr>
              <h4 class="mt-3"><i class="fas fa-chair"></i> จำนวนที่นั่ง <small>Seat</small>
                <label class="btn btn-default text-center">
                  <span class="text-xm"><?php echo $row["DTSeat"]; ?></span>
                  ที่นั่ง
                </label>
                </h4>
              <hr>                  
              <div class="bg-lightblue py-2 px-3 mt-4">
                <h4 class="mt-0">
                  <small>ค่าเช่าหน่วยงานราชการ</small>
                </h4>
                <h2 class="mb-0">
                  <?php echo $row["DTAgency"] ?> บาท/วัน
                </h2>
              </div>
              <div class="bg-lightblue py-2 px-3 mt-4">
                <h4 class="mt-0">
                  <small>ค่าเช่าหน่วยงานเอกชน</small>
                </h4>
                <h2 class="mb-0">
                  <?php echo $row["DTPrivate"] ?> บาท/วัน
                </h2>
              </div>

              <div class="mt-4">
                <a class="btn btn-success dprent=<?php echo $row['DPlaceID']?> btn-lg" data-slide="true" href="DailyRent.php?dprent=<?php echo $row['DPlaceID']?>" role="button">
                    <i class="fas fa-plus-circle fa-lg mr-2"></i> 
                    เช่าสถานที่นี้    
                </a>
                <a class="btn btn-info btn-lg" data-slide="true" href="http://localhost/rentaldb/accounting/DailyRental/DRentMN.php?p=1&dprent=<?php echo $row["DPlaceTName"]?>" role="button">
                    <i class="fas fa-history fa-lg mr-2"></i> 
                    ประวัติสถานที่    
                </a>
              </div>

              <div class="mt-4 product-share">
                <a class="btn btn-danger" data-slide="true" href="DPlaceDetail.php?show=<?php echo $DPlace?>" role="button">
                    <i class="nav-icon fas fa-edit"></i> 
                    ยกเลิก    
                </a>
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
        <a  name="move" >
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <!---EDIT AND DELETE PART---->
                    <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">แก้ไขข้อมูล</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="editDPlace.php" method="POST">
                                <input type="hidden" name="page" value="<?php echo $DPlace?>">
                                <input type="hidden" name="placeID" value="<?php echo $row['DPlaceID']?>">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="placeType">ประเภทสถานที่</label>
                                        <select class="form-control" name="placeType" id="placeType">
                                            <?php foreach($fetchType as $result){ 
                                            echo "<option value=".$result['DTID'].">".$result['DTID']." ".$result['DTTName']."</option>";
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="placeNo">หมายเลขสถานที่</label>
                                        <input type="input" class="form-control" value="<?php echo $row["DPlaceNo"];?>" name="placeNo" placeholder="หมายเลขสถานที่">
                                    </div>
                                    <div class="form-group">
                                        <label for="placeT">ชื่อสถานที่</label>
                                        <input type="input" class="form-control" value="<?php echo $row["DPlaceTName"];?>" name="placeT" placeholder="ชื่อสถานที่">
                                    </div>
                                    <div class="form-group">
                                        <label for="placeE">Place Name</label>
                                        <input type="input" class="form-control" value="<?php echo $row["DPlaceEName"];?>" name="placeE" placeholder="Place Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="seat">ที่ตั้งสถานที่</label>
                                        <select class="form-control" name="location" id="location">
                                            <?php foreach($fetchLoc as $result){ 
                                            echo "<option value=".$result['LocID'].">".$result['LocID'].' '.$result['LocTName']."</option>";
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-warning" name="update" onclick="return confirm('ยืนยันการแก้ไข');">ยืนยันการแก้ไข</button>
                                    </div>
                                </div>
                            </form>
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