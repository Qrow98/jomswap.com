<?php
session_start();

require_once '../php/connect.php';
if (isset($_SESSION['ic'])) {
    $ic = $_SESSION['ic'];

    $sql = "SELECT * FROM pelajar WHERE noIC = $ic";
    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $nama = $row['namaPelajar'];
                $jantina = $row['jantina'];
                $noTel = $row['noTel'];
                $alamat = $row['alamat'];
                $bandar = $row['bandar'];
                $poskod = $row['poskod'];
                $negeri = $row['negeri'];
                $tarikhDaftar = $row['tarikhDaftar'];
                $pic = $row['profilePicture'];
            }
            mysqli_free_result($result);
        } else {
            echo "Ralat dikesan. Sila cuba sebentar lagi.";
        }
    }

    $email = $_SESSION['user'];

    $sql = "SELECT * FROM logMasuk WHERE email = '$email'";
    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $email = $row['email'];
                $pwd = $row['password'];
            }
            mysqli_free_result($result);
        } else {
            echo "Ralat dikesan. Sila cuba sebentar lagi.";
        }
    }
}

// Define variables and initialize with empty values
// $nama = $noTel = $alamat = "";
$namaError = $noTelError = $alamatError = $bandarError = $poskodError = $negeriError = $password_err = "";
 
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate nama
    if (empty(trim($_POST["name"]))) {
        $namaError = "Sila masukkan Nama anda.";
    } else {
        $nama = trim($_POST["name"]);
    }

    // Validate no telefon
    if (empty(trim($_POST["noTel"]))) {
        $noTelError = "Sila masukkan No. Telefon anda.";
    } else {
        $noTel = trim($_POST["noTel"]);
    }

    // Validate alamat
    if (empty(trim($_POST["alamat"]))) {
        $alamatError = "Sila masukkan Alamat anda.";
    } else {
        $alamat = trim($_POST["alamat"]);
    }

    // Validate bandar
    if (empty(trim($_POST["bandar"]))) {
        $bandarError = "Sila masukkan Bandar anda.";
    } else {
        $bandar = trim($_POST["bandar"]);
    }

    // Validate poskod
    if (empty(trim($_POST["poskod"]))) {
        $poskodError = "Sila masukkan Poskod anda.";
    } else {
        $poskod = trim($_POST["poskod"]);
    }

    // Validate negeri
    if (empty(trim($_POST["negeri"]))) {
        $negeriError = "Sila masukkan Negeri anda.";
    } else {
        $negeri = trim($_POST["negeri"]);
    }

    // Validate password
    if (empty(trim($_POST['password']))) {
        $password_err = "Sila masukkan kata laluan anda.";
    } elseif (strlen(trim($_POST['password'])) < 6) {
        $password_err = "Kata laluan mesti mempunyai sekurang-kurangnya 6 huruf.";
    } else {
        $password = trim($_POST['password']);
    }
    
    // Profile picture
    include '../php/upload.php';

    // Check input errors before inserting in database
    if (empty($namaError) && $uploadOk == 1 && empty($noTelError) && empty($alamatError) && empty($password_err) && empty($bandarError) && empty($poskodError) && empty($negeriError)) {
        
        $sql = "UPDATE pelajar SET namaPelajar = '$nama', noTel = '$noTel', alamat = '$alamat', bandar = '$bandar', poskod = '$poskod', negeri = '$negeri', profilePicture = '$target_file' WHERE noIC = $ic";

        if (mysqli_query($conn, $sql)) {
            $sql = "UPDATE logMasuk SET password = '$password' WHERE email = '$email'";
            if (mysqli_query($conn, $sql)) {
                header("location: profile.php");
            } else {
                echo "Ralat dikesan. Sila cuba sebentar lagi.";
                echo "<br>";
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);   
            }         
        } else {
            echo "Ralat dikesan. Sila cuba sebentar lagi.";
            echo "<br>";
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);            
        }
    } elseif (empty($namaError) && empty($noTelError) && empty($alamatError) && empty($password_err) && empty($bandarError) && empty($poskodError) && empty($negeriError)) {
        
        $sql = "UPDATE pelajar SET namaPelajar = '$nama', noTel = '$noTel', alamat = '$alamat', bandar = '$bandar', poskod = '$poskod', negeri = '$negeri' WHERE noIC = $ic";
        
        if (mysqli_query($conn, $sql)) {
            $sql = "UPDATE logMasuk SET password = '$password' WHERE email = '$email'";
            if (mysqli_query($conn, $sql)) {
                header("location: profile.php");
            } else {
                echo "Ralat dikesan. Sila cuba sebentar lagi.";
                echo "<br>";
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);   
            }         
        } else {
            echo "Ralat dikesan. Sila cuba sebentar lagi.";
            echo "<br>";
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);            
        }
    }
    
    // Close connection
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <title><?php echo $nama; ?> | JomSwap</title>
  <!-- Favicon-->
  <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
  <link rel="icon" href="../favicon.ico" type="image/x-icon">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
  <!-- Bootstrap Core Css -->
  <link href="../plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
  <!-- Waves Effect Css -->
  <link href="../plugins/node-waves/waves.css" rel="stylesheet" />
  <!-- Animation Css -->
  <link href="../plugins/animate-css/animate.css" rel="stylesheet" />
  <!-- Bootstrap Select Css -->
  <link href="../plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
  <!-- Custom Css -->
  <link href="../css/style.css" rel="stylesheet">
  <link href="../css/themes/all-themes.css" rel="stylesheet" />
  <script src="../plugins/jquery/jquery.min.js"></script>
  <script src="../js/hiding.js"></script>
  <script src="../js/popup.js"></script>
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
        <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse"   aria-expanded="false"></a>
        <a href="javascript:void(0);" class="bars"></a>
        <a class="navbar-brand" href="../index.php">Jom<b>SWAP</b> - Tukar Barangan Anda!</a>
      </div>
      <div class="collapse navbar-collapse" id="navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
          <!-- Call Search -->
          <li><a href="javascript:void(0);" class="js-search" data-close="true" type="button" data-toggle="tooltip" data-placement="bottom"   title="Cari barangan"><i class="material-icons waves-effect">search</i></a></li>
          <!-- #END# Call Search -->
