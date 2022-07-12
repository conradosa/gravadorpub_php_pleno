<?php

session_start();
header("access-control-allow-origin: https://pagseguro.uol.com.br");
header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");
include('conexao.php');
require_once("PagSeguro.class.php");

if (isset($_POST['notificationType']) && $_POST['notificationType'] == 'transaction') {
    $PagSeguro = new PagSeguro();
    $notificationCode = $_POST['notificationCode'];
    $r = $PagSeguro->executeNotification($_POST);

    if ($r == 3 || $r == 4) {
        $status = "Pago";
        $sql_insert = "INSERT INTO transacao (codigo, nome, estado, data_transacao) VALUES ('$notificationCode', 'nome', '$status', NOW()) ON DUPLICATE KEY UPDATE estado = VALUES(estado), data_transacao = VALUES(data_transacao)";

        if ($con->query($sql_insert) === true) {
            $_SESSION['sucesso_transacao'] = true;
        }
        $con->close();
    } else {
        $status = "Aguardando Pagamento";
        $sql_insert = "INSERT INTO transacao (codigo, nome, estado, data_transacao) VALUES ('$notificationCode', 'nome', '$r', NOW()) ON DUPLICATE KEY UPDATE estado = VALUES(estado), data_transacao = VALUES(data_transacao)";

        if ($con->query($sql_insert) === true) {
            $_SESSION['sucesso_transacao'] = true;
        }
        $con->close();
    }
} else {
    $status = "NADA";
    $sql_insert = "INSERT INTO transacao (codigo, nome, estado, data_transacao) VALUES ('123', 'nome', '$status', NOW()) ON DUPLICATE KEY UPDATE estado = VALUES(estado), data_transacao = VALUES(data_transacao)";

    if ($con->query($sql_insert) === true) {
        $_SESSION['sucesso_transacao'] = true;
    }
    $con->close();
}