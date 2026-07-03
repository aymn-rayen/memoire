<?php
session_start();
if (isset($_SESSION['login']) || isset($_SESSION['username'])) {
    header('Location: acceuil.php');
} else {
    header('Location: login/login.php');
}
exit();
?>
