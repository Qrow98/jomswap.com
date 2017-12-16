<?php
if (isset($_SESSION['email'])) {
    echo "
    <div class='image'>
      <img src='". $pic ."' width='48' height='48' alt='User' />
    </div>
    <div class='info-container'>
      <div class='name' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>". $nama ."</div>
      <div class='email'>". $_SESSION['email'] ."</div>
    </div>    
    ";
} else {
    echo "
    <div class='image'>
      <img src='../images/user.png' width='48' height='48' alt='User' />
    </div>
    <div class='info-container'>            
      <div class='name' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Tetamu</div>
      <div class='email'>Selamat datang!</div>
    </div>  
    ";
}
?>