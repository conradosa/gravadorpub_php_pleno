<?php

include('verifica_admin.php');
include('conexao.php');

$sql = "select * from lote where (id=" . $_POST['id'] . ") limit 1";
$resultado = $con->query($sql);

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $str_del = "DELETE FROM lote WHERE (id=" . $_POST['id'] . ")";
        $con->query($str_del);
        $_SESSION['lote_apagado'] = true;
    }
}

$con->close();

header('Location: editaeventos.php');
exit();
