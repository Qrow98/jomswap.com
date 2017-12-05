<?php
session_start();
echo $_SESSION['ic'];
echo $_SESSION['email'];

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
        
    // Check input errors before inserting in database
    if (empty($namaError) && empty($butiranError) && empty($kategoriError)) {
        
        $sql = "INSERT INTO barangan (namaBarangan, butiranBarangan, kategoriBarangan, tarikhMuatNaik, gambarBarangan, noIC)
        VALUES ('$nama', '$butiran', '$kategori', '$tarikh', '$target_file', '$ic')";

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
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JomSwap! - Tambah Barangan</title>
  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/main.css">
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
  <a href="itemMine.php" id="inventory">Inventori</a>
  <a href="../php/logout.php" id="logout">Log Keluar</a>
  <br>
  <h2>Tambah Barangan</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">

    <div class="form-group <?php echo (!empty($namaError)) ? 'has-error' : ''; ?>">
      <label>Nama:<sup>*</sup></label>
      <input type="text" name="nama" class="form-control" value="<?php echo $nama; ?>">
      <span class="help-block"><?php echo $namaError; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($butiranError)) ? 'has-error' : ''; ?>">
      <label>Butiran:<sup>*</sup></label>
      <textarea name="butiran" class="form-control" cols="30" rows="5"><?php echo $butiran; ?></textarea>
      <span class="help-block"><?php echo $butiranError; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($kategoriError)) ? 'has-error' : ''; ?>">
      <label>Kategori:<sup>*</sup></label>
      <select name="kategori" class="form-control" required>
        <option disabled selected value style="display:none"> -- pilih kategori -- </option>
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

    <div class="form-group">
      <label>Gambar:<sup>*</sup></label>
      <input type="file" name="fileToUpload" id="fileToUpload" class="form-control" required>
      <span class="help-block"><?php echo $emailError; ?></span>
    </div>

    <div class="form-group">
      <input type="submit" class="btn btn-primary" value="Tambah">
    </div>

  </form>
</div>
<?php require '../php/hideButton.php'; ?>
</body>
</html>