<?php
require_once "connect.php";

$idBarangan = $_GET['idBarangan'];
$sql = "DELETE FROM barangan WHERE idBarangan = '$idBarangan'";
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_query($conn, $sql)) {
        echo "<script>",
        "alert('Barang anda telah dipadam.');",
        "window.location.href='../pages/inventory.php';",
        "</script>";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
        echo "Ralat dikesan. Sila cuba sebentar lagi.";
    }
}
?>