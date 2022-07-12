<?php

include('verifica_admin.php');
include('conexao.php');

$sql = "select * from produtos where (nomearq='" . $_POST['arq'] . "')";
$resultado = $con->query($sql);

$sql2 = "select * from vitrine where (nomearq='" . $_POST['arq'] . "') limit 1";
$resultado2 = $con->query($sql2);

function deleteDir($dirPath) {
    if (!is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
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
        $str_del = "DELETE FROM produtos WHERE (nomearq='" . $_POST['arq'] . "')";
        $result1 = mysqli_query($con, $str_del) or die(mysql_error());
    }
}

if ($resultado2->num_rows > 0) {
    while ($row = $resultado2->fetch_assoc()) {
        deleteDir('img/loja/' . $row['nome']);
        unlink('loja/' . $row['nomearq'] . '.php');
        $str_del3 = "DELETE FROM compras WHERE (nomearq='" . $_POST['arq'] . "')";
        $result3 = mysqli_query($con, $str_del3) or die(mysql_error());
        $str_del2 = "DELETE FROM vitrine WHERE (nomearq='" . $_POST['arq'] . "')";
        $result2 = mysqli_query($con, $str_del2) or die(mysql_error());
        $_SESSION['produto_apagado'] = true;
    }
}

$con->close();

header('Location: apagarprodutos.php');
exit();
