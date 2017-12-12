<?php
session_start();

require_once '../php/connect.php';

if (isset($_GET['idBarangan']) && !empty(trim($_GET['idBarangan']))) {
    $idBarangan = $_GET['idBarangan'];
    $sql = "SELECT *
    FROM barangan LEFT JOIN pelajar ON barangan.noIC = pelajar.noIC WHERE idBarangan = $idBarangan";
    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $gambarBarangan = $row['gambarBarangan'];
                $namaBarangan = $row['namaBarangan'];
                $butiranBarangan = $row['butiranBarangan'];
                $kategoriBarangan = $row['kategoriBarangan'];
                $tarikhMuatNaik = $row['tarikhMuatNaik'];
                $noIC = $row['namaPelajar'];
            }
            mysqli_free_result($result);
        } else {
            echo "Ralat dikesan. Sila cuba sebentar lagi.";
            echo mysqli_error($conn);
        }
    }
}

$butiranError = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $idBarangan = $_POST['idBarangan'];

    // Validate butiran
    if (empty(trim($_POST["butiran"]))) {
        $butiranError = "Sila masukkan butiran barangan anda.";
    } else {
        $butiran = trim($_POST["butiran"]);
    }

    // Profile picture
    include '../php/upload.php';

    // Check input errors before inserting in database
    if ($uploadOk == 1 && empty($butiranError)) {

        $sql = "UPDATE barangan SET butiranBarangan = '$butiran', gambarBarangan = '$target_file' WHERE idBarangan = '$idBarangan'";

        if (mysqli_query($conn, $sql)) {
            echo "<script>",
            "alert('Barang anda telah dikemaskini.');",
            "window.location.href='item.php?idBarangan=$idBarangan';",
            "</script>";
        } else {
            echo "Ralat dikesan. Sila cuba sebentar lagi.";
            echo "<br>";
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } elseif (empty($butiranError)) {

        $sql = "UPDATE barangan SET butiranBarangan = '$butiran' WHERE idBarangan = '$idBarangan'";

        if (mysqli_query($conn, $sql)) {
            echo "<script>",
            "alert('Barang anda telah dikemaskini.');",
            "window.location.href='item.php?idBarangan=$idBarangan';",
            "</script>";
        } else {
            echo "Ralat dikesan. Sila cuba sebentar lagi.";
            echo "<br>";
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}
$ic = $_SESSION['ic'];
$sql = "SELECT * FROM `barangan` WHERE noIC = '$ic'";
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        $options = "";
        // $options1 = "<option>$ic</option>";
        while ($row = mysqli_fetch_array($result)) {
            $options = $options."<option value='$row[0]'>$row[1]</option>";
        }
        mysqli_free_result($result);        
    }
}

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
  <title><?php echo $namaBarangan; ?> | JomSwap</title>
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
  <!-- Custom Css -->
  <link href="../css/style.css" rel="stylesheet">
  <link href="../css/themes/all-themes.css" rel="stylesheet" />
  <script src="../plugins/jquery/jquery.min.js"></script>
  <script src="../js/hiding.js"></script>
  <script src="../js/buttons.js"></script>
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
            <a href="index.php">
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
      <div class="block-header">
        <h2>BARANGAN</h2>
      </div>
      <div class="row clearfix">
              <h2><?php echo $namaBarangan; ?></h2>
              <button class="btn btn-primary" id="btnEdit">Edit</button>
              <div id="btnDelete">
                <form action="../php/deleteitem.php" method='post'>
                  <input type="hidden" name="idBarangan" value="<?php echo $idBarangan; ?>">
                  <input type="submit" class="btn btn-primary del" value="Padam">
                </form>
              </div>
              <br>
              <img src="<?php echo $gambarBarangan; ?>" style='max-width:40%;height:auto;'>
              <br>
              <br>
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
              <input type="hidden" name="idBarangan" value="<?php echo $idBarangan; ?>">
                <div class="form-group upload hid">
                  <label>Gambar:</label>
                  <input type="file" name="fileToUpload" id="fileToUpload" class="form-control">
                </div>
                <br>
                <div class="form-group <?php echo (!empty($butiranError)) ? 'has-error' : ''; ?>">
                  <label>Butiran:</label>
                  <textarea name="butiran" class="form-control" cols="30" rows="5" readonly><?php echo $butiranBarangan; ?></textarea>
                  <span class="help-block"><?php echo $butiranError; ?></span>
                </div>
                <div class="form-group">
                  <label>Kategori:</label>
                  <input type="" name="kategori" class="form-control" value="<?php echo $kategoriBarangan; ?>" readonly>
                </div>
                <div class="form-group">
                  <label>Tarikh Muat Naik:</label>
                  <input type="" name="tarikh" class="form-control" value="<?php echo $tarikhMuatNaik; ?>" readonly>
                </div>
                <div class="form-group">
                  <label>Pemilik:</label>
                  <input type="" name="pemilik" class="form-control" value="<?php echo $noIC; ?>" readonly>
                </div>
                <div class="form-group hid">
                  <input type="submit" class="btn btn-primary" value="Hantar">
                </div>
              </form>
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" id="btnExchange">Tukar</button>
              <!-- Modal -->
              <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Pilih barangan untuk ditukar</h4>
                    </div>
                    <div class="modal-body">
                      <form action="../php/trade.php" method="post">
                      <input type="hidden" name="idBaranganOwner" value="<?php echo $idBarangan; ?>">
                      <select name="idBaranganRequester" required>
                        <?php echo $options;?>
                        <option disabled selected value style="display:none"> -- pilih barangan -- </option>
                      </select>
                      <p>Tiada barangan? <a href="additem.php">Tambah di sini!</a></p>
                    </div>
                    <div class="modal-footer">
                      <input type="submit" value="Tukar" class="btn btn-primary tukar">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
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
  <!-- Demo Js -->
  <script src="../js/demo.js"></script>
</body>
<?php
$sql = "SELECT noIC FROM barangan WHERE idBarangan = '$idBarangan'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $tempIC = $row['noIC'];
    }
    if ($_SESSION['ic'] == $tempIC) {
        echo "<script>","isOwner();","</script>";
    } else {
        echo "<script>","notOwner();","</script>";
    }
} else {
    echo "Ralat dikesan. Sila cuba sebentar lagi.";
    echo "<br>";
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
// Close connection
mysqli_close($conn);
?>
</html>