<?php
require_once "connect.php";

$idPertukaran = $_GET['idPertukaran'];
$idBaranganOwner = $_GET['idBaranganOwner'];
$idBaranganRequester = $_GET['idBaranganRequester'];
$sql = "UPDATE pertukaran SET statusPertukaran = 'Ditolak' WHERE idPertukaran = '$idPertukaran'";
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_query($conn, $sql)) {
        
        $sql = "UPDATE barangan SET statusBarangan = 'Ditolak' WHERE idBarangan = '$idBaranganOwner'";
        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_query($conn, $sql)) {

                $sql = "UPDATE barangan SET statusBarangan = 'Ditolak' WHERE idBarangan = '$idBaranganRequester'";
                if ($result = mysqli_query($conn, $sql)) {
                    if (mysqli_query($conn, $sql)) {
                        echo "<script>",
                        "alert('Pertukaran berjaya ditolak.');",
                        "window.location.href='../pages/exchange.php';",
                        "</script>";
                    } else {
                        echo "Ralat dikesan. Sila cuba sebentar lagi.";
                        echo "<br>";        
                        echo mysqli_error($conn);
                    }
                }
            } else {
                echo "Ralat dikesan. Sila cuba sebentar lagi.";
                echo "<br>";        
                echo mysqli_error($conn);
            }
        }
    } else {
        echo "Ralat dikesan. Sila cuba sebentar lagi.";
        echo "<br>";        
        echo mysqli_error($conn);
    }
}
?>