<?php
session_start();

require_once "../php/connect.php";

$ic = $_SESSION['ic'];
$sql = "SELECT * FROM pelajar WHERE noIC = $ic";
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $nama = $row['namaPelajar'];
        }
        mysqli_free_result($result);
    } else {
        echo "Ralat dikesan. Sila cuba sebentar lagi.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <title>Resit | JomSwap</title>
  <!-- Favicon-->
  <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
  <link rel="icon" href="../favicon.ico" type="image/x-icon">
</head>
<body style="font-family: monospace;">
<?php
$idPertukaran = $_GET['idPertukaran'];

$sql = "SELECT *
FROM pertukaran t
JOIN barangan t1 ON t1.idBarangan = t.idBaranganOwner 
JOIN barangan t2 ON t2.idBarangan = t.idBaranganRequester LEFT JOIN pelajar t3 ON t3.noIC = t2.noIC
WHERE idPertukaran = $idPertukaran AND t1.noIC = '$ic'";
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            echo "
            ********** RESIT PERTUKARAN **********
            <br><br>
            Barangan Anda ------------ " . $row[7] . "<br>
            Pemilik ------------------ " . $nama . "<br>            
            Barangan Diminta --------- " . $row['namaBarangan'] . "<br>
            Pemilik ------------------ " . $row[25] . "<br>
            Tarikh ------------------- " . $row['tarikhPertukaran'] . "<br>
            Status ------------------- " . $row['statusPertukaran'] . "
            <br><br>
            ********** RESIT PERTUKARAN **********

            ";
        }
        mysqli_free_result($result);
    } else {
        echo "<br>";
        echo "Tiada pertukaran.";
    }
}
?>
<br><br>
<button onClick="window.print()">Cetak</button>
<a href="exchange.php"><button>Kembali</button></a>
</body>
</html>
