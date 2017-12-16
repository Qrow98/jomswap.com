<?php
session_start();

require_once '../php/connect.php';

// Define variables and initialize with empty values
$ic = $_SESSION['ic'];
$nama = $butiran = $kategori = "";
$namaError = $butiranError = $kategoriError = "";
 
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate nama
    if (empty(trim($_POST["nama"]))) {
        $namaError = "Sila masukkan Nama barangan anda.";
    } else {
        $nama = trim($_POST["nama"]);
    }

    // Validate butiran
    if (empty(trim($_POST["butiran"]))) {
        $butiranError = "Sila masukkan butiran barangan anda.";
    } else {
        $butiran = trim($_POST["butiran"]);
    }

    // Validate kategori
    if (empty(trim($_POST["kategori"]))) {
        $kategoriError = "Sila masukkan kategori barangan anda.";
    } else {
        $kategori = trim($_POST["kategori"]);
    }

    // Get time 
    $tarikh = date("Y-m-d");

    // Profile picture
    include '../php/upload.php';
    include '../php/upload2.php';
    include '../php/upload3.php';
        
    // Check input errors before inserting in database
    if (empty($namaError) && empty($butiranError) && empty($kategoriError)) {
        
        $sql = "INSERT INTO barangan (namaBarangan, butiranBarangan, kategoriBarangan, tarikhMuatNaik, gambarBarangan, gambarBarangan2, gambarBarangan3, noIC)
        VALUES ('$nama', '$butiran', '$kategori', '$tarikh', '$target_file', '$target_file2', '$target_file3', '$ic')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>",
            "alert('Barang anda telah ditambah.');",
            "window.location.href='inventory.php';",
            "</script>";
        } else {
            echo "<script>","alert('Ralat dikesan. Sila cuba sebentar lagi.');","</script>";
            echo "<br>";
            echo mysqli_error($conn);
        }
    }
    
    // Close connection
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <title>Log Masuk | JomSwap</title>
  <!-- Favicon-->
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
</head>

<body class="login-page">
  <div class="login-box">
    <div class="logo">
      <a href="../index.php">Jom<b>SWAP</b></a>
      <small>Tukar Barangan Anda!</small>
    </div>
    <div class="card">
      <div class="body">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="sign_in" method="post" enctype="multipart/form-data">
          <div class="msg">Isi butiran barangan anda</div>

          <div class="input-group <?php echo (!empty($namaError)) ? 'has-error' : ''; ?>">
            <span class="input-group-addon">
              <i class="material-icons">shopping_cart</i>
            </span>
            <div class="form-line">
              <input type="text" class="form-control" name="nama" placeholder="Nama" value="<?php echo $nama; ?>" autofocus>
            </div>
            <span class="help-block"><?php echo $namaError; ?></span>
          </div>

          <div class="input-group <?php echo (!empty($butiranError)) ? 'has-error' : ''; ?>">
            <span class="input-group-addon">
              <i class="material-icons">more</i>
            </span>
            <div class="form-line">
              <textarea name="butiran" class="form-control" cols="15" rows="3" placeholder="Butiran"><?php echo $butiran; ?></textarea>
            </div>
            <span class="help-block"><?php echo $butiranError; ?></span>
          </div>

          <div class="input-group <?php echo (!empty($kategoriError)) ? 'has-error' : ''; ?>">
            <span class="input-group-addon">
              <i class="material-icons">toc</i>
            </span>
            <select name="kategori" class="form-control show-tick" required>
              <option disabled selected value style="display:none">Kategori</option>
              <option>Pakaian</option>
              <option>Aksesori</option>
              <option>Kasut</option>
              <option>Barangan Sukan</option>
              <option>Barangan Elektronik</option>
              <option>Games</option>
              <option>Alat tulis</option>
              <option>Buku</option>
              <option>Makanan</option>
              <option>Etc</option>
            </select>
            <span class="help-block"><?php echo $kategoriError; ?></span>
          </div>

          <div class="input-group">
            <span class="input-group-addon">
              <i class="material-icons">add_a_photo</i>
            </span>
            <input type="file" name="fileToUpload" id="fileToUpload" class="form-control" required>
          </div>

          <div class="input-group">
            <span class="input-group-addon">
              <i class="material-icons">add_a_photo</i>
            </span>
            <input type="file" name="fileToUpload2" id="fileToUpload2" class="form-control" required>
          </div>

          <div class="input-group">
            <span class="input-group-addon">
              <i class="material-icons">add_a_photo</i>
            </span>
            <input type="file" name="fileToUpload3" id="fileToUpload3" class="form-control" required>
          </div>
          
          <button class="btn btn-block btn-lg bg-pink waves-effect" type="submit">TAMBAH</button>
        </form>
      </div>
    </div>
  </div>
  <!-- Jquery Core Js -->
  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap Core Js -->
  <script src="../plugins/bootstrap/js/bootstrap.js"></script>
  <!-- Waves Effect Plugin Js -->
  <script src="../plugins/node-waves/waves.js"></script>
  <!-- Validation Plugin Js -->
  <script src="../plugins/jquery-validation/jquery.validate.js"></script>
  <!-- Select Plugin Js -->
  <script src="../plugins/bootstrap-select/js/bootstrap-select.js"></script>
  <!-- Custom Js -->
  <script src="../js/admin.js"></script>
  <script src="../js/pages/examples/sign-in.js"></script>
</body>

</html>