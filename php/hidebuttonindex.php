<?php
if (isset($_SESSION['email'])) {
    echo "
      <li>
        <a href='pages/inventory.php'>
          <i class='material-icons'>shopping_basket</i>
          <span>Inventori</span>
        </a>
      </li>
      <li>
        <a href='pages/exchange.php'>
          <i class='material-icons'>swap_vert</i>
          <span>Pertukaran</span>
        </a>
      </li>
    <li class='header'>MENU PENGGUNA</li>
      <li>
        <a href='pages/profile.php'>
          <i class='material-icons'>person</i>
          <span>Profil</span>
        </a>
      </li>
      <li>
        <a href='php/logout.php'>
          <i class='material-icons'>directions_run</i>
          <span>Logout</span>
        </a>
      </li>
    ";
} else {
    echo "
    <li class='header'>MENU PENGGUNA</li>                
      <li>
        <a href='pages/login.php'>
          <i class='material-icons'>input</i>
          <span>Log Masuk</span>
        </a>
      </li>
      <li>
        <a href='pages/signup.php'>
          <i class='material-icons'>person_add</i>
          <span>Daftar</span>
        </a>
      </li>
    ";
}
?>