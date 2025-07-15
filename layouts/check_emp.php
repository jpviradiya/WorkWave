<?php
if ($_SESSION['role'] != 4) {
  header("Location: login.php");
  exit();
}