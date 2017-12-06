<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JomSwap! - Laman Utama</title>
  <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/main.css">
  <script src="js/buttons.js"></script>
</head>
<body>
<div class="wrapper">
  <a href="index.php"><h1 style="font-size:7vw">JomSwap!</h1></a>
  <q cite="Me" style="font-size:3vw">One man's trash is another man's treasure.</q>
  <br>
  <br>
  <a href="pages/signup.php" id="signup">Daftar</a>
  <a href="pages/login.php" id="login">Log Masuk</a>
  <a href="pages/exchange.php" id="trade">Pertukaran</a>
  <a href="pages/inventory.php" id="inventory">Inventori</a>
  <a href="php/logout.php" id="logout">Log Keluar</a>
  <br>
  <br>
  <a href="pages/itemAdd.php" id="additems">Tambah Barang</a>
  <a href="pages/profile.php"><?php echo $_SESSION['email']; ?></a>

<?php
echo $_SESSION['ic'];

require_once 'php/connect.php';
$num = 1;
$sql = "SELECT * FROM barangan";
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
                $dir = $row['gambarBarangan'];
                $dir = preg_replace('$^../$', '', $dir);
                echo "<td><img src='" . $dir . "' style='max-width:50%;height:auto;'></td>";
                echo "<td>" . $row['namaBarangan'] . "</td>";
                echo "<td>" . $row['butiranBarangan'] . "</td>";
                echo "<td>" . $row['kategoriBarangan'] . "</td>";
                echo "<td>" . $row['tarikhMuatNaik'] . "</td>";
                echo "<td><a href='pages/item.php?idBarangan=" . $row['idBarangan'] . "'><button class='btn btn-primary'>LIHAT</button></a></td>";
            echo "</tr>";
            $num++;
        }
        echo "</table>";
        mysqli_free_result($result);
    } else {
        echo "Ralat dikesan. Sila cuba sebentar lagi.";
    }
}
mysqli_close($conn);

require 'php/hideButton.php';
?>
</div>
</body>
</html>
