<?php
include('verifica_admin.php');
require('conexao.php');

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

$nomeevento = trim($_POST["nomeevento"]);
$data_e = date('Y-m-d', strtotime($_POST["dataevento"]));
$datacrua = $data_e;
$pastaimg = $nomeevento.$datacrua;
$date1 = $data_e;
$date2 = $data_e;
$data_a = explode("-",$data_e);
$dataevento = $data_a[2] . "/" . $data_a[1] . "/" . $data_a[0];   
$horaevento = trim($_POST["horaevento"]);
$descevento = trim($_POST["descevento"]);
$nomearq = trim($_POST["nomearq"]);
$nomepg = $nomearq . ".php";
$qtdfotos = trim($_POST["qtdfotos"]);
$dia = strftime('%d', strtotime($_POST["dataevento"]));
$dia2 = $dia;
$mes = strftime('%B', strtotime($_POST["dataevento"]));
$mes = str_replace("ç", "c", $mes);
$desccur = trim($_POST["desccur"]);
$abertura = trim($_POST["abertura"]);
$textoini = trim($_POST["textoini"]);
$link = trim($_POST["link"]);
$nteming_v = $_POST["nteming"];
$entfranca_v = $_POST["entfranca"];
$datas_mult = $_POST["data_m"];

$data_evento = $dataevento . " " . $horaevento;

if(isset($datas_mult)){
    $datas_mult = 1;
    $data1 = date('Y-m-d', strtotime($_POST["data1"]));
    $data2 = date('Y-m-d', strtotime($_POST["data2"]));
    $datacrua = $data2;
    $date2 = $data2;
    $dia2 = strftime('%d', strtotime($_POST["data2"]));
    $abertura = trim($_POST["abertura2"]);
    $data_evento = "De ".$dia." a ".$dia2." de ".$mes." às ".$horaevento;
}else{
    $datas_mult = 0;
}

if(isset($nteming_v)){
    $nteming_v = 1;
}else{
    $nteming_v = 0;
}

if(isset($entfranca_v)){
    $entfranca_v = 1;
    $nteming_v = 1;
}else{
    $entfranca_v = 0;
}

$qtd_lotes_t = trim($_POST["qtd_lotes"]);
if($qtd_lotes_t == ""){
    $qtd_lotes_t = 0;
    $inputslotes = [];
    $arraylotes = [];
    $lotsjs = [];
    $lotsjs_t = [];
    $arraylotes_t = [];
    $arrayings = [];
}

$divlotes = "";

$nomearq = preg_replace("#\'#", '’', $nomearq);
$desccur = preg_replace("#\'#", '’', $desccur);
$nomeevento = preg_replace("#\'#", '’', $nomeevento);
$descevento = preg_replace("#\'#", '’', $descevento);
$textoini = preg_replace("#\'#", '’', $textoini);
$abertura = preg_replace("#\'#", '’', $abertura);
$horaevento = preg_replace("#\'#", '’', $horaevento);

$nomearq = preg_replace('#\"#', '’', $nomearq);
$desccur = preg_replace('#\"#', '’', $desccur);
$nomeevento = preg_replace('#\"#', '’', $nomeevento);
$descevento = preg_replace('#\"#', '’', $descevento);
$textoini = preg_replace('#\"#', '’', $textoini);
$abertura = preg_replace('#\"#', '’', $abertura);
$horaevento = preg_replace('#\"#', '’', $horaevento);

$_SESSION['nomearq_f'] = $nomearq;
$_SESSION['titulo_f'] = $nomeevento;
$_SESSION['data1_f'] = $date1;
$_SESSION['data2_f'] = $data2;
$_SESSION['abertura_f'] = $abertura;
$_SESSION['textoini_f'] = $textoini;
$_SESSION['horaevento_f'] = $horaevento;
$_SESSION['youtube_f'] = $link;
$_SESSION['desc_f'] = $descevento;
$_SESSION['desccur_f'] = $desccur;

for ($i = 0; $i < $qtd_lotes_t; $i++) {
    $nomes_lotes[$i] = $_POST["nome_lote" . $i];
    $qtd_lotes[$i] = $_POST["qtd_lote" . $i];
    $valor_lotes[$i] = $_POST["valor_lote" . $i];
    $data_lotes[$i] = date('Y-m-d', strtotime($_POST["data_lote" . $i]));
    $hora_lotes[$i] = $_POST["hora_lote" . $i];
}

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

$sql_nome = "select count(*) as total from evento where nomearq = '$nomearq'";

$r_nome = mysqli_query($con, $sql_nome);

$row_nome = mysqli_fetch_assoc($r_nome);

if ($row_nome['total'] >= 1) {
    $_SESSION['nomearq_existe'] = true;
    header('Location: criareventos.php');
    exit();
}

$sql_nome = "select count(*) as total from evento where nomearqedit = '$nomearq'";

$r_nome = mysqli_query($con, $sql_nome);

$row_nome = mysqli_fetch_assoc($r_nome);

if ($row_nome['total'] >= 1) {
    $_SESSION['nomearq_existe'] = true;
    header('Location: criareventos.php');
    exit();
}

$sql_tu = "select count(*) as total from evento where pastaimg = '$pastaimg'";

$r_tu = mysqli_query($con, $sql_tu);

$row_tu = mysqli_fetch_assoc($r_tu);

if ($row_tu['total'] >= 1) {
    $_SESSION['nomearq_existe'] = true;
    header('Location: criareventos.php');
    exit();
}

