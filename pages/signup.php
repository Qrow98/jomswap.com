<?php
session_start();

require_once '../php/connect.php';

$ic = $email = $password = $confirm_password = $tarikhDaftar = "";
$icError = $emailError= $password_err = $confirm_password_err = "";
 
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
    } elseif (!filter_var(trim($_POST["ic"]), FILTER_VALIDATE_INT)) {
        $icError = "Sila masukkan IC yang betul.";
    } elseif (strlen(trim($_POST['ic'])) > 12) {
        $icError = "IC mesti tidak melebihi 12 huruf.";
    } elseif (strlen(trim($_POST['ic'])) != 12) {
        $icError = "Sila masukkan IC yang betul.";
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
<html>

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <title>Pendaftaran | JomSwap</title>
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

<body class="signup-page">
  <div class="signup-box">
    <div class="logo">
      <a href="../index.php">Jom<b>SWAP</b></a>
      <small>Tukar Barangan Anda!</small>
    </div>
    <div class="card">
      <div class="body">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="sign_up" method="post">
          <div class="msg">Isi butiran anda ini untuk membuka akaun</div>
          
          <div class="input-group <?php echo (!empty($icError)) ? 'has-error' : ''; ?>">
            <span class="input-group-addon">
              <i class="material-icons">info</i>
            </span>
            <div class="form-line">
              <input type="text" class="form-control" name="ic" placeholder="Nombor IC" value="<?php echo $ic; ?>" autofocus>
            </div>
            <span class="help-block"><?php echo $icError; ?></span>
            <small>cth: 98061911XXXX</small>
          </div>

          <div class="input-group <?php echo (!empty($emailError)) ? 'has-error' : ''; ?>">
            <span class="input-group-addon">
              <i class="material-icons">email</i>
            </span>
            <div class="form-line">
              <input type="email" class="form-control" name="email" placeholder="Email Address" value="<?php echo $email; ?>">
            </div>
            <span class="help-block"><?php echo $emailError; ?></span>
          </div>

          <div class="input-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <span class="input-group-addon">
              <i class="material-icons">lock</i>
            </span>
            <div class="form-line">
              <input type="password" class="form-control" name="password" placeholder="Kata Laluan" value="<?php echo $password; ?>">
            </div>
            <span class="help-block"><?php echo $password_err; ?></span>
          </div>

          <div class="input-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
            <span class="input-group-addon">
              <i class="material-icons">lock</i>
            </span>
            <div class="form-line">
              <input type="password" class="form-control" name="confirm_password" placeholder="Sahkan Kata Laluan" value="<?php echo $confirm_password; ?>">
            </div>
            <span class="help-block"><?php echo $confirm_password_err; ?></span>
          </div>

          <button class="btn btn-block btn-lg bg-pink waves-effect" type="submit">DAFTAR</button>
          <div class="m-t-25 m-b--5 align-center">
            <a href="login.php">Sudah Daftar? Log Masuk Di Sini!</a>
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
  <script src="../js/pages/examples/sign-up.js"></script>
</body>

</html>