<?php
include('verifica_admin.php');
require('conexao.php');

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

$id = trim($_POST["id"]);
$nomeevento = trim($_POST["nomeevento"]);
$data_e = date('Y-m-d', strtotime($_POST["dataevento"]));
$datacrua = $data_e;
$data_a = explode("-",$data_e);
$dataevento = $data_a[2] . "/" . $data_a[1] . "/" . $data_a[0];
$horaevento = trim($_POST["horaevento"]);
$descevento = trim($_POST["descevento"]);
$dia = strftime('%d', strtotime($_POST["dataevento"]));
$mes = strftime('%B', strtotime($_POST["dataevento"]));
$desccur = trim($_POST["desccur"]);
$abertura = trim($_POST["abertura"]);
$qtdfotos = trim($_POST["qtdfotos"]);
$textoini = trim($_POST["textoini"]);
$link = trim($_POST["link"]);
$nteming = $_POST['nteming'];
$entfranca = $_POST['entfranca'];
$data_m = $_POST['data_m'];
$date1 = $data_e;
$date2 = $data_e;
$dia2 = $dia;

$data_evento = $dataevento . " " . $horaevento;

if(isset($data_m)){
    $date1 = date('Y-m-d', strtotime($_POST["data1"]));
    $date2 = date('Y-m-d', strtotime($_POST["data2"]));
    $datacrua = $date2;
    $dia = strftime('%d', strtotime($_POST["data1"]));
    $dia2 = strftime('%d', strtotime($_POST["data2"]));
    $abertura = trim($_POST["abertura2"]);
    $data_evento = "De ".$dia." a ".$dia2." de ".$mes." às ".$horaevento;
}else{
    $data_m = 0;
}

$nomearqedit = $_POST['nomearqedit'];

$sql = "select * from evento WHERE id = '$id' limit 1";

$resultado = $con->query($sql);

if ($resultado->num_rows > 0) {
while ($row = $resultado->fetch_assoc()) {
        $titulo = $row["titulo"];
        $nomearqold = $row["nomearqedit"];
        $pastaimg = $row["pastaimg"];
    }
}

if($nomearqold != $nomearqedit){
    
    $sql_nome = "select count(*) as total from evento where nomearq = '$nomearqedit'";

    $r_nome = mysqli_query($con, $sql_nome);
    
    $row_nome = mysqli_fetch_assoc($r_nome);
    
    if ($row_nome['total'] >= 1) {
        $_SESSION['nomearq_existe'] = true;
        header('Location: editaeventos.php');
        exit();
    }
    
    $sql_nome = "select count(*) as total from evento where nomearqedit = '$nomearqedit'";

    $r_nome = mysqli_query($con, $sql_nome);
    
    $row_nome = mysqli_fetch_assoc($r_nome);
    
    if ($row_nome['total'] >= 1) {
        $_SESSION['nomearq_existe'] = true;
        header('Location: editaeventos.php');
        exit();
    }
    
}

rename("eventos/".$nomearqold.".php", "eventos/".$nomearqedit.".php");

$newurl = "eventos/".$nomearqedit.".php";

$desccur = preg_replace("#\'#", '’', $desccur);
$nomeevento = preg_replace("#\'#", '’', $nomeevento);
$descevento = preg_replace("#\'#", '’', $descevento);
$textoini = preg_replace("#\'#", '’', $textoini);
$abertura = preg_replace("#\'#", '’', $abertura);
$horaevento = preg_replace("#\'#", '’', $horaevento);
$dataevento = preg_replace("#\'#", '’', $dataevento);
$precoevento = preg_replace("#\'#", '’', $precoevento);

$desccur = preg_replace('#\"#', '’', $desccur);
$nomeevento = preg_replace('#\"#', '’', $nomeevento);
$descevento = preg_replace('#\"#', '’', $descevento);
$textoini = preg_replace('#\"#', '’', $textoini);
$abertura = preg_replace('#\"#', '’', $abertura);
$horaevento = preg_replace('#\"#', '’', $horaevento);
$dataevento = preg_replace('#\"#', '’', $dataevento);
$precoevento = preg_replace('#\"#', '’', $precoevento);


