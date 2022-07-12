<?php
session_start();
include('verifica_se_nao_logado.php');
include('conexao.php');

if (empty($_POST['senha'])) {
    header('Location: home.php');
    exit();
}

$senha = mysqli_real_escape_string($con, trim(hash('sha256', $_POST['senha'])));

$sql_insert = "UPDATE usuario SET senha = '$senha' WHERE email = '{$_SESSION['email']}'";

if($con->query($sql_insert) === true){
    $_SESSION['sucesso_update_senha'] = true;    
}

$con->close();

header('Location: minhaconta.php');
exit();