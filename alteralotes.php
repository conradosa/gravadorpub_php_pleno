<?php

include('verifica_admin.php');
include('conexao.php');

$id = $_POST['id'];
$titulo = $_POST['titulo']; 
$valor = $_POST['valor']; 
$qtd = $_POST['qtd'];
$hora = $_POST['hora'];
$data = date('Y-m-d', strtotime($_POST['data']));

$sql = "select * from lote where id = '$id' limit 1";
$resultado = $con->query($sql);

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $sql = "UPDATE lote SET titulo = '$titulo', valor = '$valor', qtd_ing = '$qtd', data_lote = '$data', hora_lote = '$hora' WHERE id = '$id'";
        $con->query($sql);
        $_SESSION['lote_alterado'] = true;
    }
}

$con->close();

header('Location: editaeventos.php');
exit();