if ($qtdfotos > 0) {
    $cont1 = 0;
    for ($i = 0; $i < $qtdfotos; $i++) {
        $cont1++;
        $fotos_a[$i] = $_FILES["img" . $cont1];
        $target_dir = "img/eventos/" . $pastaimg . '/';
        $foto = $fotos_a[$i];
        $target_file = $target_dir . basename($foto["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($foto["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $_SESSION['arqfoto_nimg'] = true;
            $uploadOk = 0;
        }
        if($imageFileType != 'jpg'){
            $_SESSION['jpg_erro'] = true;
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            $_SESSION['arqfoto_erro'] = true;
        } else {
            for ($y = 0; $y < $qtdfotos; $y++) {
                unlink("img/eventos/". $pastaimg . "/" . "foto" . $i . ".jpg");
            }
            move_uploaded_file($foto["tmp_name"], $target_file);
            $_SESSION['arqfoto_sucesso'] = true;
            rename($target_file , "img/eventos/" . $pastaimg . '/' . "foto". $i . "." . $imageFileType);
        }
    }
}

    if($_FILES["imgq"]['size'] != 0){
        $imgq = $_FILES["imgq"];
        $target_dir = "img/eventos/" . $pastaimg . '/';
        $target_file = $target_dir . basename($imgq["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($imgq["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $_SESSION['arqfoto_nimg'] = true;
            $uploadOk = 0;
        }
        if($imageFileType != 'jpg'){
                $_SESSION['jpg_erro'] = true;
                $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            $_SESSION['arqfoto_erro'] = true;
        } else {
            unlink("img/eventos/". $pastaimg . "/" . "fotocapa.jpg");
            if (move_uploaded_file($imgq["tmp_name"], $target_file)) {
                $_SESSION['arqfoto_sucesso'] = true;
                rename($target_file , "img/eventos/" . $pastaimg . '/' . "fotocapa.jpg");
            } else {
                $_SESSION['arqfoto_erro'] = true;
            }
        }
    }
    
    if($_SESSION['arqfoto_erro'] == false or !isset($_SESSION['arqfoto_erro'])){
        if($_POST["qtdfotos"] == ""){
        $sql_update = "UPDATE evento SET tituloevento = '$nomeevento', data = '$dataevento', datacrua = '$datacrua', mes = '$mes', dia = '$dia', dia2 = '$dia2', date1 = '$date1', date2 = '$date2', data_mult = '$data_m', abertura = '$abertura', inicio = '$textoini', hora = '$horaevento', nteming = '$nteming', entfranca = '$entfranca', link = '$link', descricao = '$descevento', desc_cur = '$desccur', data_evento = '$data_evento', nomearqedit = '$nomearqedit', url = '$newurl' WHERE id = '$id'";
        }else{
        $sql_update = "UPDATE evento SET tituloevento = '$nomeevento', data = '$dataevento', datacrua = '$datacrua', mes = '$mes', dia = '$dia', dia2 = '$dia2', date1 = '$date1', date2 = '$date2', data_mult = '$data_m', abertura = '$abertura', inicio = '$textoini', hora = '$horaevento', nteming = '$nteming', entfranca = '$entfranca', link = '$link', descricao = '$descevento', desc_cur = '$desccur', data_evento = '$data_evento', qtdfotos = '$qtdfotos', nomearqedit = '$nomearqedit', url = '$newurl' WHERE id = '$id'";
        }  

        if ($con->query($sql_update)) {
            $_SESSION['evento_editado'] = true;
            header('Location: editaeventos.php');
            exit();
        }else{
            $_SESSION['evento_editado_erro'] = true;
            header('Location: editaeventos.php');
            exit();
        }
    }else{
         header('Location: editaeventos.php');
         exit();
    }