<?php

include('verifica_admin.php');
include('conexao.php');

$id = $_POST['id'];
$qtd = $_POST['qtd'];

$sql = "select * from evento where id = '$id' limit 1";
$resultado = $con->query($sql);

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $sql = "UPDATE evento SET qtd_ing = '$qtd' WHERE id = '$id'";
        $con->query($sql);
        $_SESSION['evento_alterado'] = true;
    }
}

$con->close();

header('Location: alterarqtding.php');
exit();
