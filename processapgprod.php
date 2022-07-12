<?php

include('verifica_admin.php');
require('conexao.php');

$nomeprod = trim($_POST["nomeprod"]);
$subprod = trim($_POST["subprod"]);
$tipo = trim($_POST["tipo"]);
$descprod = trim($_POST["descprod"]);
$valor = trim($_POST["valor"]);
$precoprod = "R$".$valor;
$nomearq = trim($_POST["nomearq"]);
$nomepg = $nomearq . ".php";
$quantidade = trim($_POST["qtd"]);
$qtd_prod = trim($_POST["qtd_prod"]);
$qtdfotos = trim($_POST["qtdfotos"]);
$desccur = trim($_POST["desccur"]);

$desccur = preg_replace("#\'#", '’', $desccur);
$nomeprod = preg_replace("#\'#", '’', $nomeprod);
$subprod = preg_replace("#\'#", '’', $subprod);
$precoprod = preg_replace("#\'#", '’', $precoprod);
$tipo = preg_replace("#\'#", '’', $tipo);
$nomearq = preg_replace("#\'#", '’', $nomearq);

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

$sql_nome = "select count(*) as total from produtos where nomearq = '$nomearq'";

$r_nome = mysqli_query($con, $sql_nome);

$row_nome = mysqli_fetch_assoc($r_nome);

if ($row_nome['total'] >= 1) {
    $_SESSION['nomearq_existe'] = true;
    header('Location: criarprodutos.php');
    exit();
}

function printArray($a) {
    return implode("", $a);
}

