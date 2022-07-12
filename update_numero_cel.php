<?php

session_start();
include('verifica_se_nao_logado.php');
include('conexao.php');

if (empty($_POST['cel'])) {
    header('Location: home.php');
    exit();
}

$cel = mysqli_real_escape_string($con, trim($_POST['cel']));

$sql = "select count(*) as total from usuario where celular = '$cel'";

$r = mysqli_query($con, $sql);

$row = mysqli_fetch_assoc($r);

if ($row['total'] >= 1) {
    $_SESSION['cel_existe'] = true;
    header('Location: minhaconta.php');
    exit();
}

$sql_insert = "UPDATE usuario SET celular = '$cel' WHERE email = '{$_SESSION['email']}'";

if ($con->query($sql_insert) === true) {
    $_SESSION['cel'] = $cel;
    $_SESSION['sucesso_update_cel'] = true;
}

$con->close();

header('Location: minhaconta.php');
exit();
