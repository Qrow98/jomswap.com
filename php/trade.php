<?php
session_start();
echo $_SESSION['ic'];
echo $_SESSION['email'];

require_once '../php/connect.php';

if (isset($_POST['idBarangan']) && !empty(trim($_POST['idBarangan'])) && isset($_POST['idBarangan2']) && !empty(trim($_POST['idBarangan2']))) {

    $idBarangan = $_POST['idBarangan'];
    $idBarangan2 = $_POST['idBarangan2'];

    $status = "menunggu";

    $tarikh = date("Y-m-d");

    date_default_timezone_set("Asia/Kuala_Lumpur");
    $masa = date("h:i:s");

    $sql = "INSERT INTO pertukaran (tarikhPertukaran, masaPertukaran, statusPertukaran, idBarangan, idBarangan2)
    VALUES ('$tarikh', '$masa', '$status', '$idBarangan', '$idBarangan2')";
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