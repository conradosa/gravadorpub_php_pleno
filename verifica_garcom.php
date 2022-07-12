<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: home.php');
    exit();
}
if ($_SESSION['email'] != "garcons@gravadorpub.com.br" and $_SESSION['email'] != "gravadorpub@gmail.com") {
    header('Location: home.php');
    exit();
}
