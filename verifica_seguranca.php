<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: home.php');
    exit();
}
if ($_SESSION['email'] != "seguranca@gravadorpub.com.br") {
    header('Location: home.php');
    exit();
}
