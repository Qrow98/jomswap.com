<?php
session_start();

require_once '../php/connect.php';

// Define variables and initialize with empty values
$ic = $_SESSION['ic'];
$nama = $noTel = $alamat = $gender = $tarikh = "";
$namaError = $noTelError = $alamatError = $genderError = $tarikhError = "";
 
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate nama
    if (empty(trim($_POST["name"]))) {
        $namaError = "Sila masukkan Nama anda.";
    } else {
        $nama = trim($_POST["name"]);
    }

    // jantina
    if (empty(trim($_POST["gender"]))) {
        $genderError = "Sila pilih jantina anda.";
    } else {
        $gender = trim($_POST["gender"]);
    }

    // tarikhLahir new
    if (empty(trim($_POST["date"]))) {
        $dateError = "Sila isi tarikh lahir anda.";
    } else {
        $date = trim($_POST["date"]);
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

    // Validate bandar new
    if (empty(trim($_POST["city"]))) {
        $cityError = "Sila masukkan Bandar anda.";
    } else {
        $city = trim($_POST["city"]);
    }

    // Validate poskod new validation 0 > x < 6
    if (empty(trim($_POST["postcode"]))) {
        $postcodeError = "Sila masukkan Poskod anda.";
    } else {
        $postcode = trim($_POST["postcode"]);
    }

    // Validate negeri new
    if (empty(trim($_POST["state"]))) {
        $stateError = "Sila masukkan Negeri anda.";
    } else {
        $state = trim($_POST["state"]);
    }

    // Profile picture
    include '../php/upload.php';

    // Check input errors before inserting in database
    if (empty($namaError) && empty($genderError) && empty($dateError) && empty($noTelError)
        && empty($alamatError) && empty($stateError) && empty($cityError) && empty($postcodeError)
    ) {
        
        $sql = "UPDATE pelajar SET namaPelajar = '$nama', jantina = '$gender', tarikhLahir = '$date', noTel = '$noTel', alamat = '$alamat', bandar = '$city', poskod = '$postcode', negeri = '$state', profilePicture = '$target_file' WHERE noIC = '$ic'";

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
  <!-- Bootstrap Material Datetime Picker Css -->
  <link href="../plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />
  <!-- Animation Css -->
  <link href="../plugins/animate-css/animate.css" rel="stylesheet" />
  <!-- Bootstrap Select Css -->
  <link href="../plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
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

          <div class="input-group">
            <span class="input-group-addon">
              <i class="material-icons">date_range</i>
            </span>
            <div class="form-line">
              <input type="text" class="datepicker form-control" name="date" placeholder="Birthday" required>
            </div>
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
              <input type="text" class="form-control" name="alamat" placeholder="Alamat" value="<?php echo $alamat; ?>">
            </div>
            <span class="help-block"><?php echo $alamatError; ?></span>
          </div>

          <div class="input-group <?php echo (!empty($cityError)) ? 'has-error' : ''; ?>">
            <span class="input-group-addon">
              <i class="material-icons">flight_takeoff</i>
            </span>
            <div class="form-line">
              <input type="text" class="form-control" name="city" placeholder="Bandar" value="<?php echo $city; ?>">
            </div>
            <span class="help-block"><?php echo $cityError; ?></span>
          </div>

          <div class="input-group <?php echo (!empty($postcodeError)) ? 'has-error' : ''; ?>">
            <span class="input-group-addon">
              <i class="material-icons">code</i>
            </span>
            <div class="form-line">
              <input type="number" class="form-control" name="postcode" placeholder="Poskod" value="<?php echo $postcode; ?>">
            </div>
            <span class="help-block"><?php echo $postcodeError; ?></span>
          </div>

          <div class="input-group <?php echo (!empty($stateError)) ? 'has-error' : ''; ?>">
            <span class="input-group-addon">
              <i class="material-icons">language</i>
            </span>
            <select name="state" class="form-control show-tick" required>
              <option disabled selected value style="display:none">Negeri</option>
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
            <span class="help-block"><?php echo $stateError; ?></span>
          </div>

          <div class="input-group">
            <span class="input-group-addon">
              <i class="material-icons">add_a_photo</i>
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
  <!-- Moment Plugin Js -->
  <script src="../plugins/momentjs/moment.js"></script>
  <!-- Bootstrap Material Datetime Picker Plugin Js -->
  <script src="../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
  <!-- Waves Effect Plugin Js -->
  <script src="../plugins/node-waves/waves.js"></script>
  <!-- Validation Plugin Js -->
  <script src="../plugins/jquery-validation/jquery.validate.js"></script>
  <!-- Select Plugin Js -->
  <script src="../plugins/bootstrap-select/js/bootstrap-select.js"></script>
  <!-- Custom Js -->
  <script src="../js/admin.js"></script>
  <script src="../js/pages/examples/sign-up.js"></script>
  <script src="../js/basic-form-elements.js"></script>

  <!-- Demo Js -->
  <script src="../js/demo.js"></script>
</body>

</html>