<?php

include('verifica_admin.php');
include('conexao.php');

$sql = "select * from evento where (id=" . $_POST['id'] . ") limit 1";
$resultado = $con->query($sql);

function deleteDir($dirPath) {
    if (!is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath precisa ser um diretorio");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            deleteDir($file);
        } else {
            unlink($file);
        }
    }
    rmdir($dirPath);
}

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        deleteDir('img/eventos/' . $row['pastaimg']);
        unlink('eventos/' . $row['nomearqedit'] . '.php');
        $str_del4 = "DELETE FROM compras WHERE nomearq='{$row['nomearq']}'";
        $con->query($str_del4);
        $str_del3 = "DELETE FROM transacao WHERE nomearq='{$row['nomearq']}'";
        $con->query($str_del3);
        $str_del2 = "DELETE FROM lote WHERE nomearq='{$row['nomearq']}'";
        $con->query($str_del2);
        $str_del = "DELETE FROM evento WHERE (id=" . $_POST['id'] . ")";
        $con->query($str_del);
        $_SESSION['evento_apagado'] = true;
    }
}
$sql2 = "select * from ingressos where nome_evento = '" . $_POST['nome'] . "'";
$resultado2 = $con->query($sql2);

if ($resultado2->num_rows > 0) {
    while ($row = $resultado2->fetch_assoc()) {
        unlink('qrcodes/' . $row['arq_qrcode']);
    }
    $sql3 = "DELETE FROM ingressos where nome_evento = '" . $_POST['nome'] . "'";
    $con->query($sql3);
}

$con->close();

header('Location: apagareventos.php');
exit();
