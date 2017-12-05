<?php
$sql = "DELETE FROM barangan WHERE idBarangan = '$idBarangan'";
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_query($conn, $sql)) {
        echo "<script>","alert('Barang anda telah dipadam.');","</script>";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
        echo "Ralat dikesan. Sila cuba sebentar lagi.";
    }
}
?>