<?php
session_start();

require_once "../php/connect.php";

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
  <title>Pertukaran | JomSwap</title>
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
      <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="card">
            <div class="header bg-cyan">
              <h2>
                Permintaan Terkini
                <small>Permintaan untuk menukar dengan barangan anda.</small>
              </h2>
            </div>
            <div class="body table-responsive">
<?php
$num = 1;
$sql = "SELECT *
FROM pertukaran t
JOIN barangan t1 ON t1.idBarangan = t.idBaranganOwner 
JOIN barangan t2 ON t2.idBarangan = t.idBaranganRequester LEFT JOIN pelajar t3 ON t3.noIC = t2.noIC
WHERE t1.noIC = '$ic' AND statusPertukaran = 'menunggu'";
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        echo "
        <table class='table table-hover'>
          <thead>
            <tr>
              <th>#</th>
              <th>BARANGAN ANDA</th>
              <th>BARANGAN YANG DITAWARKAN</th>
              <th>TARIKH</th>
              <th>PEMILIK</th>
              <th>STATUS</th>
              <th>TINDAKAN</th>
            </tr>
          </thead>
          <tbody>
        ";
        while ($row = mysqli_fetch_array($result)) {
            // $row[7] = 'is namaBarangan';
            echo "
            <tr class='clickable-rows'>
              <th scope='row'>" . $num . "</th>
              <td>
                <div class='image'>
                  <img src='" . $row[11] . "' class='img-responsive thumbnail' style='max-height:200px;'>
                </div>
                Nama: <b>" . $row[7] . "</b>                
              </td>
              <td>
                <div class='image'>
                  <img src='" . $row['gambarBarangan'] . "' class='img-responsive thumbnail' style='max-height:200px;'>
                </div>
                Nama: <b>" . $row['namaBarangan'] . "</b>                
              </td>
              <td>" . $row['tarikhPertukaran'] . "</td>
              <td>" . $row[25] . "</td>
              <td>" . $row['statusPertukaran'] . "</td>              
              <td>
                <a href='item.php?idBarangan=" . $row[15] . "'>
                  <button class='btn btn-primary'>LIHAT</button>
                </a>
                <br>
                <br>
                <a href='../php/acceptitem.php?idPertukaran=" . $row['idPertukaran'] . "'>
                  <button class='btn btn-primary'>TERIMA</button>
                </a>
                <br>                
                <br>                
                <a href='../php/declineitem.php?idPertukaran=" . $row['idPertukaran'] . "&idBaranganOwner=" . $row['idBaranganOwner'] . "&idBaranganRequester=" . $row['idBaranganRequester'] . "'>
                  <button class='btn btn-primary'>TOLAK</button>
                </a>
              </td>
            </tr>
            ";
            $num++;
        }
        echo "
          </tbody>
        </table>
        ";
        mysqli_free_result($result);
    } else {
        echo "Tiada pertukaran.";
    }
}
?>
            </div>
          </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="card">
            <div class="header bg-cyan">
              <h2>
                Pertukaran Anda
                <small>Permintaan yang dilakukan oleh anda.</small>
              </h2>
            </div>
            <div class="body table-responsive">
<?php
$num = 1;
$sql = "SELECT *
FROM pertukaran t
JOIN barangan t1 ON t1.idBarangan = t.idBaranganOwner LEFT JOIN pelajar t3 ON t3.noIC = t1.noIC
JOIN barangan t2 ON t2.idBarangan = t.idBaranganRequester
WHERE t2.noIC = '$ic' AND statusPertukaran = 'menunggu'";
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        echo "
        <table class='table table-hover'>
          <thead>
            <tr>
              <th>#</th>
              <th>BARANGAN ANDA</th>
              <th>BARANGAN DIMINTA</th>
              <th>PEMILIK</th>
              <th>TARIKH</th>
              <th>STATUS</th>
              <th>TINDAKAN</th>
            </tr>
          </thead>
          <tbody>
        ";
        while ($row = mysqli_fetch_array($result)) {
            // $row[7] = 'is namaBarangan';
            echo "
            <tr class='clickable-rows'>
              <th scope='row'>" . $num . "</th>
              <td>
                <div class='image'>
                  <img src='" . $row['gambarBarangan'] . "' class='img-responsive thumbnail' style='max-height:200px;'>
                </div>
                Nama: <b>" . $row['namaBarangan'] . "</b>
              </td>
              <td>
                <div class='image'>
                  <img src='" . $row[11] . "' class='img-responsive thumbnail' style='max-height:200px;'>
                </div>
                Nama: <b>" . $row[7] . "</b>                
              </td>
              <td>" . $row[16] . "</td>              
              <td>" . $row['tarikhPertukaran'] . "</td>
              <td>" . $row['statusPertukaran'] . "</td>              
              <td>
                <a href='item.php?idBarangan=" . $row[6] . "'>
                  <button class='btn btn-primary'>LIHAT</button>
                </a>";
            if ($row['statusPertukaran'] == 'Diterima') {
                echo "
                <br><br>
                <a href='receiptOwner.php?idPertukaran=" . $row['idPertukaran'] . "'>
                  <button class='btn btn-primary'>CETAK RESIT</button>
                </a>
                ";
            }
              echo "  
              </td>
            </tr>
            ";
            $num++;
        }
        echo "
          </tbody>
        </table>
        ";
        mysqli_free_result($result);
    } else {
        echo "Tiada pertukaran.";
    }
}
?>
            </div>
          </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="card">
            <div class="header bg-cyan">
              <h2>
                Permintaan Berjaya (Might be broken)
                <small>Permintaan yang berjaya.</small>
              </h2>
            </div>
            <div class="body table-responsive">
