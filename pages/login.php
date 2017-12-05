<?php
session_start();
echo $_SESSION['ic'];
echo $_SESSION['email'];

require_once '../php/connect.php';

// Define variables and initialize with empty values
$email = $password = "";
$emailError = $password_err = "";
 
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["email"]))) {
        $emailError = 'Sila masukkan email anda.';
    } else {
        $email = trim($_POST["email"]);
    }
    
    // Check if password is empty
    if (empty(trim($_POST['password']))) {
        $password_err = 'Please enter your password.';
    } else {
        $password = trim($_POST['password']);
    }
    
    // Validate credentials
    if (empty($emailError) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT email FROM logMasuk WHERE email = ?";
        
        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = $email;
            
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if email exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {

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
                } else {
                    // Display an error message if username doesn't exist
                    $emailError = 'Tiada akaun yang dijumpai dengan email tersebut.';
                }
            } else {
                echo "Ralat dikesan. Sila cuba sebentar lagi.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/main.css">
</head>
<body>
<div class="wrapper">
  <a href="../index.php"><h1 style="font-size:7vw">JomSwap!</h1></a>
  <q cite="Me" style="font-size:3vw">One man's trash is another man's treasure.</q>
  <br>
  <br>
  <h2>Log Masuk</h2>
  <p>Sila isi butiran akaun anda untuk log masuk.</p>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="form-group <?php echo (!empty($emailError)) ? 'has-error' : ''; ?>">
      <label>Email:<sup>*</sup></label>
      <input type="text" name="email"class="form-control" value="<?php echo $email; ?>">
      <span class="help-block"><?php echo $emailError; ?></span>
    </div>    
    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
      <label>Kata laluan:<sup>*</sup></label>
      <input type="password" name="password" class="form-control">
      <span class="help-block"><?php echo $password_err; ?></span>
    </div>
    <div class="form-group">
      <input type="submit" class="btn btn-primary" value="Masuk">
    </div>
    <p>Tiada akaun? <a href="signup.php">Daftar sekarang!</a></p>
  </form>
</div>    
</body>
</html>