function printArray($a) {
    return implode("", $a);
}

$cont1 = 0;
if (mkdir("img/eventos/" . $pastaimg, 0777, true)) {
    for ($i = 0; $i < $qtdfotos; $i++) {
        $cont1++;
        $fotos_a[$i] = $_FILES["img" . $cont1];
        $target_dir = "img/eventos/" . $pastaimg . '/';
        $target_file = $target_dir . basename($fotos_a[$i]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($fotos_a[$i]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }
        if($imageFileType != 'jpg'){
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            $_SESSION['arqfoto_erro'] = true;
        } else {
            if (move_uploaded_file($fotos_a[$i]["tmp_name"], $target_file)) {
                $_SESSION['arqfoto_sucesso'] = true;
                rename($target_file , "img/eventos/" . $pastaimg . '/' . "foto". $i . "." . $imageFileType);
            } else {
                $_SESSION['arqfoto_erro'] = true;
            }
        }
    }
    $imgq = $_FILES["imgq"];
    $target_dir = "img/eventos/" . $pastaimg . '/';
    $target_file = $target_dir . basename($imgq["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $check = getimagesize($imgq["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }
    if($imageFileType != 'jpg'){
            $_SESSION['jpg_erro'] = true;
            $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        $_SESSION['arqfoto_erro'] = true;
    } else {
        if (move_uploaded_file($imgq["tmp_name"], $target_file)) {
            $_SESSION['arqfoto_sucesso'] = true;
            rename($target_file , "img/eventos/" . $pastaimg . '/' . "fotocapa.jpg");
        } else {
            $_SESSION['arqfoto_erro'] = true;
        }
    }

    $imgdir = $target_dir . "fotocapa.jpg";
    $url_evento = "eventos/" . $nomepg;
    if(!isset($_SESSION['arqfoto_erro'])){
    $sql_insert = "INSERT INTO evento (dia, dia2, mes, titulo, tituloevento, data_evento, desc_cur, descricao, data, datacrua, date1, date2, abertura, inicio, hora, nteming, entfranca, data_mult, link, url, nomearq, nomearqedit, imgdir, qtdfotos, pastaimg) VALUES ('$dia', '$dia2', '$mes', '$nomeevento', '$nomeevento', '$data_evento', '$desccur', '$descevento', '$dataevento', '$datacrua', '$date1', '$date2', '$abertura', '$textoini', '$horaevento', '$nteming_v', '$entfranca_v', '$datas_mult', '$link', '$url_evento', '$nomearq', '$nomearq', '$imgdir', '$qtdfotos', '$pastaimg')";
    if ($con->query($sql_insert)) {
        $_SESSION['evento_insert'] = true;
    }
    }else{
        
    }
} else {
    $_SESSION['mkdir_erro'] = true;
}

if (isset($_SESSION['evento_insert']) and $qtd_lotes_t != "") {
    for ($i = 0; $i < $qtd_lotes_t; $i++) {
        $sql_insert_l = "INSERT INTO lote (nome, titulo, valor, qtd_ing, data_lote, hora_lote, nomearq) VALUES ('$nomes_lotes[$i]', '$nomes_lotes[$i]', '$valor_lotes[$i]', '$qtd_lotes[$i]', '$data_lotes[$i]', '$hora_lotes[$i]', '$nomearq')";
        $con->query($sql_insert_l);
    }
}

$y = '$y';

$pg = '<?php session_start(); ?>
<?php $_SESSION["pg_atual"] = "eventos/' . $nomepg . '"' . '; ?>   
<?php include_once("../PagSeguroLibrary/PagSeguroLibrary.php"); ?>
<?php include("../conexao.php"); ?> 
<?php date_default_timezone_set(\'Brazil/East\'); ?>
<?php
    $datas = [];
    $dia = false;
    $sql = "select * from lote WHERE nomearq = \''.$nomearq.'\'";

        $resultado = $con->query($sql);

        if ($resultado->num_rows > 0) {
            $i = 0;
            while ($row = $resultado->fetch_assoc()) {                                                       
                $datas[$i] = $row["data_lote"];
                $horas[$i] = $row["hora_lote"];
                if($datas[$i] <= date("Y-m-d") and $horas[$i] < date("H:i:s")){
                        $diaf[$i] = true;
                        
                        $sql_insert_l = "UPDATE lote SET qtd_ing = 0 WHERE nome=\'{$row["nome"]}\' AND nomearq = \''.$nomearq.'\'";
                        $con->query($sql_insert_l);
                        
                        }else{
                            $diaf[$i] = false;
                        }
                $i++;
            }
        }
        
    $sql = "select link from evento WHERE nomearq = \'' . $nomearq . '\' limit 1";

    $resultado = $con->query($sql);

    if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
            parse_str(parse_url($row["link"], PHP_URL_QUERY), $array);
            if ($row["link"] != "") {
            $ytb = \'<br><br>
                <li class="row">
                    <div class="col">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/\' . $array[\'v\'] . \'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </li>\';
            } else {
                $ytb = \'\';
            }
        }
    }
    
    $sql = "select * from evento WHERE nomearq = \'' . $nomearq . '\' limit 1";

    $resultado = $con->query($sql);

    if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
            $nteming = $row["nteming"];
            $entfranca = $row["entfranca"];
            $datacrua = $row["datacrua"];
            $data_m = $row["data_mult"];
            $dia = $row["dia"];
            $dia2 = $row["dia2"];
            $mes_s = $row["mes"];
        }
    }
    
    if($entfranca == 1){
    $entfranca_s = \'<li class="row">
                        <div class="col">
                            <span class="custom-icon-minus"><span class="sr-only">&nbsp;</span></span>
                            <span style="color: red;" class="text title">Entrada Franca</span>
                        </div>
                    </li>\';    
    }else{
        $entfranca_s = "";
    }
    
    if($datacrua < date("Y-m-d")){
    $sql_update = "UPDATE evento SET nteming = \'1\' WHERE nomearq = \'' . $nomearq . '\'";
    $con->query($sql_update);
    }
    
    if($nteming == 1){
    $ings_s2_3 = "";
    $arrayings = [\'\'];
}else{
    $ings_s1_log = \'<li class="row">
                    <div class="col">
                        <span class="custom-icon-link2"><span class="sr-only">&nbsp;</span></span>
                        <span class="text title">Compre agora:</span>
                    </div>
                    <div class="col">
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal">
                                Clique Aqui!
                            </button>
                    </div>
                </li>
                <br>
                <li class="row">
                    <div class="col">
                        <span><span class="sr-only">&nbsp;</span></span>
                        <span class="text title">Ingressos Disponíveis:</span>
                    </div>
                </li>\';
    $ings_s1_nlog = \'<li class="row">
                    <div class="col">
                        <span class="custom-icon-link2"><span class="sr-only">&nbsp;</span></span>
                        <span class="text title">Compre agora:</span>
                    </div>
                    <div class="col">
                            <form method="POST">
                                <input data-toggle="modal" data-target="#modal" type="submit" name="pagar" value="Clique Aqui!" class="btn btn-sm btn-primary">
                            </form>
                    </div>
                </li>
                <br>
                <li class="row">
                    <div class="col">
                        <span><span class="sr-only">&nbsp;</span></span>
                        <span class="text title">Ingressos Disponíveis:</span>
                    </div>
                </li>\';
                    
            $sql0 = "select * from lote WHERE nomearq = \'' . $nomearq . '\'";
    
            $resultado0 = $con->query($sql0);
    
            if ($resultado0->num_rows > 0) {
            
            $ings_s2_3 = \'</li>
                        <li class="row">
                            <div class="col">
                                <span>*Ingressos enviados para o E-MAIL cadastrado</span>
                            </div>
                        </li>
                         <li class="row">
                            <div class="col">
                                <span>*Lotes disponíveis por tempo LIMITADO</span>
                            </div>
                        </li>\'; 
            
            }
                        
    }

?>

<!DOCTYPE html>
<html lang="pt-BR">

    <style>
        .link{
            background: none!important;
            border: none;
            padding: 0!important;
            color: #7592a4;
            cursor: pointer;
        }
    </style>    

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta property="og:image" content="https://gravadorpub.com.br/img/eventos/'.$pastaimg.'/fotocapa.jpg" />
        <meta name="description" content="'.$descevento.'">
        <title><?php
                    $sqltit = "select tituloevento from evento WHERE nomearq = \'' . $nomearq . '\' limit 1";

                    $resultadotit = $con->query($sqltit);

                    if ($resultadotit->num_rows > 0) {
                    while ($rowtit = $resultadotit->fetch_assoc()) {
                            echo $rowtit["tituloevento"];
                        }
                    }
                ?></title>
        <link rel="shortcut icon" href="../img/gravador.gif" >
        <link media="all" rel="stylesheet" href="../css/fonts/icomoon/icomoon.css">
        <link media="all" rel="stylesheet" href="../css/fonts/roxine-font-icon/roxine-font.css">
        <link media="all" rel="stylesheet" href="../vendors/font-awesome/css/font-awesome.css">
        <link media="all" rel="stylesheet" href="../vendors/owl-carousel/dist/assets/owl.carousel.min.css">
        <link media="all" rel="stylesheet" href="../vendors/owl-carousel/dist/assets/owl.theme.default.min.css">
        <link media="all" rel="stylesheet" href="../vendors/animate/animate.css">
        <link media="all" rel="stylesheet" href="../vendors/rateyo/jquery.rateyo.css">
        <link media="all" rel="stylesheet" href="../vendors/bootstrap-datepicker/css/bootstrap-datepicker.css">
        <link media="all" rel="stylesheet" href="../vendors/fancyBox/source/jquery.fancybox.css">
        <link media="all" rel="stylesheet" href="../vendors/fancyBox/source/helpers/jquery.fancybox-thumbs.css">
        <link media="all" rel="stylesheet" href="../css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="../vendors/rev-slider/revolution/css/settings.css">
        <link rel="stylesheet" type="text/css" href="../vendors/rev-slider/revolution/css/layers.css">
        <link rel="stylesheet" type="text/css" href="../vendors/rev-slider/revolution/css/navigation.css">
        <link media="all" rel="stylesheet" href="../css/main.css">
        <link href="../css/css.css" rel="stylesheet" type="text/css"/>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="sweetalert2.all.min.js"></script>
    </head>

    <body>

        <?php
        if (isset($_SESSION["reenvio"])) {
            ?>
            <script>
                Swal.fire({
                    confirmButtonColor: "#7592a4",
                    title: "Atenção!",
                    html: "E-mail de confirmação reenviado!<br><br><b>confirme seu e-mail!</b>",
                    icon: "info",
                    type: "info"
                });
            </script>
            <?php
            unset($_SESSION["reenvio"]);
        }
        ?>      

    <center>
        <div class="preloader" id="pageLoad">
            <div class="holder">
                <img width="300" height="300" alt="Carregamento Página" src="../img/load/gravador.gif">
            </div>
        </div>
    </center>
    
    <script>
        var lots = []; 
        var num_lots = 0;
        var lots_t = [];
    </script>
    
    <?php
        $sql = "select * from lote WHERE nomearq = \'' . $nomearq . '\'";

        $resultado = $con->query($sql);

        if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {

            if($row["qtd_ing"] <= 0){
                $string = $row["titulo"].": ESGOTADO";
            }else{
                $string = $row["titulo"] .": R$". $row["valor"];
            }
            
            $lotesn = $row["nome"];
            
            $numlotes++; 
            
            echo \'<script> lots.push("\'. $string .\'");</script>\';
            echo \'<script> lots_t.push("\'. $lotesn .\'");</script>\';
            
            
            }
            
            echo \'<script> num_lots = "\'. $numlotes .\'";</script>\';
            
        }
    ?>
    
    <script>
        function pesq() {
            if (document.getElementById("pesq2").classList.contains("pc")) {
                document.getElementById("pesq2").classList.remove("pc");
                document.getElementById("pesq2").classList.add("cel");
            } else {
                document.getElementById("pesq2").classList.remove("cel");
                document.getElementById("pesq2").classList.add("pc");
            }
        }
        
        function pesq1() {
                if (document.getElementById("pesq2").classList.contains("cel")) {
                    document.getElementById("pesq2").classList.remove("cel");
                    document.getElementById("pesq2").classList.add("pc");
                } 
            }
            
            document.getElementById("brP").style.display = "none";    

    </script>

    <div id="wrapper">
        <div class="page-wrapper">
            <header class="fixed-top main-header header-white no-top-header" id="waituk-main-header">
                <div id="nav-section">
                    <div class="bottom-header container-fluid mega-menus" id="mega-menus">
                        <nav class="navbar navbar-toggleable-md no-border-radius no-margin mega-menu-multiple" id="navbar-inner-container">
                             <?php include(\'../menu2.php\'); ?>                         
                        </nav>
                    </div>
                </div>
                <div id="pesq2" class="pesquisa2 pc">
                    <form action="../pesquisa.php">
                        <select required class="sel inputform" name="tipo">
                            <option class="inputform" value="evento">Shows</option>
                            <option class="inputform" value="produtos">Loja</option>
                        </select>
                        <input class="txt inputform" name="txt_pesq" placeholder="Pesquisar" type="text">
                        <input style="display:none;" type="submit" class="sub inputform" value="Ok">                                   
                    </form>
                </div> 
            </header>
            <main class="no-banner">
                <section class="visual visual-sub visual-no-bg">
                    <div class="visual-inner no-overlay bg-gray-light">
                        <div class="centered">
                            <div class="container">
                                <div class="visual-text visual-center">
                                    <h1 class="visual-title visual-sub-title"> 
                                                    <?php
                                                        $sqltit = "select tituloevento from evento WHERE nomearq = \'' . $nomearq . '\' limit 1";

                                                        $resultadotit = $con->query($sqltit);

                                                        if ($resultadotit->num_rows > 0) {
                                                        while ($rowtit = $resultadotit->fetch_assoc()) {
                                                                echo $rowtit["tituloevento"];
                                                            }
                                                        }
                                                    ?>
                                    </h1>
                                    <div class="breadcrumb-block">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="../home.php"> Home </a></li>
                                            <li class="breadcrumb-item"><a href="../agenda/<?php echo $mes; ?>.php"> Agenda </a></li>
                                            <li class="breadcrumb-item active"> ' . $nomearq . ' </li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>              
                <div class="content-wrapper">
                    <section class="content-block">
                        <div class="container">
                            <div class="team-container">
                                <div id="fotosdiv" class="owl-carousel group-slide bottom-m-space">
                                        <?php
                                            $sql = "select qtdfotos from evento WHERE nomearq = \'' . $nomearq . '\' limit 1";
        
                                            $resultado = $con->query($sql);
        
                                            if ($resultado->num_rows > 0) {
                                            while ($row = $resultado->fetch_assoc()) {
                                                    for($y = 0; $y < $row["qtdfotos"]; $y++){
                                                        echo \'<div class="slide-item">
                                                                    <figure class="team-box caption-fade-up">
                                                                        <div class="img-block rev-gray-scale">
                                                                            <img src="../img/eventos/' . $pastaimg . '/' . "foto" . "'. $y .'" . ".jpg" . '" alt="Imagem Evento">
                                                                        </div>                                         
                                                                    </figure>
                                                              </div>\';
                                                    }
                                                }
                                            }
                                        ?>
                                </div>
                            </div>  
                            <div class="portfolio-des top-space">
                                <div class="row">
                                    <div class="col-lg-6 bottom-space-medium-only">
                                        <ul class="content-list info-list">
                                         <?php if($data_m == 0){ ?>
                                            <li class="row">
                                                <div class="col">
                                                    <span class="custom-icon-calendar"><span class="sr-only">&nbsp;</span></span>
                                                    <span class="text title">Data:</span>
                                                </div>
                                                <div class="col">
                                                    <p>
                                                    <?php
                                                        $sql = "select data from evento WHERE nomearq = \'' . $nomearq . '\' limit 1";

                                                        $resultado = $con->query($sql);

                                                        if ($resultado->num_rows > 0) {
                                                        while ($row = $resultado->fetch_assoc()) {
                                                                echo $row["data"];
                                                            }
                                                        }
                                                    ?>
                                                    </p>
                                                </div>
                                            </li>
                                            <?php }else{ ?>
                                            <li class="row">
                                                <div class="col">
                                                    <span class="custom-icon-calendar"><span class="sr-only">&nbsp;</span></span>
                                                    <span class="text title">Data:</span>
                                                </div>
                                                <div class="col">
                                                    <p>De <?php echo $dia ?> a <?php echo $dia2 ?> de <?php echo $mes_s ?></p>
                                                </div>
                                            </li>
                                            <?php } ?>
                                            <li class="row">
                                                <div class="col">
                                                    <span class="custom-icon-minus"><span class="sr-only">&nbsp;</span></span>
                                                    <span class="text title">Abertura das Portas:</span>
                                                </div>
                                                <div class="col">
                                                    <p>
                                                    <?php
                                                        $sql = "select abertura from evento WHERE nomearq = \'' . $nomearq . '\' limit 1";

                                                        $resultado = $con->query($sql);

                                                        if ($resultado->num_rows > 0) {
                                                        while ($row = $resultado->fetch_assoc()) {
                                                                echo $row["abertura"];
                                                            }
                                                        }
                                                    ?>
                                                    </p>
                                                </div>
                                            </li>
                                            <li class="row">
                                                <div class="col">
                                                    <span class="custom-icon-minus"><span class="sr-only">&nbsp;</span></span>
                                                    <span class="text title">
                                                    <?php
                                                        $sql = "select inicio from evento WHERE nomearq = \'' . $nomearq . '\' limit 1";

                                                        $resultado = $con->query($sql);

                                                        if ($resultado->num_rows > 0) {
                                                        while ($row = $resultado->fetch_assoc()) {
                                                                echo $row["inicio"];
                                                            }
                                                        }
                                                    ?>
                                                    </span>
                                                </div>
                                                <div class="col">
                                                    <p>
                                                    <?php
                                                        $sql = "select hora from evento WHERE nomearq = \'' . $nomearq . '\' limit 1";

                                                        $resultado = $con->query($sql);

                                                        if ($resultado->num_rows > 0) {
                                                        while ($row = $resultado->fetch_assoc()) {
                                                                echo $row["hora"];
                                                            }
                                                        }
                                                    ?>
                                                    </p>
                                                </div>
                                            </li> 
                                            
                                            <?php if (!isset($_SESSION["email"]) or $_SESSION["validado"] == 0): ?>
                                                 <?php echo $ings_s1_nlog; ?>
                                            <?php else: ?>
                                                 <?php echo $ings_s1_log; ?>
                                            <?php endif; ?>
                                            
                                            <?php if($nteming != 1){ ?>
                                            
                                                <?php
                                                    $sql0 = "select * from lote WHERE nomearq = \'' . $nomearq . '\'";
                                
                                                    $resultado0 = $con->query($sql0);
                                
                                                    if ($resultado0->num_rows > 0) {
                                                    while ($row0 = $resultado0->fetch_assoc()) {
                                                                echo \'<li class="row">
                                                                    <div class="col">
                                                                        <span class="custom-icon-minus"><span class="sr-only">&nbsp;</span></span>
                                                                        <span class="text title">\';
                                                                        
                                                                        echo $row0["titulo"].":";
                                                                        
                                                                echo \'</span>
                                                                    </div>
                                                                    <div class="col">
                                                                        <span class="text title">\';
                                                                        
                                                                            echo "R$".$row0["valor"];
                                
                                                                    echo \'</span>
                                                                    </div>
                                                                    <div class="col">\';
                                                                
                                                                        if($row0["qtd_ing"] <= 0){
                                                                        echo "<p style=\'color: red;\'>ESGOTADO</p>";
                                                                        }else{
                                                                        echo "<p style=\'color: green;\'>DISPONÍVEL</p>";
                                                                        }
                                                                        
                                                               echo \'</div>
                                                            </li>\';
                                                        }
                                                    }
                                                ?>
                                                    
                                                </li>
                                            
                                            <?php } ?>
                                            
                                            <?php echo $ings_s2_3; ?>
                                            
                                            <?php echo $entfranca_s; ?>
                                            
                                            <br>
                                            <?php echo $ytb; ?> 
                                        </ul>
                                        <div class="text-block top-space">
                                            <h2 class="text-block-title">Descrição:</h2>
                                            <p class="text-justify">
                                            <?php
                                                        $sqldes = "select descricao from evento WHERE nomearq = \'' . $nomearq . '\' limit 1";

                                                        $resultadodes = $con->query($sqldes);

                                                        if ($resultadodes->num_rows > 0) {
                                                        while ($rowdes = $resultadodes->fetch_assoc()) {
                                                                echo $rowdes["descricao"];
                                                            }
                                                        }
                                            ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </main>
        </div>

        <script>
            $("#modal").on("shown.bs.modal", function () {
                $("#modal").modal("show");
                $("#modal").trigger("focus");
            });
            $("#modal").modal({
                keyboard: false
            });
        </script> 

        <style>
            .modal.show .modal-dialog {
                -webkit-transform: translate(0,-50%);
                -o-transform: translate(0,-50%);
                transform: translate(0,-50%);
                top: 50%;
                margin: 0 auto;
            }
        </style>

        <!-- Modal -->
        <center>
            <div data-backdrop="static" data-keyboard="false" class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 style="margin: auto;" id="qtd_t" class="modal-title">Compra de Ingressos:</h5>
                            <button type="button" name="fechar" onclick="zeraP();" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="GET" name="forming" action="../pagamento.php">
                            <div id="corpo" class="modal-body">
                            
                                <div class="row justify-content-center">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <select style="height: 50px;" class="form-control" name="lote0">                    
                                                <?php
                                                $sql0 = "select * from lote WHERE nomearq = \'' . $nomearq . '\'";
                                    
                                                $resultado0 = $con->query($sql0);
                                    
                                                if ($resultado0->num_rows > 0) {
                                                while ($row0 = $resultado0->fetch_assoc()) {
                                                    echo \'<option value="\'.$row0["nome"].\'">\';
                                                    if($row0["qtd_ing"] <= 0){
                                                    echo $row0["titulo"]. ": ESGOTADO";
                                                    }else{
                                                    echo $row0["titulo"].": R$". $row0["valor"];
                                                    }
                                                    echo "</option>";
                                                    }
                                                }
                                    
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <input type="text" placeholder="Nome do Dono" name="nome0" id="nome0" class="form-control">
                                            <input type="hidden" value="" name="qtd" id="qtd">
                                        </div>
                                    </div>
                                </div>
                                <div id="lots">
                                </div>
                                <br id="brP">

                                <div class="row justify-content-center">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <button type="button" onclick="addP();" class="btn-sm btn btn-primary">Adicionar Ingresso</button>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <button type="button" onclick="zeraP();" class="btn-sm btn btn-primary">Limpar</button>
                                        </div>
                                    </div>
                                </div>     
                                
                                <?php
                                    $sql = "select nomearqedit from evento WHERE nomearq = \'' . $nomearq . '\' limit 1";

                                    $resultado = $con->query($sql);

                                    if ($resultado->num_rows > 0) {
                                    while ($row = $resultado->fetch_assoc()) {
                                            $nomearqedit = $row["nomearqedit"];
                                        }
                                    }
                                ?>

                                <script>                                    
                                var contP = 0;
                                    var contAdd = 0;
                                    function addP() {
                                            ++contAdd;
                                            var div = document.getElementById("lots");
                                            var row = document.createElement("div");
                                            row.className = "row justify-content-center";
                                            row.id = "row" + contAdd;
                                            var div2 = document.createElement("div");
                                            div2.className = "col-md-5";
                                            var div3 = document.createElement("div");
                                            div3.className = "col-md-5";
                                            var div4 = document.createElement("div");
                                            div4.className = "form-group";
                                            var div5 = document.createElement("div");
                                            div5.className = "form-group";
                                            var input1 = document.createElement("select");
                                            for (var i = 0; i < num_lots; i++) {
                                                var option = document.createElement("option");
                                                option.value = lots_t[i];
                                                option.text = lots[i];
                                                input1.appendChild(option);
                                            }
                                            
                                            input1.className = "form-control";
                                            input1.id = "lote" + contAdd;
                                            input1.name = "lote" + contAdd;
                                            input1.style.height = "50px";
                                            var input2 = document.createElement("input");
                                            input2.type = "text";
                                            input2.className = "form-control";
                                            input2.placeholder = "Nome do Dono";
                                            input2.id = "nome" + contAdd;
                                            input2.name = "nome" + contAdd;
                                            div.appendChild(row);
                                            row.appendChild(div2);
                                            div2.appendChild(div4);
                                            div4.appendChild(input1);
                                            row.appendChild(div3);
                                            div3.appendChild(div5);
                                            div5.appendChild(input2);
                                            contP = contP + 1;
                                            document.getElementById("brP").style.display = "inherit";
                                    }

                                    function zeraP() {
                                        var nome0 = document.getElementById("nome0");
                                        nome0.value = "";
                                        var cont = 0;
                                        contP = 0;
                                        for (var i = 0; i < contAdd; i++) {
                                            cont++;
                                            var divid = "row" + cont;
                                            var divid1 = document.getElementById(divid);
                                            divid1.remove();
                                        }
                                        contAdd = 0;
                                    }
                                    
                                    function ehAlfanumerico(str) {
                                        return /^[A-Za-z\s]*$/.test(str);
                                    }

                                    function arrayEhDuplicado(arr) {
                                        var counts = [];

                                        for (var i = 0; i <= arr.length; i++) {
                                            if (counts[arr[i]] === undefined) {
                                                counts[arr[i]] = 1;
                                            } else {
                                                return true;
                                            }
                                        }
                                        return false;
                                    }    

                                    function validaForm() {
                                        var inputnum = document.getElementById("qtd");
                                        inputnum.value = contP + 1;
                                        var cont = 0;
                                        var nomes = [];
                                        var nomes_trim = [];
                                        var nomes_def = [];
                                        for (var i = 0; i < contAdd + 1; i++) {
                                            cont++;
                                            var nome = document.forms["forming"]["nome" + i].value;
                                            nomes[i] = nome;
                                             var nome_r = nomes[i].replace("ã", "a");
                                            nome_r = nome_r.replace("é", "e");
                                            nome_r = nome_r.replace("ê", "e");
                                            nome_r = nome_r.replace("á", "a");
                                            nome_r = nome_r.replace("ó", "o");
                                            nome_r = nome_r.replace("í", "i");
                                            nome_r = nome_r.replace("ú", "u");
                                            nome_r = nome_r.replace("à", "a");
                                            nome_r = nome_r.replace("É", "E");
                                            nome_r = nome_r.replace("Á", "A");
                                            nome_r = nome_r.replace("Ê", "E");
                                            nome_r = nome_r.replace("Ó", "O");
                                            nome_r = nome_r.replace("Í", "I");
                                            nome_r = nome_r.replace("À", "A");
                                            nome_r = nome_r.replace("Ã", "A");
                                            nome_r = nome_r.replace("õ", "o");
                                            nome_r = nome_r.replace("Õ", "O");
                                            if (nomes[i] === "") {
                                                $("#modal").modal("hide");
                                                Swal.fire({
                                                    confirmButtonColor: "#7592a4",
                                                    title: "Erro!",
                                                    text: "Informe o nome " + cont + "!",
                                                    icon: "error",
                                                    type: "error"
                                                });
                                                zeraP();
                                                return false;
                                            }
                                            if (ehAlfanumerico(nome_r) === false) {
                                                $("#modal").modal("hide");
                                                Swal.fire({
                                                    confirmButtonColor: "#7592a4",
                                                    title: "Erro!",
                                                    text: "O nome só pode conter letras, sem caracteres especiais!",
                                                    icon: "error",
                                                    type: "error"
                                                });
                                                zeraP();
                                                return false;
                                            }

                                        }
                                        for (var y = 0; y < contAdd + 1; y++) {
                                            nomes_trim[y] = nomes[y].trim();
                                            nomes_def[y] = nomes_trim[y].toLowerCase();
                                        }
                                        if (arrayEhDuplicado(nomes_def)) {
                                            $("#modal").modal("hide");
                                            Swal.fire({
                                                confirmButtonColor: "#7592a4",
                                                title: "Erro!",
                                                text: "Os nomes não podem ser iguais!",
                                                icon: "error",
                                                type: "error"
                                            });
                                            zeraP();
                                            return false;
                                        }
                                        return true;
                                    }  
                                            
                                    //NOME DA PÁGINA
                                    localStorage.setItem("nome_pg","eventos/" + "<?php echo $nomearqedit; ?>" + ".php");
                                </script>
                                <?php
                                
                                     $sql1 = "select valor from evento WHERE nomearq = \'' . $nomearq . '\' limit 1";

                                     $resultado1 = $con->query($sql1);

                                     if ($resultado1->num_rows > 0) {
                                     while ($row1 = $resultado1->fetch_assoc()) {
                                        $valor_v = $row1["valor"];
                                        }
                                    }
                                    
                                    $sql2 = "select titulo from evento WHERE nomearq = \'' . $nomearq . '\' limit 1";

                                     $resultado2 = $con->query($sql2);

                                     if ($resultado2->num_rows > 0) {
                                     while ($row2 = $resultado2->fetch_assoc()) {
                                        $titulo_v = $row2["titulo"];
                                        }
                                    }
                                    
                                    $sql3 = "SELECT COUNT(nomearq) from lote WHERE nomearq = \'' . $nomearq . '\'";
                                    $resultado3 = $con->query($sql3);

                                    
                                
                                //VARIÁVEIS DA PÁGINA
                                $_SESSION["nomeprod"] = $titulo_v;
                                $_SESSION["valor"] = $valor_v;
                                $_SESSION["nomearqevento"] = "'. $nomearq .'";
                                $_SESSION["qtd_prods"] = $resultado4;    
                                $_SESSION["tipo"] = "evento";    
                                ?>
                            </div>
                            <div class="modal-footer">
                                <input style="margin: auto;" onclick="return validaForm();" value="Comprar" type="submit" id="btn_env" name="btn_env" class="btn-sm btn btn-primary">
                            </div>
                        </form>
                        <script>
                        document.getElementById("btn_qtd").style.display = "initial";
                        if(lots === 1){
                        document.getElementById("btn_lote").style.display = "initial";
                        document.getElementById("qtd_l").style.display = "initial";
                        document.getElementById("qtd_t").style.display = "none";
                        document.getElementById("qtd").style.display = "none";
                        document.getElementById("btn_qtd").style.display = "none";

                        function continuaForm() {
                        document.getElementById("qtd_l").style.display = "none";
                        document.getElementById("divlotes").style.display = "none";                                  
                        document.getElementById("btn_lote").style.display = "none"; 
                        document.getElementById("qtd").style.display = "initial";
                        document.getElementById("qtd_t").style.display = "initial";
                        document.getElementById("btn_qtd").style.display = "initial";
                        }
                        }
                        </script>
                    </div>
                </div>
            </div>
        </center>
        <!-- Fim Modal -->
        <style>           
            .ytb{
                color: #55565b;               
            }

            .ytb:not( :hover ){
                transition: 0.8s;
                color: #55565b;               
            }

            .ytb:hover{
                transition: 0.8s;
                color: #FF0000;
            }
        </style>    
        <footer class="footer">
            <div class="content-block footer-main text-center">
                <div class="container">           
                    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
                    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
                    <ul class="social-network">
                        <li><a href="https://www.facebook.com/gravadorpub/"><span class="icon-facebook"></span> </a></li>
                        <li><a href="https://www.youtube.com/GravadorPub"><ion-icon class="ytb" name="logo-youtube"></ion-icon> </a></li> 
                        <li style="margin-left: 8px;"><a href="#"><span class="icon-twitter"></span> </a></li>                                                                  
                        <li><a href="#"><span class="icon-pinterest"></span> </a></li>
                        <li><a href="#"><span class="icon-dribbble"></span> </a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom text-center">
                <div class="container">
                    <p>Copyright © 2021 - Gravador Pub</p>
                    <p>Rua Conde de Porto Alegre, 22 - São Geraldo, Porto Alegre - RS</p>
                </div>
            </div>
        </footer>
    </div>
    <a href="#" class="section-scroll" id="scroll-to-top"><i class="fa fa-angle-up"></i></a>
    <script src="../vendors/jquery/jquery-2.1.4.min.js"></script>
    <script src="../vendors/tether/dist/js/tether.min.js"></script>
    <script src="../vendors/bootstrap/js/bootstrap.min.js"></script>
    <script src="../vendors/stellar/jquery.stellar.min.js"></script>
    <script src="../vendors/isotope/javascripts/isotope.pkgd.min.js"></script>
    <script src="../vendors/isotope/javascripts/packery-mode.pkgd.js"></script>
    <script src="../vendors/owl-carousel/dist/owl.carousel.js"></script>
    <script src="../vendors/waypoint/waypoints.min.js"></script>
    <script src="../vendors/counter-up/jquery.counterup.min.js"></script>
    <script src="../vendors/fancyBox/source/jquery.fancybox.pack.js"></script>
    <script src="../vendors/fancyBox/source/helpers/jquery.fancybox-thumbs.js"></script>
    <script src="../vendors/image-stretcher-master/image-stretcher.js"></script>
    <script src="../vendors/wow/wow.min.js"></script>
    <script src="../vendors/rateyo/jquery.rateyo.js"></script>
    <script src="../vendors/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="../vendors/bootstrap-slider-master/src/js/bootstrap-slider.js"></script>
    <script src="../vendors/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="../js/mega-menu.js"></script>
    <script src="../js/jquery.main.js"></script>
    <script type="text/javascript" src="../vendors/rev-slider/revolution/js/jquery.themepunch.tools.min.js"></script>
    <script type="text/javascript" src="../vendors/rev-slider/revolution/js/jquery.themepunch.revolution.min.js"></script>
    <script type="text/javascript" src="../vendors/rev-slider/revolution/js/extensions/revolution.extension.actions.min.js"></script>
    <script type="text/javascript" src="../vendors/rev-slider/revolution/js/extensions/revolution.extension.carousel.min.js"></script>
    <script type="text/javascript" src="../vendors/rev-slider/revolution/js/extensions/revolution.extension.kenburn.min.js"></script>
    <script type="text/javascript" src="../vendors/rev-slider/revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
    <script type="text/javascript" src="../vendors/rev-slider/revolution/js/extensions/revolution.extension.migration.min.js"></script>
    <script type="text/javascript" src="../vendors/rev-slider/revolution/js/extensions/revolution.extension.navigation.min.js"></script>
    <script type="text/javascript" src="../vendors/rev-slider/revolution/js/extensions/revolution.extension.parallax.min.js"></script>
    <script type="text/javascript" src="../vendors/rev-slider/revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
    <script type="text/javascript" src="../vendors/rev-slider/revolution/js/extensions/revolution.extension.video.min.js"></script>
    <script type="text/javascript" src="../vendors/rev-slider/revolution-addons/snow/revolution.addon.snow.min.js"></script>
    <script src="../js/revolution.js"></script>
</body>

<?php
if (!isset($_SESSION["email"])) {
    if (isset($_POST["pagar"])) {
        ?>
        <script>

            Swal.fire({
                confirmButtonColor: "#7592a4",
                title: "Erro!",
                html: "Faça <a href=\'../login.php\'>login</a> no site para continuar!",
                icon: "error",
                type: "error"
            }).then(function () {
                window.location = "../login.php";
            });
        </script>
        <?php
    }
}

$link = "https://gravadorpub.com.br/reenvio.php?token=" . $_SESSION["token"] . "";

if (isset($_SESSION["email"])) {
    if ($_SESSION["validado"] == 0) {
        if (isset($_POST["pagar"])) {
            ?>
            <script>
                Swal.fire({
                    confirmButtonColor: "#7592a4",
                    title: "Erro!",
                    html: "Um e-mail de confirmação foi enviado para seu e-mail:<br><br> <b style=\'color: blue;\'><?php echo $_SESSION["email"]; ?></b><br><br> <b>Confirme seu e-mail para continuar!</b><br><br> <a href=\'<?php echo $link; ?>\'>Clique aqui</a> para reenviar o e-mail de confirmação.",
                    icon: "error",
                    type: "error"
                });
            </script>
            <?php
        }
    }
}
?>

</html>
';

if (isset($_SESSION['evento_insert']) and isset($_SESSION['arqfoto_sucesso']) and !isset($_SESSION['arqfoto_erro']) and !isset($_SESSION['mkdir_erro']) and file_put_contents($_SERVER["DOCUMENT_ROOT"] ."/eventos/" . $nomearq . ".php", $pg)) {
    $_SESSION['pg_criada'] = true;
    unset($_SESSION['nomearq_f']);
    unset($_SESSION['titulo_f']);
    unset($_SESSION['data1_f']);
    unset($_SESSION['data2_f']);
    unset($_SESSION['abertura_f']);
    unset($_SESSION['textoini_f']);
    unset($_SESSION['horaevento_f']);
    unset($_SESSION['youtube_f']);
    unset($_SESSION['desc_f']);
    unset($_SESSION['desccur_f']);
    header('Location: criareventos.php');
    exit();
} else {
    $_SESSION['pg_criada_erro'] = true;
    deleteDir('img/eventos/' . $pastaimg);
    unlink('eventos/' . $nomearq . '.php');
    header('Location: criareventos.php');
    exit();
}