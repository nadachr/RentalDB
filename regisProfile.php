
<?php

  session_start();

  include "connrent.php";

  $query = "SELECT PreID, PreDisTh, PreDisEn FROM prefix;";
  $mysql = mysqli_query($conn, $query);

  echo "<script>alert('กรอกข้อมูลส่วนตัว');</script>";

  if(isset($_GET['user'])){
    $user = $_GET['user'];
  }else{
    $_SESSION['fail'] = "Register failed";
    header('location:index.php');
  }

  $user_check = "SELECT * FROM Login WHERE LogUser = '$user' LIMIT 1;";
  $result = mysqli_query($conn, $user_check);
  $userid = mysqli_fetch_array($result, MYSQLI_ASSOC);
  
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PRMS | Register</title>
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
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- Google Font: Kanit -->
  <link href="https://fonts.googleapis.com/css?family=Kanit&display=swap" rel="stylesheet">
  <style>
    .avatar{
      width: 100px;
    }
  </style>
</head>

<body class="hold-transition register-page">
<img class="wave" src="wave.png">
  <img class="avatar" src="img/avatar.svg">
  <div class="register-logo">
    <h1><b>Registration</b></h1>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">สมัครสมาชิกเพื่อเข้าใช้งานระบบ</p>

      <form action="process_regisPro.php" method="post">
        <input type="hidden" name="logid" id="logid" value="<?php echo $userid['LogID']?>">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="" value="ผู้ใช้ <?php echo $user;?>" disabled>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <label for="setLogin">ข้อมูลส่วนตัว</label>
        <div class="form-group" data-select2-id="70">
          <select id="prefix" class = "prefix" name = "prefix">
            <?php 
              while($row=mysqli_fetch_array($mysql, MYSQLI_ASSOC)){
                      echo "<option value=".$row['PreID'].">".$row['PreDisTh']."/".$row['PreDisEn']."</option>";
                   }
            ?>
          </select>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="firstEname" placeholder="First name" require>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="lastEname" placeholder="Last name" require>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="firstTname" placeholder="ชื่อจริง" require>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="lastTname" placeholder="นามสกุล" require>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="input-group">
            <input type="text" class="form-control" name="accid" data-mask placeholder="รหัสประจำตัวประชาชน 13 หลัก" require>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-id-card"></span>
              </div>
            </div>
          </div>
        </div>
          <!-- Date dd/mm/yyyy -->
        <div class="form-group">
          <div class="input-group">
            <input type="date" class="form-control" name="bdate" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy/mm/dd" data-mask placeholder="ปี/เดือน/วันเกิด" require>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="far fa-calendar-alt"></span>
              </div>
            </div>
          </div>
            <!-- /.input group -->
        </div>
        <!-- /.form group -->
        
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email" require>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="input-group">
            <input type="tel" class="form-control" name="tel" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder="เบอร์โทรศัพท์ (xxx-xxx-xxxx)" require>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-phone"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="inst" placeholder="สังกัดหน่วยงาน" require>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-address-card"></span>
            </div>
          </div>
        </div>
        <label for="address">ที่อยู่ปัจจุบัน</label>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="addr" placeholder="บ้านเลขที่, หมู่ที่, ตรอก/ซอย" require>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-home"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="dist" placeholder="ตำบล" require>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-home"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="prov" placeholder="อำเภอ" require>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-home"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="city" placeholder="จังหวัด" require>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-home"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="num" class="form-control" name="postcode" placeholder="รหัสไปรษณีย์" require>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-home"></span>
            </div>
          </div>
        </div>
        <div class="row justify-content-center">
          <!-- /.col -->
          <div class="col-12" align="center">
          <input type="submit" class="btn btn-success" value="Register">
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- date-range-picker -->
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

  })
</script>
</body>
</html>
