<?php
session_start();
echo $_SESSION['ic'];
echo $_SESSION['email'];

require_once '../php/connect.php';

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

// Define variables and initialize with empty values
// $nama = $noTel = $alamat = "";
$noTelError = $alamatError = $password_err = "";
 
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
    if (empty($namaError) && $uploadOk == 1 && empty($noTelError) && empty($alamatError) && empty($password_err)) {
        
        $sql = "UPDATE pelajar SET namaPelajar = '$nama', noTel = '$noTel', alamat = '$alamat', profilePicture = '$target_file' WHERE noIC = $ic";

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
    } elseif (empty($namaError) && empty($noTelError) && empty($alamatError) && empty($password_err)) {
        
        $sql = "UPDATE pelajar SET namaPelajar = '$nama', noTel = '$noTel', alamat = '$alamat' WHERE noIC = $ic";
        
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JomSwap! - <?php echo $nama; ?></title>
  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/main.css">
  <script src="../node_modules/jquery/dist/jquery.min.js"></script>
  <script src="../js/hiding.js"></script>
  <script src="../js/buttons.js"></script>
</head>
<body>
<div class="wrapper">
  <a href="../index.php"><h1 style="font-size:7vw">JomSwap!</h1></a>
  <q cite="Me" style="font-size:3vw">One man's trash is another man's treasure.</q>
  <br>
  <br>
  <a href="signup.php" id="signup">Daftar</a>
  <a href="login.php" id="login">Log Masuk</a>
  <a href="exchange.php" id="trade">Pertukaran</a>
  <a href="inventory.php" id="inventory">Inventori</a>
  <a href="../php/logout.php" id="logout">Log Keluar</a>
  <br>
  <h2><?php echo $nama; ?></h2>
  <br>
  <img src="<?php echo $pic; ?>" style='max-width:50%;height:auto;'>
  <button class="btn btn-primary" id="btnEdit">Edit</button>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
  <br>
  <div class="form-group upload hid">
    <input type="file" name="fileToUpload" id="fileToUpload" class="form-control">
  </div>
  <h3>Butiran Diri</h3>
 
    <div class="form-group hid <?php echo (!empty($namaError)) ? 'has-error' : ''; ?>">
      <label>Nama:<sup>*</sup></label>
      <input type="text" name="name" class="form-control" value="<?php echo $nama; ?>">
      <span class="help-block"><?php echo $namaError; ?></span>
    </div>

    <div class="form-group">
      <label>No. IC:</label>
      <input type="" name="ic" class="form-control" value="<?php echo $ic; ?>" readonly>
    </div>

    <div class="form-group">
      <label>Jantina:</label>
      <input type="" name="jantina" class="form-control" value="<?php echo $jantina; ?>" readonly>
    </div>

    <div class="form-group <?php echo (!empty($noTelError)) ? 'has-error' : ''; ?>">
      <label>No. Telefon:<sup class="hid">*</sup></label>
      <input type="text" name="noTel" class="form-control" value="<?php echo $noTel; ?>" readonly>
      <span class="help-block"><?php echo $noTelError; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($alamatError)) ? 'has-error' : ''; ?>">
      <label>Alamat:<sup class="hid">*</sup></label>
      <textarea name="alamat" class="form-control" cols="30" rows="5" readonly><?php echo $alamat; ?></textarea>
      <span class="help-block"><?php echo $alamatError; ?></span>
    </div>

    <div class="form-group">
      <label>Tarikh Daftar:</label>
      <input type="date" class="form-control" value="<?php echo $tarikhDaftar; ?>" readonly>
    </div>

  <h3>Butiran Log Masuk</h3>
    <div class="form-group">
      <label>Email:</label>
      <input type="" name="email" class="form-control" value="<?php echo $email; ?>" readonly>
    </div>

    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
      <label>Kata laluan:<sup class="hid">*</sup></label>
      <input type="text" name="password" class="form-control" value="<?php echo $pwd; ?>" readonly="readonly">
      <span class="help-block"><?php echo $password_err; ?></span>
    </div>

    <div class="form-group hid">
      <input type="submit" class="btn btn-primary" value="Hantar">
    </div>
    
  </form>
</div>
<?php require '../php/hideButton.php'; ?>
</body>
</html>