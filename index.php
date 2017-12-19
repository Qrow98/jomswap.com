<?php
session_start();
require_once 'php/connect.php';

$ic = $_SESSION['ic'];

$sql = "SELECT * FROM pelajar WHERE noIC = $ic";
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $nama = $row['namaPelajar'];
            $jantina = $row['jantina'];
            $noTel = $row['noTel'];
            $alamat = $row['alamat'];
            $tarikhDaftar = $row['tarikhDaftar'];
            $pic = $row['profilePicture'];
        }
        mysqli_free_result($result);
    } else {
        echo "Ralat dikesan. Sila cuba sebentar lagi.";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <title>Tukar Barangan Anda! | JomSwap</title>
  <!-- Favicon-->
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
  <!-- Bootstrap Core Css -->
  <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
  <!-- Waves Effect Css -->
  <link href="plugins/node-waves/waves.css" rel="stylesheet" />
  <!-- Animation Css -->
  <link href="plugins/animate-css/animate.css" rel="stylesheet" />
  <!-- Custom Css -->
  <link href="css/style.css" rel="stylesheet">
  <link href="css/themes/all-themes.css" rel="stylesheet" />
</head>

<body class="theme-cyan">
  <!-- Page Loader -->
  <div class="page-loader-wrapper">
    <div class="loader">
      <div class="preloader">
        <div class="spinner-layer pl-cyan">
          <div class="circle-clipper left">
            <div class="circle"></div>
          </div>
          <div class="circle-clipper right">
            <div class="circle"></div>
          </div>
        </div>
      </div>
      <p>Tunggu sebentar...</p>
    </div>
  </div>
  <!-- #END# Page Loader -->
  <!-- Overlay For Sidebars -->
  <div class="overlay"></div>
  <!-- #END# Overlay For Sidebars -->
  <!-- Search Bar -->
  <div class="search-bar">
    <div class="search-icon">
      <i class="material-icons">search</i>
    </div>
    <input type="text" placeholder="CARI BARANGAN...">
    <div class="close-search">
      <i class="material-icons">close</i>
    </div>
  </div>
  <!-- #END# Search Bar -->
  <!-- Top Bar -->
  <nav class="navbar">
    <div class="container-fluid">
      <div class="navbar-header">
        <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
        <a href="javascript:void(0);" class="bars"></a>
        <a class="navbar-brand" href="index.php">Jom<b>SWAP</b> - Tukar Barangan Anda!</a>
      </div>
      <div class="collapse navbar-collapse" id="navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
          <!-- Call Search -->
          <li><a href="javascript:void(0);" class="js-search" data-close="true" type="button" data-toggle="tooltip" data-placement="bottom" title="Cari barangan"><i class="material-icons waves-effect">search</i></a></li>
          <!-- #END# Call Search -->
<?php
if (isset($_SESSION['email'])) {
    echo "
    <li><a href='pages/additem.php' type='button' data-toggle='tooltip' data-placement='bottom' title='Tambah Barangan' class='material-icons'>add</i></a></li>
    ";
}
?>
        </ul>
      </div>
    </div>
  </nav>
  <!-- #Top Bar -->
  <section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
      <!-- User Info -->
      <div class="user-info">
<?php require "php/userinfoindex.php"; ?>
      </div>
      <!-- #User Info -->
      <!-- Menu -->
      <div class="menu">
        <ul class="list">
          <li class="header">MENU UTAMA</li>
          <li class="active">
            <a href="index.php">
              <i class="material-icons">home</i>
              <span>Laman Utama</span>
            </a>
          </li>
<?php require "php/hidebuttonindex.php"; ?>
        </ul>
      </div>
      <!-- #Menu -->
      <!-- Footer -->
      <div class="legal">
        <div class="copyright">
          &copy; 2017 - 2018 &nbsp;<a href="https://www.twitter.com/zulhilmy98">Zulhilmi Sofi</a>
        </div>
        <div class="version">
          <b>Version: </b> 0.5.9
        </div>
      </div>
      <!-- #Footer -->
    </aside>
    <!-- #END# Left Sidebar -->
  </section>
  <!-- main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="block-header">
        <h2>BARANGAN</h2>
      </div>
      <div class="row clearfix">
<?php
$sql = "SELECT * FROM barangan 
LEFT JOIN pelajar ON barangan.noIC = pelajar.noIC";

if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $dir = $row['gambarBarangan'];
            $dir = preg_replace('$^../$', '', $dir);
            echo "
            <a href='pages/item.php?idBarangan=" . $row['idBarangan'] . "'>
            <div class='col-lg-4 col-md-4 col-sm-6 col-xs-12'>
              <div class='card'>
                <div class='header bg-cyan'>
                  <h2>
                    " . $row['namaBarangan'] . "
                    <small>" . $row['kategoriBarangan'] . "</small>
                  </h2>
                </div>
                <div class='body'>
                  <div class='image'>
                    <img src='" . $dir . "' class='img-responsive thumbnail' style='max-height:200px;'>
                  </div>
                  <p>Butiran: <b>" . $row['butiranBarangan'] . "</b></p>
                  <p>Tarikh Muat Naik: <b>" . $row['tarikhMuatNaik'] . "</b></p>
                  <p>Pemilik: <b>" . $row['namaPelajar'] . "</b></p>
                </div>
              </div>
            </div>
            </a>
            ";
        }
        mysqli_free_result($result);
    } else {
        echo "Tiada barangan.";
    }
}
mysqli_close($conn);
?>
      </div>
    </div>
  </section>
  <!-- Jquery Core Js -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap Core Js -->
  <script src="plugins/bootstrap/js/bootstrap.js"></script>
  <!-- Select Plugin Js -->
  <script src="plugins/bootstrap-select/js/bootstrap-select.js"></script>
  <!-- Slimscroll Plugin Js -->
  <script src="plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
  <!-- Waves Effect Plugin Js -->
  <script src="plugins/node-waves/waves.js"></script>
  <!-- Jquery CountTo Plugin Js -->
  <script src="plugins/jquery-countto/jquery.countTo.js"></script>
  <!-- Custom Js -->
  <script src="js/admin.js"></script>
  <script src="js/pages/index.js"></script>
  <!-- Demo Js -->
  <script src="js/demo.js"></script>
</body>

</html>
