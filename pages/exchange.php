<?php
session_start();
echo $_SESSION['ic'];
echo $_SESSION['email'];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JomSwap! - Pertukaran Semasa</title>
  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/main.css">
  <script src="../node_modules/jquery/dist/jquery.min.js"></script>
  <!-- <script src="../js/hiding.js"></script> -->
  <script src="../js/buttons.js"></script>
  <!-- <script src="../js/deleteItem.js"></script> -->
</head>
<body>
<div class="wrapper">
  <a href="../index.php"><h1 style="font-size:7vw">JomSwap!</h1></a>
  <q cite="Me" style="font-size:3vw">One man's trash is another man's treasure.</q>
  <br>
  <br>
  <a href="signup.php" id="signup">Daftar</a>
  <a href="login.php" id="login">Log Masuk</a>
  <a href="currentExchange.php" id="trade">Pertukaran</a>
  <a href="inventory.php" id="inventory">Inventori</a>
  <a href="../php/logout.php" id="logout">Log Keluar</a>
  <br>
  <img src="<?php echo $gambarBarangan; ?>" style='max-width:50%;height:auto;'>
  <h1>Pertukaran Semasa</h1>
<?php
require_once '../php/connect.php';
$ic = $_SESSION['ic'];

$num = 1;
$sql = "SELECT * 
FROM pertukaran p LEFT JOIN barangan b ON (p.idBarangan = b.idBarangan) LEFT JOIN pelajar pl ON (b.noIC = pl.noIC)";
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        echo "<table border=1>";
            echo "<tr>";
                echo "<th>Bil.</th>";
                echo "<th>Gambar</th>";
                echo "<th>Barang 1</th>";
                echo "<th>Barang 2</th>";
                echo "<th>Tarikh</th>";
                echo "<th>Status</th>";
                echo "<th>Action</th>";
            echo "</tr>";
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
                echo "<td>" . $num . ".</td>";
                echo "<td><img src='" . $row['gambarBarangan'] . "' style='max-width:65%;height:auto;'></td>";
                echo "<td>" . $row['idBarangan'] . "</td>";
                echo "<td>" . $row['idBarangan2'] . "</td>";
                echo "<td>" . $row['tarikhPertukaran'] . "</td>";
                echo "<td>" . $row['statusPertukaran'] . "</td>";
                echo "<td><a href='item.php?idBarangan=" . $row['idBarangan'] . "'><button class='btn btn-primary'>LIHAT</button></a></td>";
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
?>
</div>
<?php require '../php/hideButton.php'; ?>
</body>
</html>
