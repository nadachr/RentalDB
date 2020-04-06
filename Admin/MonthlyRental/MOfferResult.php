<?php 
    session_start();

    if(isset($_GET['accno'])){
        $accno = $_GET['accno'];

        function fetchAcc($accno){
            include "connrent.php";
            
            $query = mysqli_query($conn, "SELECT * FROM vAccDoc WHERE AccNo = $accno;");
            $resultArray = array();

            while($result = mysqli_fetch_array($query, MYSQLI_ASSOC)){
                array_push($resultArray, $result);
            }
            mysqli_close($conn);
            return $resultArray;
        }

        function fetchOffer($accno){
            include "connrent.php";
            
            $query = mysqli_query($conn, "SELECT * FROM vOfferDetail WHERE AccNo = $accno;");
            $resultArray = array();

            while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
                array_push($resultArray, $row);
            }
            mysqli_close($conn);
            return $resultArray;
        }

        function fetchRent($offer){
          include "connrent.php";
          
          $query = mysqli_query($conn, "SELECT * FROM MonthlyRental WHERE MOfferID = $offer;");
          $resultArray = array();

          while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
              array_push($resultArray, $row);
          }
          mysqli_close($conn);
          return $resultArray;
      }
     

        $fetchOffer = fetchOffer($accno);
        foreach($fetchOffer as $row){
            $offerid = $row['MOfferID'];
            $price = $row['MOfferPrice'];
            $descrip = $row['MOfferPurpose'];
            $name = $row['AccName'];
            $place = $row['MPlaceTName'];
            $loc = $row['LocTName'];
            $Oresult = $row['MOfferResult'];
        }

        $fetchAcc = fetchAcc($accno);
        foreach($fetchAcc as $result){
            $fname = $result['AccFName'];
            $lname = $result['AccLName'];
            $prefix = $result['PreTH'];
            $phone = $result['AccPhone'];
            $addr  = $result['AccAddress'];
            $dist = $result['AccDistrict'];
            $prov = $result['AccProvince'];
            $city = $result['AccCity'];
            $postcode = $result['AccPostcode'];
        }

        $fetchRent = fetchRent($offerid);
          foreach($fetchRent as $row){
            $RentID = $row['MRentID'];
          }
        }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PRMS | Monthly Place Offer </title>
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
          <a href="index.php" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Contact</a>
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
                    <a href="profAdmin.php" class="nav-link">
                      <p>Profile</p>
                    </a>
                  </li>
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
                  <a href="DailyRental/DailyType.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>สถานที่เช่ารายวัน</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="http://localhost/rentaldb/admin/MonthlyRental/MonthlyType.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>สถานที่เช่ารายเดือน(ปี)</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="PlaceOF.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>การเช่าอุปกรณ์</p>
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
                  <a href="pages/forms/general.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>ข้อเสนอเช่า (รายวัน)</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/forms/advanced.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>ข้อเสนอประมูล (รายเดือน)</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/forms/editors.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>เอกสารอ้างอิง</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/forms/validation.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Validation</p>
                  </a>
                </li>
              </ul>
            </li>
            
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                <p>
                  การเช่าสถานที่
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="pages/tables/simple.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>การเช่ารายวัน</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/tables/data.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>การเช่ารายเดือน(ปี)</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/tables/jsgrid.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>อื่น ๆ</p>
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
                  <a href="pages/UI/general.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>บัญชีการเช่ารายวัน</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/UI/icons.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>บัญชีการเช่ารายเดือน(ปี)</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/UI/buttons.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>รายการชำระเงิน</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/UI/sliders.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>การชำระเงินใหม่</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/UI/modals.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Modals & Alerts</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/UI/navbar.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Navbar & Tabs</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/UI/timeline.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Timeline</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/UI/ribbons.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Ribbons</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="calendar.php" class="nav-link">
                <i class="nav-icon far fa-calendar-alt"></i>
                <p>
                  Calendar
                  <span class="badge badge-info right">2</span>
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pages/gallery.html" class="nav-link">
                <i class="nav-icon far fa-image"></i>
                <p>
                  Gallery
                </p>
              </a>
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
                  <a href="pages/charts/chartjs.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>ข้อมูลผู้ใช้</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/charts/flot.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>บทบาทผู้ใช้</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/charts/inline.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>ผู้ลงทะเบียนใหม่</p>
                  </a>
                </li>
              </ul>
            </li>
            
            
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-book"></i>
                <p>
                  Pages
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="pages/examples/invoice.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Invoice</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/examples/profile.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Profile</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/examples/e-commerce.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>E-commerce</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/examples/projects.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Projects</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/examples/project-add.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Project Add</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/examples/project-edit.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Project Edit</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/examples/project-detail.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Project Detail</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/examples/contacts.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Contacts</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon far fa-plus-square"></i>
                <p>
                  Extras
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="pages/examples/login.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Login</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/examples/register.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Register</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/examples/forgot-password.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Forgot Password</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/examples/recover-password.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Recover Password</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/examples/lockscreen.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Lockscreen</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/examples/legacy-user-menu.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Legacy User Menu</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/examples/language-menu.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Language Menu</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/examples/404.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Error 404</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/examples/500.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Error 500</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/examples/pace.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Pace</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/examples/blank.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Blank Page</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="starter.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Starter Page</p>
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
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">การประมูลเช่าสถานที่</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="http://localhost/rentaldb/admin/index.php">Home</a></li>
                <li class="breadcrumb-item active">ผลการเสนอราคา</li>
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
                            <div class="card card">
                                <div class="card-header">
                                    <h3 class="card-title"><a class="text-white btn btn-secondary">รหัสข้อเสนอ :&nbsp;000<?php echo $offerid?> / รหัสการเช่า :&nbsp;000<?php echo $RentID?></a></h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <div class="card-body">
                                    <div class="row justify-content-center">
                                        <h2>ผลการเสนอราคาค่าเช่าพื้นที่เพื่อประกอบธุรกิจ</h2>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php if($Oresult == 'accepted'){ ?>
                                            <div class="form-group" align="center">
                                                <h3 class="text-success">คุณได้รับคัดเลือกให้เช่าพื้นที่เพื่อประกอบธุรกิจ</h3>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="col-md-10">
                                                    <div class="form-group">
                                                        <h5>
                                                            &emsp;&emsp;&emsp;&emsp;ข้าพเจ้า <i><b><?php echo $name?></b></i>
                                                            อยู่บ้านเลขที่ <u><?php echo $addr; ?></u> ตำบล <u><?php echo $dist; ?></u> อำเภอ <u><?php echo $prov; ?></u>
                                                            จังหวัด <u><?php echo $city?></u> หมายเลขโทรศัพท์ <u><?php echo $phone?></u>
                                                            ได้ทำการเสนอประมูลเช่าสถานที่
                                                            <u><?php echo $place;?></label></u>
                                                            ซึ่งตั้งอยู่ที่
                                                            <u><?php echo $loc;?></label></u> เพื่อ <u><?php echo $descrip;?></label></u>
                                                            ในอัตราเช่าปีละ <u class="text-danger"><?php echo $price;?></label></u> บาท ไม่รวมค่าใช้จ่ายภายนอก (ค่าน้ำ ค่าไฟ และอื่นๆ)
                                                        </h5>
                                                        <h5>&emsp;&emsp;&emsp;&emsp;บัดนี้ได้รับอนุมัติจากศูนย์กลางมหาวิทยาลัยเทคโนโลยีราชมงคลศรีวิชัย สงขลา ให้เป็นผู้เช่าพื้นที่ล็อคดังกล่าว
                                                            หากข้าพเจ้าบิดพลิ้วไม่ยอมดำเนินการ หรือไม่ปฏิบัติตามประกาศมหาวิทยาลัยเทคโนโลยีราชมงคลศรีวิชัย สงขลา ด้วยประการใด ๆ ก็ดี
                                                            ข้าพเจ้ายินยอมให้ศูนย์กลางมหาวิทยาลัยเทคโนโลยีราชมงคลศรีวิชัย สงขลา บังคับตามที่กำหนดในประกาศมหาวิทยาลัยเทคโนโลยีราชมงคลศรีวิชัย สงขลา หรือชดใช้ค่าเสียหายอันเกิดจากการบิดพลิ้วไม่ยอมปฏิบัติงานนั้น ๆ
                                                            แก่ศูนย์กลางมหาวิทยาลัยเทคโนโลยีราชมงคลศรีวิชัย สงขลา เมื่อศูนย์กลางมหาวิทยาลัยเทคโนโลยีราชมงคลศรีวิชัย สงขลา เรียกร้องเท่าที่เสียหายไปทั้งสิ้น
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row justify-content-center">
                                                <div class="form-group">
                                                    <a class="btn btn-success btn-lg" data-slide="true" href="http://localhost/rentaldb/Admin/MonthlyRental/MonthlyPay.php?offer=<?php echo $offerid?>&rent=<?php echo $RentID?>&accno=<?php echo $accno?>" role="button">
                                                        <i class="nav-icon fas fa-cash-register"></i> ชำระเงิน
                                                    </a>
                                                </div>
                                            </div>
                                            <?php }else if($Oresult == 'rejected'){ ?>
                                            <div class="form-group" align="center">
                                                <h3 class="text-danger">ข้อเสนอของคุณไม่ได้รับคัดเลือก</h3>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="col-md-10">
                                                    <div class="form-group" align="center">
                                                        <h5>รอการเสนอราคาค่าเช่าพื้นที่เพื่อประกอบธุรกิจอีกครั้งในภายหลัง</h5>
                                                        <div class="col-12">
                                                            <img src="img/undraw_cancel_u1it.svg" width="500" height="500" alt="Product Image">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row justify-content-center">
                                                <div class="form-group">
                                                    <a class="btn btn-primary btn-lg" data-slide="true" href="http://localhost/rentaldb/admin/index.php" role="button">
                                                        <i class="nav-icon fas fa-home"></i> หน้าแรก
                                                    </a>
                                                </div>
                                            </div>
                                            <?php }else{ ?>
                                            <div class="form-group" align="center">
                                                <h3>ข้อเสนอของคุณยังอยู่ในขั้นตอนการพิจารณา</h3>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="col-md-10">
                                                    <div class="form-group" align="center">
                                                        <h5>ขออภัยในความล่าช้า โปรดกลับมาตรวจสอบอีกครั้งในภายหลัง</h5>
                                                        <div class="col-12">
                                                            <img src="img/undraw_contract_uy56.svg" width="500" height="500" alt="Product Image">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row justify-content-center">
                                                <div class="form-group">
                                                    <a class="btn btn-primary btn-lg" data-slide="true" href="http://localhost/rentaldb/admin/index.php" role="button">
                                                        <i class="nav-icon fas fa-home"></i> หน้าแรก
                                                    </a>
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
