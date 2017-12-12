<?php
session_start();

require_once '../php/connect.php';

// Define variables and initialize with empty values
$ic = $_SESSION['ic'];
$nama = $noTel = $alamat = $gender = "";
$namaError = $noTelError = $alamatError = $genderError = "";
 
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate nama
    if (empty(trim($_POST["name"]))) {
        $namaError = "Sila masukkan Nama anda.";
    } else {
        $nama = trim($_POST["name"]);
    }

    if (empty(trim($_POST["gender"]))) {
        $genderError = "Sila pilih jantina anda.";
    } else {
        $gender = trim($_POST["gender"]);
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

    // Profile picture
    include '../php/upload.php';

    // Check input errors before inserting in database
    if (empty($namaError) && empty($genderError) && empty($noTelError) && empty($alamatError)) {
        
        $sql = "UPDATE pelajar SET namaPelajar = '$nama', jantina = '$gender', noTel = '$noTel', alamat = '$alamat', profilePicture = '$target_file' WHERE noIC = '$ic'";

        if (mysqli_query($conn, $sql)) {
            echo "<script>",
            "alert('Pendaftaran berjaya!');",
            "window.location.href='../index.php';",
            "</script>";
        } else {
            echo "Ralat dikesan. Sila cuba sebentar lagi.";
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
  <title>Pendaftaran | JomSwap</title>
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
  <!-- Custom Css -->
  <link href="../css/style.css" rel="stylesheet">
</head>

<body class="signup-page">
  <div class="signup-box">
    <div class="logo">
      <a href="../index.php">Jom<b>SWAP</b></a>
      <small>Tukar Barangan Anda!</small>
    </div>
    <div class="card">
      <div class="body">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="sign_up" method="post" enctype="multipart/form-data">
          <div class="msg">Anda hampir selesai!</div>

          <div class="input-group <?php echo (!empty($namaError)) ? 'has-error' : ''; ?>">
            <span class="input-group-addon">
              <i class="material-icons">person</i>
            </span>
            <div class="form-line">
              <input type="text" class="form-control" name="name" placeholder="Nama Penuh" value="<?php echo $nama; ?>" autofocus>
            </div>
            <span class="help-block"><?php echo $namaError; ?></span>
          </div>

          <div class="input-group <?php echo (!empty($genderError)) ? 'has-error' : ''; ?>">
            <span class="input-group-addon">
              <i class="material-icons">wc</i>
            </span>
            <input type="radio" name="gender" id="male" class="with-gap" value="Lelaki">
            <label for="male">Lelaki</label>
            <input type="radio" name="gender" id="female" class="with-gap" value="Perempuan">
            <label for="female" class="m-l-10">Perempuan</label>
            <span class="help-block"><?php echo $genderError;?></span>
          </div>

          <div class="input-group <?php echo (!empty($noTelError)) ? 'has-error' : ''; ?>">
            <span class="input-group-addon">
              <i class="material-icons">phone_iphone</i>
            </span>
            <div class="form-line">
              <input type="text" class="form-control" name="noTel" placeholder="Nombor Telefon" value="<?php echo $noTel; ?>">
            </div>
            <span class="help-block"><?php echo $noTelError; ?></span>
          </div>

          <div class="input-group <?php echo (!empty($alamatError)) ? 'has-error' : ''; ?>">
            <span class="input-group-addon">
              <i class="material-icons">home</i>
            </span>
            <div class="form-line">
              <textarea name="alamat" class="form-control" cols="15" rows="3" placeholder="Alamat"><?php echo $alamat; ?></textarea>
            </div>
            <span class="help-block"><?php echo $alamatError; ?></span>
          </div>

          <div class="input-group">
            <span class="input-group-addon">
              <i class="material-icons">insert_photo</i>
            </span>
            <input type="file" name="fileToUpload" id="fileToUpload" class="form-control" required>
          </div>

          <button class="btn btn-block btn-lg bg-pink waves-effect" name="submit" type="submit">DAFTAR</button>
          <div class="m-t-25 m-b--5 align-center">
            <a href="login.php">Sudah Daftar? Log Masuk Di Sini!</a>
          </div>
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
  <!-- Custom Js -->
  <script src="../js/admin.js"></script>
  <script src="../js/pages/examples/sign-up.js"></script>
</body>

</html>