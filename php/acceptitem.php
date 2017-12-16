<?php
require_once "connect.php";

$idPertukaran = $_GET['idPertukaran'];
$sql = "UPDATE pertukaran SET statusPertukaran = 'Diterima' WHERE idPertukaran = '$idPertukaran'";
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_query($conn, $sql)) {
        echo "<script>",
        "alert('Pertukaran berjaya. Sila cetak resit untuk pengesahan.');",
        "window.location.href='../pages/receipt.php?idPertukaran=".$idPertukaran."';",
        "</script>";
    } else {
        echo "Ralat dikesan. Sila cuba sebentar lagi.";
        echo "<br>";        
        echo mysqli_error($conn);
    }
}
?>