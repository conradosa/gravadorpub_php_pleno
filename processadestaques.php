<?php
include('verifica_admin.php');
require('conexao.php');

$titulo = trim($_POST["titulo"]);
if (isset($_POST["link"])) {
    $link = trim($_POST["link"]);
} else {
    $link = "";
}
$desccur = trim($_POST["desccur"]);

$cont1 = 0;
if (mkdir("img/destaques/" . $titulo, 0777, true)) {
    $foto = $_FILES["img"];
    $target_dir = "img/destaques/" . $titulo . '/';
    $target_file = $target_dir . basename($foto["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if (file_exists("img/destaques/" . $titulo . '/' . $target_file)) {
        $_SESSION['arqfoto_existe'] = true;
        $uploadOk = 0;
    }
    $check = getimagesize($foto["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $_SESSION['arqfoto_nimg'] = true;
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        $_SESSION['arqfoto_erro'] = true;
    } else {
        if (move_uploaded_file($foto["tmp_name"], $target_file)) {
            $_SESSION['arqfoto_sucesso'] = true;
        } else {
            $_SESSION['arqfoto_erro'] = true;
        }
    }

    $imgdir = $target_file;

    $sql_insert = "INSERT INTO destaques (link, titulo, desc_cur, imgdir) VALUES ('$link', '$titulo', '$desccur', '$imgdir')";
    if ($con->query($sql_insert)) {
        $_SESSION['dest_insert'] = true;
    }
} else {
    $_SESSION['mkdir_erro'] = true;
}

if (isset($_SESSION['dest_insert']) and isset($_SESSION['arqfoto_sucesso']) and!isset($_SESSION['arqfoto_erro']) and!isset($_SESSION['mkdir_erro'])) {
    $_SESSION['ds_criado'] = true;
    header('Location: criardestaques.php');
    exit();
} else {
    $_SESSION['ds_criado_erro'] = true;
    header('Location: criardestaques.php');
    exit();
}