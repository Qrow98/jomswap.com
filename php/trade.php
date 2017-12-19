<?php
session_start();

require_once '../php/connect.php';

if (isset($_POST['idBaranganOwner']) && !empty(trim($_POST['idBaranganOwner'])) 
    && isset($_POST['idBaranganRequester']) && !empty(trim($_POST['idBaranganRequester']))
) {

    $idBaranganOwner = $_POST['idBaranganOwner'];
    $idBaranganRequester = $_POST['idBaranganRequester'];

    $status = "menunggu";

    $tarikh = date("Y-m-d");

    date_default_timezone_set("Asia/Kuala_Lumpur");
    $masa = date("h:i:s");

    $sql = "INSERT INTO pertukaran (tarikhPertukaran, masaPertukaran, statusPertukaran, idBaranganOwner, idBaranganRequester)
    VALUES ('$tarikh', '$masa', '$status', '$idBaranganOwner', '$idBaranganRequester')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>",
        "alert('Permintaan anda telah berjaya dihantar.');",
        "window.location.href='../pages/exchange.php';",
        "</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        echo "Ralat dikesan. Sila cuba sebentar lagi.";
    }
}
?>