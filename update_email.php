<?php
session_start();
include('verifica_se_nao_logado.php');
include('conexao.php');

if (empty($_POST['email'])) {
    header('Location: home.php');
    exit();
}

$email = mysqli_real_escape_string($con, trim($_POST['email']));

$sql = "select count(*) as total from usuario where email = '$email'";

$r = mysqli_query($con, $sql);

$row = mysqli_fetch_assoc($r);

if($row['total'] >= 1){
    $_SESSION['email_existe'] = true;
    header('Location: minhaconta.php');
    exit();
}

$sql_up = "UPDATE usuario SET validado = '0' WHERE token = '{$_SESSION['token']}'";

$con->query($sql_up);

$sql_insert = "UPDATE usuario SET email = '$email' WHERE email = '{$_SESSION['email']}'";

if($con->query($sql_insert) === true){
    $_SESSION['email'] = $email;
    $_SESSION['validado'] = 0;
    $_SESSION['sucesso_update_email'] = true;    
}

$con->close();

header('Location: reenvio.php');
exit();