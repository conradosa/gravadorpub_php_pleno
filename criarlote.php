<?php
include('verifica_admin.php');
require('conexao.php');

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

$nomearq = trim($_POST["nomearq"]);
$qtd_lotes_t = trim($_POST["qtd_lotes"]);
if($qtd_lotes_t == ""){
    $qtd_lotes_t = 0;
}
$nomearq = preg_replace("#\'#", '’', $nomearq);

for ($i = 0; $i < $qtd_lotes_t; $i++) {
    $nomes_lotes[$i] = $_POST["nome_lote" . $i];
    $qtd_lotes[$i] = $_POST["qtd_lote" . $i];
    $valor_lotes[$i] = $_POST["valor_lote" . $i];
    $data_lotes[$i] = date('Y-m-d', strtotime($_POST["data_lote" . $i]));
    $hora_lotes[$i] = $_POST["hora_lote" . $i];
}

if ($qtd_lotes_t != "") {
    for ($i = 0; $i < $qtd_lotes_t; $i++) {
        $sql_insert_l = "INSERT INTO lote (nome, titulo, valor, qtd_ing, data_lote, hora_lote, nomearq) VALUES ('$nomes_lotes[$i]', '$nomes_lotes[$i]', '$valor_lotes[$i]', '$qtd_lotes[$i]', '$data_lotes[$i]', '$hora_lotes[$i]', '$nomearq')";
        if($con->query($sql_insert_l)){
            $_SESSION['lote_criado'] = true;
        }else{
            unset($_SESSION['lote_criado']);
        }
    }
    header('Location: editaeventos.php');
    exit();
}