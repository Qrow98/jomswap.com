<?php session_start(); ?>
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
        <a class="navbar-brand" href="index.html">JOMSWAP - TUKAR BARANGAN ANDA!</a>
      </div>
      <div class="collapse navbar-collapse" id="navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
          <!-- Call Search -->
          <li><a href="javascript:void(0);" class="js-search" data-close="true" type="button" data-toggle="tooltip" data-placement="bottom" title="Cari barangan"><i class="material-icons waves-effect">search</i></a></li>
          <!-- #END# Call Search -->
          <li><a href="pages/additem.php" type="button" data-toggle="tooltip" data-placement="bottom" title="Tambah Barangan"><i class="material-icons">add</i></a></li>
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
        <div class="image">
          <img src="images/user.png" width="48" height="48" alt="User" />
        </div>
        <div class="info-container">
        <?php
        if (isset($_SESSION['email'])) {
            echo "
              <div class='name' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>". $_SESSION['ic'] ."</div>
              <div class='email'>". $_SESSION['email'] ."</div>
            ";
        } else {
            echo "
              <div class='name' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Tetamu</div>
              <div class='email'>Selamat datang!</div>
            ";
        }

        ?>
        </div>
      </div>
      <!-- #User Info -->
      <!-- Menu -->
      <div class="menu">
        <ul class="list">
          <li class="header">MENU UTAMA</li>
          <li class="active">
            <a href="index.html">
              <i class="material-icons">home</i>
              <span>Laman Utama</span>
            </a>
          </li>
            <?php
            if (isset($_SESSION['email'])) {
                echo "
                  <li>
                    <a href='pages/inventori.html'>
                      <i class='material-icons'>shopping_basket</i>
                      <span>Inventori</span>
                    </a>
                  </li>
                  <li>
                    <a href='pages/typography.html'>
                      <i class='material-icons'>swap_vert</i>
                      <span>Pertukaran</span>
                    </a>
                  </li>
                <li class='header'>MENU PENGGUNA</li>
                  <li>
                    <a href='javascript:void(0);'>
                      <i class='material-icons'>person</i>
                      <span>Profil</span>
                    </a>
                  </li>
                  <li>
                    <a href='javascript:void(0);'>
                      <i class='material-icons'>directions_run</i>
                      <span>Logout</span>
                    </a>
                  </li>
                ";
            } else {
                echo "
                <li class='header'>MENU PENGGUNA</li>                
                  <li>
                    <a href='javascript:void(0);'>
                      <i class='material-icons'>input</i>
                      <span>Log Masuk</span>
                    </a>
                  </li>
                  <li>
                    <a href='javascript:void(0);'>
                      <i class='material-icons'>person_add</i>
                      <span>Daftar</span>
                    </a>
                  </li>
                ";
            }
            ?>
        </ul>
      </div>
      <!-- #Menu -->
      <!-- Footer -->
      <div class="legal">
        <div class="copyright">
          &copy; 2017 - 2018 <a href="javascript:void(0);">Zulhilmi Sofi</a>
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
echo $_SESSION['ic'];
require_once 'php/connect.php';
$sql = "SELECT * FROM barangan";
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $dir = $row['gambarBarangan'];
            $dir = preg_replace('$^../$', '', $dir);
            echo "
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
                  " . $row['butiranBarangan'] . "
                  <br>
                  " . $row['tarikhMuatNaik'] . "
                  <br><br>
                  <a href='pages/item.php?idBarangan=" . $row['idBarangan'] . "'><button class='btn bg-cyan waves-effect'>LIHAT</button></a>
                </div>
              </div>
            </div>
            ";
        }
        mysqli_free_result($result);
    } else {
        echo "Tiada barangan.";
    }
}
mysqli_close($conn);

require 'php/hidebutton.php';
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
