<?php
session_start();
include('verifica_admin.php');
require('conexao.php');

$sql = "TRUNCATE TABLE pedidos";

$con->query($sql);

$sql = "TRUNCATE TABLE item_pedido";

$con->query($sql);

$sql = "ALTER TABLE tablename AUTO_INCREMENT = 0";

$con->query($sql);

$_SESSION['pedidos_resetados'] = true;
echo "<script>window.location.replace('https://gravadorpub.com.br/administrador.php');</script>";

?>