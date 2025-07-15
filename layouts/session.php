<?php
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  switch ($_SESSION['role']) {
    case 1:
    case 2:
    case 3:
    case 4:
      header("location: index.php");
      break;

    default:
      header("location: login.php");
      break;
  }
  exit;
}
?>