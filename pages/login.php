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
        $password_err = 'Sila masukkan kata laluan anda.';
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
<html>

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <title>Log Masuk | JomSwap</title>
  <!-- Favicon-->
  <link rel="icon" href="../favicon.ico" type="image/x-icon">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
  <!-- Bootstrap Core Css -->
  <link href="../plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
  <!-- Waves Effect Css -->
  <link href="../plugins/node-waves/waves.css" rel="stylesheet" />
  <!-- Animation Css -->
  <link href="../plugins/animate-css/animate.css" rel="stylesheet" />
  <!-- Custom Css -->
  <link href="../css/style.css" rel="stylesheet">
</head>

<body class="login-page">
  <div class="login-box">
    <div class="logo">
      <a href="../index.php">Jom<b>SWAP</b></a>
      <small>Tukar Barangan Anda!</small>
    </div>
    <div class="card">
      <div class="body">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="sign_in" method="post">
          <div class="msg">Isi butiran akaun anda untuk log masuk</div>
          <div class="input-group <?php echo (!empty($emailError)) ? 'has-error' : ''; ?>">
            <span class="input-group-addon">
              <i class="material-icons">person</i>
            </span>
            <div class="form-line">
              <input type="text" class="form-control" name="email" placeholder="Email" value="<?php echo $email; ?>" autofocus>
            </div>
            <span class="help-block"><?php echo $emailError; ?></span>
          </div>
          <div class="input-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <span class="input-group-addon">
              <i class="material-icons">lock</i>
            </span>
            <div class="form-line">
              <input type="password" class="form-control" name="password" placeholder="Kata Laluan">
            </div>
            <span class="help-block"><?php echo $password_err; ?></span>
          </div>
          <div class="row">
            <div class="col-xs-12 p-t-5">
              <button class="btn btn-block bg-pink waves-effect" type="submit">LOG MASUK</button>
            </div>
          </div>
          <div class="row m-t-15 m-b--20">
            <div class="col-xs-12 align-center">
              Tiada akaun? <a href="signup.php">Daftar Sekarang!</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Jquery Core Js -->
  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap Core Js -->
  <script src="../plugins/bootstrap/js/bootstrap.js"></script>
  <!-- Waves Effect Plugin Js -->
  <script src="../plugins/node-waves/waves.js"></script>
  <!-- Validation Plugin Js -->
  <script src="../plugins/jquery-validation/jquery.validate.js"></script>
  <!-- Custom Js -->
  <script src="../js/admin.js"></script>
  <script src="../js/pages/examples/sign-in.js"></script>
</body>

</html>