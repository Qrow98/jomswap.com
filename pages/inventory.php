<?php
session_start(); 
echo $_SESSION['ic'];
echo $_SESSION['email'];
require_once "../php/connect.php";

if (isset($_POST['idBarangan']) && !empty(trim($_POST['idBarangan']))) {
    include '../php/deleteItem.php';
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JomSwap! - Inventori</title>
  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/main.css">
  <script src="../node_modules/jquery/dist/jquery.min.js"></script>
  <script src="../js/buttons.js"></script>
  <script src="../js/deleteItem.js"></script>
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
  <a href="itemAdd.php" id="additems">Tambah Barang</a>
<?php
$ic = $_SESSION['ic'];
$num = 1;
$sql = "SELECT * FROM barangan WHERE noIC = '$ic'";
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        echo "<table border=1>";
            echo "<tr>";
                echo "<th>Bil.</th>";
                echo "<th>Gambar</th>";
                echo "<th>Nama</th>";
                echo "<th>Butiran</th>";
                echo "<th>Kategori</th>";
                echo "<th>Tarikh</th>";
                echo "<th>Action</th>";
            echo "</tr>";
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
                echo "<td>" . $num . ".</td>";
                echo "<td><img src='" . $row['gambarBarangan'] . "' style='max-width:65%;height:auto;'></td>";
                echo "<td>" . $row['namaBarangan'] . "</td>";
                echo "<td>" . $row['butiranBarangan'] . "</td>";
                echo "<td>" . $row['kategoriBarangan'] . "</td>";
                echo "<td>" . $row['tarikhMuatNaik'] . "</td>";
                echo "<td>";
                echo "<a href='item.php?idBarangan=" . $row['idBarangan'] . "'><button class='btn btn-primary'>LIHAT</button></a>";
                echo "<form action=" . htmlspecialchars($_SERVER['PHP_SELF']) . " method='post'>
                <input type='hidden' name='idBarangan' value=" . $row['idBarangan'] . ">
                <input type='submit' class='btn btn-primary del' value='PADAM'>
                </form>";
                echo "</td>";
            echo "</tr>";
            $num++;
        }
        echo "</table>";
        mysqli_free_result($result);
    } else {
        echo "<br>Tiada Barangan. Sila tambah barangan anda.";
    }
}
mysqli_close($conn);

require '../php/hideButton.php';
?>
</div>
</body>
</html>