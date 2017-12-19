<?php
$sql = "SELECT JRawatan FROM Jenisrawatan";
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            echo "
            <input type='checkbox' name='". $row['JRawatan'] ."' value='".$row['JRawatan']."'>
            ";
        }
    } else {
        echo "Error";
    }
}
?>