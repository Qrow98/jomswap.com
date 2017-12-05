<?php
session_start();
echo $_SESSION['ic'];
echo $_SESSION['email'];

// Include config file
require_once '../php/connect.php';

// Define variables and initialize with empty values
$ic = $email = $password = $confirm_password = $tarikhDaftar = "";
$icError = $emailError= $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $emailError = "Sila masukkan email anda.";
    } else {
        // Prepare a select statement
        $sql = "SELECT * FROM logMasuk WHERE email = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $emailError = "Email ini sudah wujud.";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "Ralat dikesan. Sila cuba sebentar lagi.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Validate IC
    if (empty(trim($_POST["ic"]))) {
        $icError = "Sila masukkan IC anda.";
    } else {
        // Prepare a select statement
        $sql = "SELECT * FROM pelajar WHERE noIC = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_ic);

            // Set parameters
            $param_ic = trim($_POST["ic"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $icError = "IC ini sudah wujud.";
                } else {
                    $ic = trim($_POST["ic"]);
                }
            } else {
                echo "Ralat dikesan. Sila cuba sebentar lagi.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Validate password
    if (empty(trim($_POST['password']))) {
        $password_err = "Sila masukkan kata laluan anda.";     
    } elseif (strlen(trim($_POST['password'])) < 6) {
        $password_err = "Kata laluan mesti mempunyai sekurang-kurangnya 6 huruf.";
    } else {
        $password = trim($_POST['password']);
    }
    
    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = 'Sila sahkan kata laluan.';     
    } else {
        $confirm_password = trim($_POST['confirm_password']);
        if ($password != $confirm_password) {
            $confirm_password_err = 'Kata laluan tidak sepadan.';
        }
    }
    
    // Get time 
    $tarikh = date("Y-m-d");

    // Check input errors before inserting in database
    if (empty($icError) && empty($emailError) && empty($password_err) && empty($confirm_password_err)) {
        
        // Prepare an insert statement
        $sql = "INSERT INTO pelajar (noIC, tarikhDaftar)
        VALUES ('$ic', '$tarikh')";
        if (mysqli_query($conn, $sql)) {
            $sql = "INSERT INTO logMasuk (email, password, noIC)
            VALUES ('$email', '$password', '$ic')";
            if (mysqli_query($conn, $sql)) {
                // Redirect to login page
                $_SESSION['ic'] = $ic;
                $_SESSION['user'] = $email;
                $_SESSION['email'] = $email;
                header("location: signup1.php");
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                echo "Ralat dikesan. Sila cuba sebentar lagi.";
            }
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            echo "Ralat dikesan. Sila cuba sebentar lagi.";
        }
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JomSwap! - Pendaftaran</title>
  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/main.css">
</head>
<body>
  <div class="wrapper">
    <a href="../index.php"><h1   style="font-size:7vw">JomSwap!</h1></a>
    <q cite="Me" style="font-size:3vw">One man's trash is     another man's treasure.</q>
    <br>
    <br>
    <h2>Daftar Masuk</h2>
    <p>Sila isi borang ini untuk membuat akaun.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

      <div class="form-group <?php echo (!empty($icError)) ? 'has-error' : ''; ?>">
        <label>No. IC:<sup>*</sup></label>
        <input type="text" name="ic" class="form-control" value="<?php echo $ic; ?>">
        <span class="help-block"><?php echo $icError; ?></span>
      </div>

      <div class="form-group <?php echo (!empty($emailError)) ? 'has-error' : ''; ?>">
        <label>Email:<sup>*</sup></label>
        <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
        <span class="help-block"><?php echo $emailError; ?></span>
      </div>

      <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
        <label>Kata laluan:<sup>*</sup></label>
        <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
        <span class="help-block"><?php echo $password_err; ?></span>
      </div>

      <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
        <label>Sahkan kata laluan:<sup>*</sup></label>
        <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
        <span class="help-block"><?php echo $confirm_password_err; ?></span>
      </div>
      
      <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Hantar">
        <input type="reset" class="btn btn-default" value="Reset">
      </div>

      <p>Sudah mempunyai akaun? <a href="login.php">Log masuk disini</a>.</p>
    </form>
  </div>    
</body>
</html>