<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title_web;?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="shortcut icon" href="" />
  <link rel="stylesheet" href="<?php echo base_url('assets_style/assets/bower_components/bootstrap/dist/css/bootstrap.min.css');?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets_style/assets/bower_components/font-awesome/css/font-awesome.min.css');?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('assets_style/assets/bower_components/Ionicons/css/ionicons.min.css');?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets_style/assets/dist/css/AdminLTE.min.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets_style/assets/dist/css/responsivelogin.css');?>">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"><style type="text/css">
        .navbar-inverse{
        background-color:#333;
         }
         .navbar-color{
        color:#fff;
         }
          blink, .blink {
                animation: blinker 3s linear infinite;
            }

           @keyframes blinker {
                50% { opacity: 0; }
           }
    </style>
  </head>
<body class="hold-transition login-page" style="overflow-y: hidden;background:url(
	'<?php echo base_url('assets_style/image/background/bg-1.jpg');?>')no-repeat;background-size:100%;">
<div class="login-box">
	<br/>
    <!-- <div class="login-logo">
      <a href="index.php" style="color: yellow;">PERPUSTAKAAN <br/><b>FAKULTAS TEKNIK</b></a>
    </div> -->
  <div id="tampilalert"></div>
  <!-- /.login-logo -->
  <div class="login-box-body" style="border:2px solid #226bbf;">
    <div class="row">
      <div class="col-md-12 col-md-offset-4" style="margin-top: 20px; margin-bottom: 20px;">
        <img src="<?= base_url('assets_style/image/logo-untan.png') ?>" width="100px">
      </div>
      <p class="login-logo"><b>DAFTAR</b></p>
    </div>
    <p>* Daftar menggunakan akun Siakad</p>
    <!-- <p class="login-box-msg" style="font-size:16px;"></p> -->
    <?= $this->session->flashdata('message'); ?>
    <form action="<?= base_url('login/daftarsimpan') ?>" method="POST" enctype="multipart/form-data">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="NIM" id="nim" name="nim" required="required" autocomplete="off">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" id="pass" name="password" required="required" autocomplete="off">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <div class="row">
          <div class="col-md-2">
            <label style="margin-top:8px; margin-left: 10px;">+62</label>
          </div>
          <div class="col-md-10">
        <input type="text" class="form-control" placeholder="Nomor WA (8997xxxxxx)" id="wa" name="no" required="required" autocomplete="off">
          </div>
        </div>
        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <span>*Upload KTM pdf</span>
        <input type="file" class="form-control" accept="application/pdf" name="ktm">
      </div>
      <div class="row">
        <div class="col-xs-8">
         
          <a href="<?= base_url('login') ?>" id="loding" class="btn">Sudah punya akun ?</a>
          <div id="loadingcuy"></div>
        </div>
        <div class="col-xs-4">
          <button type="submit" id="loding" class="btn btn-primary btn-block btn-flat">Daftar</button>
          <div id="loadingcuy"></div>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
  <br/>
  <footer>
    <div class="login-box-body text-center bg-blue">
       <a style="color: yellow;"> Copyright &copy; Perpustakaan Fakultas Teknik Untan - <?php echo date("Y");?>
    </div>
  </footer>
</div>
<!-- /.login-box -->
<!-- Response Ajax -->
<div id="tampilkan"></div>
<!-- jQuery 3 -->
<script src="<?php echo base_url('assets_style/assets/bower_components/jquery/dist/jquery.min.js');?>"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('assets_style/assets/bower_components/bootstrap/dist/js/bootstrap.min.js');?>"></script>
<!-- iCheck -->
<script src="<?php echo base_url('assets_style/assets/plugins/iCheck/icheck.min.js');?>"></script>
</body>
</html>
