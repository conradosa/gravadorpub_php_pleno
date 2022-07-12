<?php
include('verifica_admin.php');
include('conexao.php');
$qtd = $_POST['qtd'];
$id = $_POST['id'];
$sql = "UPDATE produtos SET qtd='$qtd' WHERE id = '$id'";
if ($con->query($sql)) {
    $_SESSION['estoque_alterado'] = true;
    header('Location: atualizarqtd.php');
    exit();
} else {
    $_SESSION['estoque_erro'] = true;
    header('Location: atualizarqtd.php');
    exit();
}
  