<?php
session_start();
echo $_SESSION['ic'];
echo $_SESSION['email'];

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
        }
    }
}

$noTelError = $alamatError = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

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
    if ($uploadOk == 1 && empty($noTelError) && empty($alamatError) && empty($confirm_password_err) && empty($password_err)) {

        $sql = "UPDATE pelajar SET noTel = $noTel, alamat = '$alamat', profilePicture = '$target_file' WHERE noIC = $ic";

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
    } elseif (empty($noTelError) && empty($alamatError) && empty($confirm_password_err) && empty($password_err)) {

        $sql = "UPDATE pelajar SET noTel = $noTel, alamat = '$alamat' WHERE noIC = $ic";

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
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JomSwap! - <?php echo $namaBarangan; ?></title>
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
  <h2><?php echo $namaBarangan; ?></h2>
  <br>
  <img src="<?php echo $gambarBarangan; ?>" style='max-width:50%;height:auto;'>
  <button class="btn btn-primary" id="btnEdit">Edit</button>
  <form action="tukar.php" method="post">
    <div class="form-group">
      <label>Butiran:</label>
      <textarea name="butiran" class="form-control" cols="30" rows="5" readonly><?php echo $butiranBarangan; ?></textarea>
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
</div>
<?php require '../php/hideButton.php'; ?>
</body>
</html>
