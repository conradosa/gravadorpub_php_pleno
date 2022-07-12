<?php

include('verifica_admin.php');
include('conexao.php');

$sql = "select * from destaques where (id=" . $_POST['id'] . ") limit 1";
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
        deleteDir('img/destaques/' . $row['titulo']);
        $str_del = "DELETE FROM destaques WHERE (id=" . $_POST['id'] . ")";
        $con->query($str_del);
        $_SESSION['dest_apagado'] = true;
    }
}

$con->close();

header('Location: apagardestaques.php');
exit();