<?php
// Owner
$num = 1;
$sql = "SELECT *
FROM pertukaran t
JOIN barangan t1 ON t1.idBarangan = t.idBaranganOwner 
JOIN barangan t2 ON t2.idBarangan = t.idBaranganRequester LEFT JOIN pelajar t3 ON t3.noIC = t2.noIC
WHERE t1.noIC = '$ic' AND statusPertukaran = 'Diterima'";
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        echo "
        <table class='table table-hover'>
          <thead>
            <tr>
              <th>#</th>
              <th>BARANGAN ANDA</th>
              <th>BARANGAN YANG DITUKAR</th>
              <th>PEMILIK</th>
              <th>TARIKH</th>
              <th>STATUS</th>
              <th>TINDAKAN</th>
            </tr>
          </thead>
          <tbody>
        ";
        while ($row = mysqli_fetch_array($result)) {
            // $row[7] = 'is namaBarangan';
            echo "
            <tr class='clickable-rows'>
              <th scope='row'>" . $num . "</th>
              <td>
                <div class='image'>
                  <img src='" . $row[12] . "' class='img-responsive thumbnail' style='max-height:200px;'>
                </div>
                Nama: <b>" . $row[7] . "</b>                
              </td>
              <td>
                <div class='image'>
                  <img src='" . $row['gambarBarangan'] . "' class='img-responsive thumbnail' style='max-height:200px;'>
                </div>
                Nama: <b>" . $row['namaBarangan'] . "</b>                
              </td>
              <td>" . $row['namaPelajar'] . "</td>
              <td>" . $row['tarikhPertukaran'] . "</td>
              <td>" . $row['statusPertukaran'] . "</td>              
              <td>
                <a href='item.php?idBarangan=" . $row['idBaranganRequester'] . "'>
                  <button class='btn btn-primary'>LIHAT</button>
                </a>
                <br><br>
                <a href='receiptOwner.php?idPertukaran=" . $row['idPertukaran'] . "'>
                  <button class='btn btn-primary'>CETAK RESIT</button>
                </a>
              </td>
            </tr>
            ";
            $num++;
        }
        echo "
          </tbody>
        </table>
        ";
        mysqli_free_result($result);
    } else {
        // requester
        $num = 1;
        $sql = "SELECT *
        FROM pertukaran t
        JOIN barangan t1 ON t1.idBarangan = t.idBaranganOwner LEFT JOIN pelajar t3 ON t3.noIC = t1.noIC
        JOIN barangan t2 ON t2.idBarangan = t.idBaranganRequester 
        WHERE t2.noIC = '$ic' AND statusPertukaran = 'Diterima'";
        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                echo "
                <table class='table table-hover'>
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>BARANGAN ANDA</th>
                      <th>BARANGAN YANG DITUKAR</th>
                      <th>PEMILIK</th>
                      <th>TARIKH</th>
                      <th>STATUS</th>
                      <th>TINDAKAN</th>
                    </tr>
                  </thead>
                  <tbody>
                ";
                while ($row = mysqli_fetch_array($result)) {
                    // $row[7] = 'is namaBarangan';
                    echo "
                    <tr class='clickable-rows'>
                      <th scope='row'>" . $num . "</th>
                      <td>
                        <div class='image'>
                          <img src='" . $row['gambarBarangan'] . "' class='img-responsive thumbnail'        style='max-height:200px;'>
                        </div>
                        Nama: <b>" . $row['namaBarangan'] . "</b>                
                      </td>
                      <td>
                        <div class='image'>
                          <img src='" . $row[12] . "' class='img-responsive thumbnail' style='max-height:200px;'>
                        </div>
                        Nama: <b>" . $row[7] . "</b>                
                      </td>
                      <td>" . $row['namaPelajar'] . "</td>
                      <td>" . $row['tarikhPertukaran'] . "</td>
                      <td>" . $row['statusPertukaran'] . "</td>              
                      <td>
                        <a href='item.php?idBarangan=" . $row['idBaranganOwner'] . "'>
                          <button class='btn btn-primary'>LIHAT</button>
                        </a>
                        <br><br>
                        <a href='receiptRequester.php?idPertukaran=" . $row['idPertukaran'] . "'>
                          <button class='btn btn-primary'>CETAK RESIT</button>
                        </a>
                      </td>
                    </tr>
                    ";
                    $num++;
                }
                echo "
                  </tbody>
                </table>
                ";
                mysqli_free_result($result);
            } else {
                echo "Tiada pertukaran.";
            }
        }
    }
}
?>
            </div>
          </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="card">
            <div class="header bg-cyan">
              <h2>
                Permintaan Gagal (Might be broken)
                <small>Permintaan yang gagal.</small>
              </h2>
            </div>
            <div class="body table-responsive">