<?php
if (isset($_SESSION['email'])) {
  echo "
  <li><a href='../pages/additem.php' type='button' data-toggle='tooltip' data-placement='bottom' title='Tambah  Barangan' class='material-icons'>add</i></a></li>
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
<?php require "../php/userinfo.php"; ?>
      </div>
      <!-- #User Info -->
      <!-- Menu -->
      <div class="menu">
        <ul class="list">
          <li class="header">MENU UTAMA</li>
          <li class="active">
            <a href="../index.php">
              <i class="material-icons">home</i>
              <span>Laman Utama</span>
            </a>
          </li>
<?php require "../php/hidebutton.php"; ?>
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
      <!-- profile picture -->
      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="card">
          <div class="header bg-cyan">
            <h2><?php echo $nama; ?></h2>
          </div>
          <div class="body">
            <div class='image'>
              <img src='<?php echo $pic; ?>' class='img-responsive thumbnail' style='max-height:200px;'>
            </div>
          </div>
        </div>
      </div>
      <!-- butiran log masuk -->
      <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
        <div class="card">
          <div class="header">
            <h2>Butiran Log Masuk</h2>
            <ul class="header-dropdown m-r--5">
              <li class="dropdown">
                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">more_vert</i>
                </a>
                <ul class="dropdown-menu pull-right">
                  <li><a id="btnEdit">Edit</a></li>
                </ul>
              </li>
            </ul>
          </div>
          <div class="body">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div class="input-group upload hid">
              <label>Gambar:</label>
              <input type="file" name="fileToUpload" id="fileToUpload" class="form-control">
            </div>

            <label>Email:</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">email</i>
              </span>
              <div class="form-line">
                <input type="email" class="form-control" name="email" placeholder="Email Address" value="<?php echo $email; ?>" readonly>
              </div>
            </div>

            <label>Kata laluan:</label>
            <div class="input-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
              <span class="input-group-addon">
                <i class="material-icons">lock</i>
              </span>
              <div class="form-line">
                <input type="text" class="form-control" name="password" placeholder="Kata Laluan" value="<?php echo $pwd; ?>" readonly>
              </div>
              <span class="help-block"><?php echo $password_err; ?></span>
            </div>

          </div>
        </div>
      </div>
      <!-- butiran diri -->
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
          <div class="header">
            <h2>Butiran Diri</h2>
          </div>
          <div class="body">
          
              <div class="input-group <?php echo (!empty($namaError)) ? 'has-error' : ''; ?> hid">
              <label>Nama:</label>              
                <div class="form-line">
                  <input type="text" class="form-control" name="name" placeholder="Nama Penuh" value="<?php echo $nama; ?>" autofocus>
                </div>
                <span class="help-block"><?php echo $namaError; ?></span>
              </div>

              <label>No. IC:</label>
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="material-icons">info</i>
                </span>
                <div class="form-line">
                  <input type="" class="form-control" name="ic" placeholder="Nombor IC" value="<?php echo $ic; ?>" readonly>
                </div>
              </div>

              <label>Jantina:</label>
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="material-icons">wc</i>
                </span>
                <div class="form-line">
                  <input type="" class="form-control" name="jantina" placeholder="Jantina" value="<?php echo $jantina; ?>" readonly>
                </div>
              </div>

              <label>No. Telefon:</label>
              <div class="input-group <?php echo (!empty($noTelError)) ? 'has-error' : ''; ?>">
                <span class="input-group-addon">
                  <i class="material-icons">phone_iphone</i>
                </span>
                <div class="form-line">
                  <input type="text" class="form-control" name="noTel" placeholder="Nombor Telefon" value="<?php echo $noTel; ?>" readonly>
                </div>
                <span class="help-block"><?php echo $noTelError; ?></span>
              </div>

              <label>Alamat:</label>
              <div class="input-group <?php echo (!empty($alamatError)) ? 'has-error' : ''; ?>">              
                <span class="input-group-addon">
                  <i class="material-icons">home</i>
                </span>
                <div class="form-line">
                  <input type="text" class="form-control" name="alamat" placeholder="Alamat" value="<?php echo $alamat; ?>" readonly>
                </div>
                <span class="help-block"><?php echo $alamatError; ?></span>
              </div>

              <label>Bandar:</label>
              <div class="input-group <?php echo (!empty($bandarError)) ? 'has-error' : ''; ?>">
                <span class="input-group-addon">
                  <i class="material-icons">flight_takeoff</i>
                </span>
                <div class="form-line">
                  <input type="text" class="form-control" name="city" placeholder="Bandar" value="<?php echo $bandar; ?>" readonly>
                </div>
                <span class="help-block"><?php echo $bandarError; ?></span>
              </div>

              <label>Poskod:</label>
              <div class="input-group <?php echo (!empty($poskodError)) ? 'has-error' : ''; ?>">
                <span class="input-group-addon">
                  <i class="material-icons">code</i>
                </span>
                <div class="form-line">
                  <input type="text" class="form-control" name="postcode" placeholder="Poskod" value="<?php echo $poskod; ?>" readonly>
                </div>
                <span class="help-block"><?php echo $poskodError; ?></span>
              </div>

              <label>Negeri:</label>
              <div class="input-group <?php echo (!empty($negeriError)) ? 'has-error' : ''; ?>">
                <span class="input-group-addon">
                  <i class="material-icons">language</i>
                </span>
                <select name="state" class="form-control show-tick">
                  <option selected value="<?php if (isset($negeri)) echo $negeri;?>" style="display:none">
                    <?php
                    if (isset($negeri)) {
                        echo $negeri;
                    } else {
                        echo "Negeri";
                    }
                    ?>
                  </option>
                  <option>Wilayah Persekutuan Kuala Lumpur</option>
                  <option>Wilayah Persekutuan Labuan</option>
                  <option>Wilayah Persekutuan Putrajaya</option>
                  <option>Johor</option>
                  <option>Kedah</option>
                  <option>Kelantan</option>
                  <option>Malacca</option>
                  <option>Negeri Sembilan</option>
                  <option>Pahang</option>
                  <option>Perak</option>
                  <option>Perlis</option>
                  <option>Penang</option>
                  <option>Sabah</option>
                  <option>Sarawak</option>
                  <option>Selangor</option>
                  <option>Terengganu</option>
                </select>
                <span class="help-block"><?php echo $negeriError; ?></span>
              </div>

              <label>Tarikh Daftar:</label>
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="material-icons">date_range</i>
                </span>
                <div class="form-line">
                  <input type="" class="form-control" name="tarikh" placeholder="Tarikh Daftar" value="<?php echo $tarikhDaftar; ?>" readonly>
                </div>
                <span class="help-block"><?php echo $poskodError; ?></span>
              </div>     

              <div class="form-group hid">
                <input type="submit" class="btn btn-primary" value="Hantar">
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  </section>
  <!-- Jquery Core Js -->
  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap Core Js -->
  <script src="../plugins/bootstrap/js/bootstrap.js"></script>
  <!-- Select Plugin Js -->
  <script src="../plugins/bootstrap-select/js/bootstrap-select.js"></script>
  <!-- Slimscroll Plugin Js -->
  <script src="../plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
  <!-- Waves Effect Plugin Js -->
  <script src="../plugins/node-waves/waves.js"></script>
  <!-- Jquery CountTo Plugin Js -->
  <script src="../plugins/jquery-countto/jquery.countTo.js"></script>
  <!-- Custom Js -->
  <script src="../js/admin.js"></script>
  <script src="../js/pages/index.js"></script>
  <script src="../js/pages/examples/sign-up.js"></script>
  <!-- Demo Js -->
  <script src="../js/demo.js"></script>
</body>

</html>