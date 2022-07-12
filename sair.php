<?php
session_start();
unset($_SESSION['email']);
unset($_SESSION['nome']);
unset($_SESSION['cel']);
unset($_SESSION['nome_completo']);
header('Location: home.php');
exit();