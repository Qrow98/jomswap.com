<?php
if (isset($_SESSION['user'])) {
    echo  '<script type="text/javascript">','afterLogin();','</script>';
    // echo  '<script type="text/javascript">','hideButton3();','</script>';
} elseif (isset($_SESSION['admin'])) {
    echo  '<script type="text/javascript">','afterLogin();','</script>';
    // echo  '<script type="text/javascript">','hideButton4();','</script>';
    // echo  '<script type="text/javascript">','hideButton5();','</script>';
} else {
    echo  '<script type="text/javascript">','beforeLogin();','</script>';
    // echo  '<script type="text/javascript">','hideButton3();','</script>';
}
?>