<?php
$num = 1;
$sql = "SELECT *
FROM pertukaran t
JOIN barangan t1 ON t1.idBarangan = t.idBaranganOwner 
JOIN barangan t2 ON t2.idBarangan = t.idBaranganRequester LEFT JOIN pelajar t3 ON t3.noIC = t2.noIC
WHERE t1.noIC = '$ic' AND statusPertukaran = 'Ditolak'";
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        echo "
        <table class='table table-hover'>
          <thead>
            <tr>
              <th>#</th>
              <th>BARANGAN ANDA</th>
              <th>BARANGAN YANG DITUKAR</th>
              <th>PEMILIK</th>
              <th>TARIKH</th>
              <th>STATUS</th>
              <th>TINDAKAN</th>
            </tr>
          </thead>
          <tbody>
        ";
        while ($row = mysqli_fetch_array($result)) {
            // $row[7] = 'is namaBarangan';
            echo "
            <tr class='clickable-rows'>
              <th scope='row'>" . $num . "</th>
              <td>
                <div class='image'>
                  <img src='" . $row[12] . "' class='img-responsive thumbnail' style='max-height:200px;'>
                </div>
                Nama: <b>" . $row[7] . "</b>                
              </td>
              <td>
                <div class='image'>
                  <img src='" . $row['gambarBarangan'] . "' class='img-responsive thumbnail' style='max-height:200px;'>
                </div>
                Nama: <b>" . $row['namaBarangan'] . "</b>                
              </td>
              <td>" . $row['namaPelajar'] . "</td>
              <td>" . $row['tarikhPertukaran'] . "</td>
              <td>" . $row['statusPertukaran'] . "</td>              
              <td>
                <a href='item.php?idBarangan=" . $row['idBaranganRequester'] . "'>
                  <button class='btn btn-primary'>LIHAT</button>
                </a>
              </td>
            </tr>
            ";
            $num++;
        }
        echo "
          </tbody>
        </table>
        ";
        mysqli_free_result($result);
    } else {
        // requester
        $num = 1;
        $sql = "SELECT *
        FROM pertukaran t
        JOIN barangan t1 ON t1.idBarangan = t.idBaranganOwner LEFT JOIN pelajar t3 ON t3.noIC = t1.noIC
        JOIN barangan t2 ON t2.idBarangan = t.idBaranganRequester 
        WHERE t2.noIC = '$ic' AND statusPertukaran = 'Ditolak'";
        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                echo "
                <table class='table table-hover'>
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>BARANGAN ANDA</th>
                      <th>BARANGAN YANG DITUKAR</th>
                      <th>PEMILIK</th>
                      <th>TARIKH</th>
                      <th>STATUS</th>
                      <th>TINDAKAN</th>
                    </tr>
                  </thead>
                  <tbody>
                ";
                while ($row = mysqli_fetch_array($result)) {
                    // $row[7] = 'is namaBarangan';
                    echo "
                    <tr class='clickable-rows'>
                      <th scope='row'>" . $num . "</th>
                      <td>
                        <div class='image'>
                          <img src='" . $row['gambarBarangan'] . "' class='img-responsive thumbnail'        style='max-height:200px;'>
                        </div>
                        Nama: <b>" . $row['namaBarangan'] . "</b>                
                      </td>
                      <td>
                        <div class='image'>
                          <img src='" . $row[12] . "' class='img-responsive thumbnail' style='max-height:200px;'>
                        </div>
                        Nama: <b>" . $row[7] . "</b>                
                      </td>
                      <td>" . $row['namaPelajar'] . "</td>
                      <td>" . $row['tarikhPertukaran'] . "</td>
                      <td>" . $row['statusPertukaran'] . "</td>              
                      <td>
                        <a href='item.php?idBarangan=" . $row['idBaranganOwner'] . "'>
                          <button class='btn btn-primary'>LIHAT</button>
                        </a>
                        <br><br>
                      </td>
                    </tr>
                    ";
                    $num++;
                }
                echo "
                  </tbody>
                </table>
                ";
                mysqli_free_result($result);
            } else {
                echo "Tiada pertukaran.";
            }
        }
    }
}
mysqli_close($conn);
?>
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

</html>