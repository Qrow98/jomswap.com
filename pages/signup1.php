<?php
session_start();
echo $_SESSION['ic'];
echo $_SESSION['email'];

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
            header("location: ../index.php");
        } else {
            echo "Ralat dikesan. Sila cuba sebentar lagi.";
            echo "<br>";
            echo mysqli_error($conn);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JomSwap! - Pendaftaran</title>
  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/main.css">
</head>
<body>
  <div class="wrapper">
    <a href="../index.php"><h1 style="font-size:7vw">JomSwap!</h1></a>
    <h2>Anda hampir selesai!</h2>
    <p>Isi butiran berikut.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">

      <div class="form-group <?php echo (!empty($namaError)) ? 'has-error' : ''; ?>">
        <label>Nama:<sup>*</sup></label>
        <input type="text" name="name" class="form-control" value="<?php echo $nama; ?>">
        <span class="help-block"><?php echo $namaError; ?></span>
      </div>
      
      <div class="form-group <?php echo (!empty($genderError)) ? 'has-error' : ''; ?>">
        <label>Jantina:<sup>*</sup></label>
        <input type="radio" name="gender" value="lelaki">Lelaki
        <input type="radio" name="gender" value="perempuan">Perempuan
        <span class="help-block"><?php echo $genderError;?></span>
      </div>

      <div class="form-group <?php echo (!empty($noTelError)) ? 'has-error' : ''; ?>">
        <label>No. Telefon:<sup>*</sup></label>
        <input type="text" name="noTel" class="form-control" value="<?php echo $noTel; ?>">
        <span class="help-block"><?php echo $noTelError; ?></span>
      </div>

      <div class="form-group <?php echo (!empty($alamatError)) ? 'has-error' : ''; ?>">
        <label>Alamat:<sup>*</sup></label>
        <textarea name="alamat" class="form-control" cols="30" rows="5"><?php echo $alamat; ?></textarea>
        <span class="help-block"><?php echo $alamatError; ?></span>
      </div>

      <div class="form-group">
        <label>Gambar Profile:<sup>*</sup></label>
        <input type="file" name="fileToUpload" id="fileToUpload" class="form-control" required>
        <span class="help-block"><?php echo $emailError; ?></span>
      </div>

      <div class="form-group">
        <input type="submit" name="submit" class="btn btn-primary" value="Hantar">
        <input type="reset" class="btn btn-default" value="Reset">
      </div>

    </form>
  </div>    
</body>
</html>