$cont1 = 0;
if (mkdir("img/loja/" . $nomeprod, 0777, true)) {
    for ($i = 0; $i < $qtdfotos; $i++) {
        $cont1++;
        $fotos_a[$i] = $_FILES["img" . $cont1];
        $target_dir = "img/loja/" . $nomeprod . '/';
        $target_file = $target_dir . basename($fotos_a[$i]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (file_exists("img/loja/" . $nomeprod . '/' . $target_file)) {
            $_SESSION['arqfoto_existe'] = true;
            $uploadOk = 0;
        }
        $check = getimagesize($fotos_a[$i]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $_SESSION['arqfoto_nimg'] = true;
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
                rename($target_file , "img/loja/" . $nomeprod . '/' . "foto". $i . "." . $imageFileType);
            } else {
                $_SESSION['arqfoto_erro'] = true;
            }
        }
    }
    $imgq = $_FILES["imgq"];
    $target_dir = "img/loja/" . $nomeprod . '/';
    $target_file = $target_dir . basename($imgq["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if (file_exists("img/loja/" . $nomeprod . '/' . $target_file)) {
        $_SESSION['arqfoto_existe'] = true;
        $uploadOk = 0;
    }
    $check = getimagesize($imgq["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $_SESSION['arqfoto_nimg'] = true;
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        $_SESSION['arqfoto_erro'] = true;
    } else {
        if (move_uploaded_file($imgq["tmp_name"], $target_file)) {
            $_SESSION['arqfoto_sucesso'] = true;
            rename($target_file , "img/loja/" . $nomeprod . '/' . "fotocapa.jpg");
        } else {
            $_SESSION['arqfoto_erro'] = true;
        }
    }

    $imgdir = $target_dir . "fotocapa.jpg";
    $url_prod = "loja/" . $nomepg;
    $sql_insert = "INSERT INTO vitrine (nome, subtitulo, desc_cur, descricao, tipo, url, nomearq, imgdir) VALUES ('$nomeprod', '$subprod', '$desccur', '$descprod', '$tipo', '$url_prod', '$nomearq', '$imgdir')";
    if ($con->query($sql_insert)) {
        $_SESSION['prod_insert'] = true;
    }
} else {
    $_SESSION['mkdir_erro'] = true;
}

for ($i = 0; $i < $qtd_prod; $i++) {
    $nomes_prods[$i] = trim($_POST["nome_prod" . $i]);
    $es_prods[$i] = trim($_POST["es_prod" . $i]);
    $nomes_prods[$i] = preg_replace("#\'#", '’', $nomes_prods[$i]);
    $es_prods[$i] = preg_replace("#\'#", '’', $es_prods[$i]);
    $sql_insert2 = "INSERT INTO produtos (nome, qtd, tipo, nomearq) VALUES ('$nomes_prods[$i]', '$es_prods[$i]', '$tipo', '$nomearq')";
    if ($con->query($sql_insert2)) {
        $_SESSION['prod_insert'] = true;
    } else {
        if (isset($_SESSION['prod_insert'])) {
            unset($_SESSION['prod_insert']);
        }
    }
    if ($qtd_prod == 1) {
        $produtos[$i] = '<li class="row">
                        <div class="col">
                            <span class="custom-icon-folder"><span class="sr-only">&nbsp;</span></span>
                            <span class="text title">Estoque:</span>
                        </div>
                        <div class="col">
                            <p>
                            <?php
                            $sql = "select qtd from produtos WHERE nome = \'' . $nomes_prods[$i] . '\' limit 1";

                            $resultado = $con->query($sql);

                            if ($resultado->num_rows > 0) {
                            while ($row = $resultado->fetch_assoc()) {
                                echo $row["qtd"];
                                }
                            }

                            ?>
                            </p>
                            </div>
                    </li>';
    } else {
        $produtos[$i] = '<li class="row">
                        <div class="col">
                            <span class="custom-icon-folder"><span class="sr-only">&nbsp;</span></span>
                            <span class="text title">Estoque de ' . $nomes_prods[$i] . ':</span>
                        </div>
                        <div class="col">
                            <p>
                            <?php
                            $sql = "select qtd from produtos WHERE nome = \'' . $nomes_prods[$i] . '\' limit 1";

                            $resultado = $con->query($sql);

                            if ($resultado->num_rows > 0) {
                            while ($row = $resultado->fetch_assoc()) {
                                echo $row["qtd"];
                                }
                            }

                            ?>
                            </p>
                            </div>
                    </li>';
    }
}


for ($i = 0; $i < $qtdfotos; $i++) {
    $fotos[$i] = '<div class="slide-item">
            <figure class="team-box caption-fade-up">
                <div class="img-block rev-gray-scale">
                    <img src="../img/loja/' . $nomeprod . '/' . $fotos_a[$i]["name"] . '" alt="Imagem Produto">
                </div>                                         
            </figure>
         </div>';
}

for ($i = 0; $i < $qtd_prod; $i++) {
    $options[$i] = "<option class='form-control' value='" . $nomes_prods[$i] . "'>" . $nomes_prods[$i] . "</option>";
}

for ($i = 0; $i < $qtd_prod - 1; $i++) {
    $prodsjs[$i] = "'" . $nomes_prods[$i] . "'" . ",";
}
$prodsjs[$qtd_prod - 1] = "'" . $nomes_prods[$qtd_prod - 1] . "'";

if ($qtd_prod == 1) {
    $add = "";
} else {
    $add = '<div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <button type="button" onclick="addP();" class="btn-sm btn btn-primary">Adicionar Produto</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <button type="button" onclick="zeraP();" class="btn-sm btn btn-primary">Limpar</button>
                    </div>
                </div>
            </div>';
}

$pg = '<?php session_start(); ?>
<?php $_SESSION["pg_atual"] = "loja/' . $nomepg . '"' . '; ?>
<?php include_once("../PagSeguroLibrary/PagSeguroLibrary.php"); ?>
<?php include("../conexao.php"); ?>
<?php $_SESSION["nomearq_prod"] = "' . $nomearq . '"; ?>
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
        <meta property="og:image" content="https://gravadorpub.com.br/img/loja/'.$nomeprod.'/fotocapa.jpg" />
        <meta name="description" content="'.$descprod.'">
        <title>' . $nomeprod . '</title>
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
        var num_prods = ' . $qtd_prod . ';
        var prods = [' . printArray($prodsjs) . ']; 
        document.getElementById("brP").style.display = "none";    
    </script>

    <div id="wrapper">
        <div class="page-wrapper">
            <header class="fixed-top main-header header-white no-top-header" id="waituk-main-header">
                <div id="nav-section">
                    <div class="bottom-header container-fluid mega-menus" id="mega-menus">
                        <nav class="navbar navbar-toggleable-md no-border-radius no-margin mega-menu-multiple" id="navbar-inner-container">
                            <?php include(\'../menu3.php\'); ?>                           
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
                                    <h1 class="visual-title visual-sub-title">' . $nomeprod . '</h1>
                                    <div class="breadcrumb-block">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="../home.php"> Home </a></li>
                                            <li class="breadcrumb-item"><a href="produtos.php"> Loja </a></li>
                                            <li class="breadcrumb-item active"> ' . $nomeprod . ' </li>
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
                                for($y = 0; $y < '. $qtdfotos . '; $y++){
                                    echo \'<div class="slide-item">
                                        <figure class="team-box caption-fade-up">
                                            <div class="img-block rev-gray-scale">
                                                <img src="../img/loja/' . $nomeprod . '/foto\'.$y.\'.jpg" alt="Imagem Produto">
                                            </div>                                         
                                        </figure>
                                    </div>\';
                                }
                                ?>
                                </div>
                            </div>  
                            <div class="portfolio-des top-space">
                                <div class="row">
                                    <div class="col-lg-6 bottom-space-medium-only">
                                        <ul class="content-list info-list">                                
                                            ' . printArray($produtos) . '
                                            <li class="row">
                                                <div class="col">
                                                    <span class="custom-icon-folder"><span class="sr-only">&nbsp;</span></span>
                                                    <span class="text title">Valor:</span>
                                                </div>
                                                <div class="col">
                                                    <p>' . $precoprod . '</p>
                                                </div>
                                            </li>                                   
                                            <li class="row">
                                                <div class="col">
                                                    <span class="custom-icon-link2"><span class="sr-only">&nbsp;</span></span>
                                                    <span class="text title">Compre agora:</span>
                                                </div>
                                                <div class="col">
                                                    <?php if (!isset($_SESSION["email"]) or $_SESSION["validado"] == 0): ?>
                                                        <form method="POST">
                                                            <input data-toggle="modal" data-target="#modal" type="submit" name="pagar" value="Clique Aqui!" class="link">
                                                        </form>
                                                    <?php else: ?>
                                                        <button type="button" class="link" data-toggle="modal" data-target="#modal">
                                                            Clique Aqui!
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </li>
                                        </ul>
                                        <div class="text-block top-space">
                                            <h2 class="text-block-title">Descrição:</h2>
                                            <p class="text-justify">' . $descprod . '</p>
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
                            <h5 style="margin: auto;" id="qtd_t" class="modal-title">Quantidade:</h5>
                            <button type="button" name="fechar" onclick="zeraP();" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="GET" name="forming" action="../pagamento.php">
                            <div id="corpo" class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select class="form-control" id="nome0" name="nome0" style="height: 50px;">                                       
                                            ' . printArray($options) . '    
                                            </select>
                                        </div>
                                </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" placeholder="Quantidade" name="qtd0" id="qtd0" class="form-control">
                                            <input type="hidden" value="" name="num_prods" id="num_prods">
                                        </div>
                                    </div>
                                </div>
                                <div id="prods">
                                </div>
                                <br id="brP">
                                ' . $add . '
                                <script>
                                var inputnum = document.getElementById("num_prods");
                                inputnum.value = num_prods;
                                var contP = 0;
                                    var contAdd = 0;
                                    function addP() {
                                        if (contP < num_prods - 1) {
                                            var div = document.getElementById("prods");
                                            contAdd++;
                                            var row = document.createElement("div");
                                            row.className = "row";
                                            row.id = "row" + contAdd;
                                            var div2 = document.createElement("div");
                                            div2.className = "col-md-6";
                                            var div3 = document.createElement("div");
                                            div3.className = "col-md-6";
                                            var div4 = document.createElement("div");
                                            div4.className = "form-group";
                                            var div5 = document.createElement("div");
                                            div5.className = "form-group";
                                            var input1 = document.createElement("select");
                                            for (var i = 0; i < num_prods; i++) {
                                                var option = document.createElement("option");
                                                option.value = prods[i];
                                                option.text = prods[i];
                                                input1.appendChild(option);
                                            }
                                            input1.className = "form-control";
                                            input1.id = "nome" + contAdd;
                                            input1.name = "nome" + contAdd;
                                            input1.style.height = "50px";
                                            var input2 = document.createElement("input");
                                            input2.type = "text";
                                            input2.className = "form-control";
                                            input2.placeholder = "Quantidade";
                                            input2.id = "qtd" + contAdd;
                                            input2.name = "qtd" + contAdd;
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
                                    }

                                    function zeraP() {
                                        var qtd0 = document.getElementById("qtd0");
                                        qtd0.value = "";
                                        var cont = 0;
                                        contAdd = 0;
                                        contP = 0;
                                        for (var i = 0; i < num_prods; i++) {
                                            cont++;
                                            var divid = "row" + cont;
                                            var divid1 = document.getElementById(divid);
                                            divid1.remove();
                                            var inputid1 = "nome" + cont;
                                            var inputP1 = document.getElementById(inputid1);
                                            inputP1.remove();
                                            var inputid2 = "qtd" + cont;
                                            var inputP2 = document.getElementById(inputid2);
                                            inputP2.remove();
                                            document.getElementById("qtd" + i).value = "";
                                        } 
                                        document.getElementById("brP").style.display = "none";
                                    }

                                    function validaForm() {
                                        for (var i = 0; i < num_prods; i++) {
                                            var qtd_ings = document.getElementById("qtd" + i).value;
                                            if (qtd_ings === "") {
                                                $("#modal").modal("hide");
                                                Swal.fire({
                                                    confirmButtonColor: "#7592a4",
                                                    title: "Erro!",
                                                    text: "Informe a quantidade de produtos!",
                                                    icon: "error",
                                                    type: "error"
                                                }).then(function () {
                                                    document.location.reload(true);
                                                });
                                                return false;
                                            }
                                            if (isNaN(qtd_ings) === true) {
                                                $("#modal").modal("hide");
                                                Swal.fire({
                                                    confirmButtonColor: "#7592a4",
                                                    title: "Erro!",
                                                    text: "A quantidade de produtos deve ser um número!",
                                                    icon: "error",
                                                    type: "error"
                                                }).then(function () {
                                                    document.location.reload(true);
                                                });
                                                ;
                                                return false;
                                            }
                                        }
                                        return true;
                                    }



                                    //NOME DA PÁGINA
                                    localStorage.setItem("nome_pg", "loja/teste.php");
                                </script>
                                <?php
                                //VARIÁVEIS DA PÁGINA
                                $_SESSION["nomeprod"] = "' . $nomeprod . '";  
                                $_SESSION["valor"] = "' . $valor . '";
                                $_SESSION["tipo"] = "produto";
                                $_SESSION["qtd_prods"] = ' . $qtd_prod . ';    
                                ?>
                            </div>
                            <div class="modal-footer">                                
                                <input style="margin: auto;" onclick="return validaForm();" value="Comprar" type="submit" id="btn_env" name="btn_env" class="btn-sm btn btn-primary">
                            </div>
                        </form>
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

if (isset($_SESSION['prod_insert']) and isset($_SESSION['arqfoto_sucesso']) and!isset($_SESSION['arqfoto_erro']) and!isset($_SESSION['mkdir_erro']) and file_put_contents($_SERVER["DOCUMENT_ROOT"] ."/loja/" . $nomearq . ".php", $pg)) {
    $_SESSION['pg_criada'] = true;
    header('Location: criarprodutos.php');
    exit();
} else {
    $_SESSION['pg_criada_erro'] = true;
    deleteDir('img/loja/' . $nomeprod);
    unlink('loja/' . $nomearq . '.php');
    header('Location: criarprodutos.php');
    exit();
}