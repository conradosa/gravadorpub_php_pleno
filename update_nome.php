<?php
session_start();
include('verifica_se_nao_logado.php');
include('conexao.php');

if (empty($_POST['nome'])) {
    header('Location: home.php');
    exit();
}

$nome = mysqli_real_escape_string($con, trim($_POST['nome']));

$nome1 = explode(' ',trim($nome));

$sql_insert = "UPDATE usuario SET nome = '$nome' WHERE email = '{$_SESSION['email']}'";

if($con->query($sql_insert) === true){
    $_SESSION['nome'] = $nome1[0];
    $_SESSION['nome_completo'] = $nome;
    $_SESSION['sucesso_update_nome'] = true;    
}

$con->close();

header('Location: minhaconta.php');
exit();