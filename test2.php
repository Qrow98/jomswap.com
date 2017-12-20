<?php
$sql1 = "SELECT password, noIC FROM logMasuk WHERE email = '$email' AND password = '$password'";

if ($result = mysqli_query($conn, $sql1)) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $ic = $row['noIC'];
        }
        $_SESSION['email'] = $email;
        $_SESSION['user'] = $email;
        $_SESSION['ic'] = $ic;
        header("location: ../index.php");
    } else {
        // Display an error message if password is not valid
        $password_err = 'Kata laluan yang anda masukkan tidak sah.';
    }
} else {
    echo "Ralat dikesan. Sila cuba sebentar lagi.";
}
?>