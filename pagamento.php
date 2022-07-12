<?php
include('verifica_se_nao_logado.php');
include('conexao.php');
include_once("PagSeguroLibrary/PagSeguroLibrary.php");
?>
<!DOCTYPE html>
<html lang="pt-BR">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>Pagamento</title>
        <link rel="shortcut icon" href="img/gravador.gif" >
        <link media="all" rel="stylesheet" href="css/fonts/icomoon/icomoon.css">
        <link media="all" rel="stylesheet" href="css/fonts/roxine-font-icon/roxine-font.css">
        <link media="all" rel="stylesheet" href="vendors/font-awesome/css/font-awesome.css">
        <link media="all" rel="stylesheet" href="vendors/owl-carousel/dist/assets/owl.carousel.min.css">
        <link media="all" rel="stylesheet" href="vendors/owl-carousel/dist/assets/owl.theme.default.min.css">
        <link media="all" rel="stylesheet" href="vendors/animate/animate.css">
        <link media="all" rel="stylesheet" href="vendors/rateyo/jquery.rateyo.css">
        <link media="all" rel="stylesheet" href="vendors/bootstrap-datepicker/css/bootstrap-datepicker.css">
        <link media="all" rel="stylesheet" href="vendors/fancyBox/source/jquery.fancybox.css">
        <link media="all" rel="stylesheet" href="vendors/fancyBox/source/helpers/jquery.fancybox-thumbs.css">
        <link media="all" rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="vendors/rev-slider/revolution/css/settings.css">
        <link rel="stylesheet" type="text/css" href="vendors/rev-slider/revolution/css/layers.css">
        <link rel="stylesheet" type="text/css" href="vendors/rev-slider/revolution/css/navigation.css">
        <link media="all" rel="stylesheet" href="css/main.css">
        <link href="css/css.css" rel="stylesheet" type="text/css"/>
        <script src = "//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="sweetalert2.all.min.js"></script>
    </head>

    <body>

    <center>
        <div class="preloader" id="pageLoad">
            <div class="holder">
                <img width="300" height="300" alt="Carregamento Página" src="img/load/gravador.gif">
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
    </script>

    <div id="wrapper">
        <div class="page-wrapper">
            <header class="fixed-top main-header header-white no-top-header" id="waituk-main-header">
                <div id="nav-section">
                    <div class="bottom-header container-fluid mega-menus" id="mega-menus">
                        <nav class="navbar navbar-toggleable-md no-border-radius no-margin mega-menu-multiple" id="navbar-inner-container">
                            <?php include('menu.php'); ?>                     
                        </nav>
                    </div>
                </div>
                <div id="pesq2" class="pesquisa2 pc">
                    <form action="pesquisa.php">
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
                                    <h1 class="visual-title visual-sub-title">Pagamento</h1>
                                    <div class="breadcrumb-block">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="janeiro.php"> Agenda </a></li>
                                            <li class="breadcrumb-item active"> Pagamento </li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <script>
                    $('#modal').on('shown.bs.modal', function () {
                        $('#modal').trigger('focus');
                    });
                    $('#modal').modal({
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
                <br>
                <center><h2>Aguarde enquanto te redirecionamos para a página do PagSeguro!</h2></center>

                <!-- Modal
                <center>
                    <div data-backdrop="static" data-keyboard="false" class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 style="margin: auto;" id="qtd_t" class="modal-title">Chaves PIX:</h5>
                                    <h5 style="margin: auto; display: none;" id="env_t" class="modal-title">Telefones Celulares:</h5>
                                    <button type="button" name="fechar" onclick="zerar();" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <br>
                                <p style="margin: auto;" class="text-justify">+55 (51) 99975-5450</p>
                                <p style="margin: auto;" class="text-justify">+55 (51) 99943-8256</p> 
                                <br>
                                <div class="modal-footer">
                                    <p style="margin: auto;" class="text-justify">Ao realizar a transação enviar o <b>comprovante</b> via <a href="https://wa.me/5551999755450?&text=Olá!">WhatsApp: (51) 99975-5450</a>.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </center>
                 Fim Modal -->

                <aside class="content-block">
                    <div class="container">
                        <div class="logo-container">
                            <div class="owl-carousel logo-slide" id="waituk-owl-slide-4">
                                <div class="slide-item">
                                    <img src="img/logogravador.png" alt="Logo Gravador Pub">
                                </div>
                                <div class="slide-item">
                                    <a href="https://www.lojaopenstage.com.br/"><img src="img/logo-02-Open.png" alt="Logo Openstage"></a>
                                </div>
                                <div class="slide-item">
                                    <img src="img/logogravador.png" alt="Logo Gravador Pub">
                                </div>
                                <div class="slide-item">
                                    <a href="https://www.lojaopenstage.com.br/"><img src="img/logo-02-Open.png" alt="Logo Openstage"></a>
                                </div>
                                <div class="slide-item">
                                    <img src="img/logogravador.png" alt="Logo Gravador Pub">
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>
            </main>
        </div>
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
    <script src="vendors/jquery/jquery-2.1.4.min.js"></script>
    <script src="vendors/tether/dist/js/tether.min.js"></script>
    <script src="vendors/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendors/stellar/jquery.stellar.min.js"></script>
    <script src="vendors/isotope/javascripts/isotope.pkgd.min.js"></script>
    <script src="vendors/isotope/javascripts/packery-mode.pkgd.js"></script>
    <script src="vendors/owl-carousel/dist/owl.carousel.js"></script>
    <script src="vendors/waypoint/waypoints.min.js"></script>
    <script src="vendors/counter-up/jquery.counterup.min.js"></script>
    <script src="vendors/fancyBox/source/jquery.fancybox.pack.js"></script>
    <script src="vendors/fancyBox/source/helpers/jquery.fancybox-thumbs.js"></script>
    <script src="vendors/image-stretcher-master/image-stretcher.js"></script>
    <script src="vendors/wow/wow.min.js"></script>
    <script src="vendors/rateyo/jquery.rateyo.js"></script>
    <script src="vendors/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="vendors/bootstrap-slider-master/src/js/bootstrap-slider.js"></script>
    <script src="vendors/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="js/mega-menu.js"></script>
    <script src="js/jquery.main.js"></script>
    <script src="js/jquery.validate.js"></script>
    <script src="js/mailchimp.js"></script>
    <script src="js/contact-form.js"></script>
    <script type="text/javascript" src="vendors/rev-slider/revolution/js/jquery.themepunch.tools.min.js"></script>
    <script type="text/javascript" src="vendors/rev-slider/revolution/js/jquery.themepunch.revolution.min.js"></script>
    <script type="text/javascript" src="vendors/rev-slider/revolution/js/extensions/revolution.extension.actions.min.js"></script>
    <script type="text/javascript" src="vendors/rev-slider/revolution/js/extensions/revolution.extension.carousel.min.js"></script>
    <script type="text/javascript" src="vendors/rev-slider/revolution/js/extensions/revolution.extension.kenburn.min.js"></script>
    <script type="text/javascript" src="vendors/rev-slider/revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
    <script type="text/javascript" src="vendors/rev-slider/revolution/js/extensions/revolution.extension.migration.min.js"></script>
    <script type="text/javascript" src="vendors/rev-slider/revolution/js/extensions/revolution.extension.navigation.min.js"></script>
    <script type="text/javascript" src="vendors/rev-slider/revolution/js/extensions/revolution.extension.parallax.min.js"></script>
    <script type="text/javascript" src="vendors/rev-slider/revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
    <script type="text/javascript" src="vendors/rev-slider/revolution/js/extensions/revolution.extension.video.min.js"></script>
    <script type="text/javascript" src="vendors/rev-slider/revolution-addons/snow/revolution.addon.snow.min.js"></script>
    <script src="js/revolution.js"></script>
</body>

<?php
//error_reporting(0);

$semest = 0;
$t_qtd = 0;
$t_nomes = "";
$qtd = 0;
$nomearq = "";
$data_c = date("Y-m-d");
if ($_SESSION["tipo"] == "evento") {
    $valor = [];
    $nomearq = $_SESSION["nomearqevento"];
} elseif ($_SESSION['tipo'] == "produto") {
    $nomearq = $_SESSION["nomearq_prod"];
    $valor = $_SESSION['valor'];
}

$num_prods = $_GET["num_prods"];
for ($i = 0; $i < $num_prods; $i++) {
    $nomes_p[$i] = $_GET["nome" . $i];
    $qtd_p[$i] = $_GET["qtd" . $i];
}

if ($_SESSION["tipo"] == "evento") {
    
    $sql = "select * from evento WHERE nomearq='$nomearq' limit 1";

    $resultado = $con->query($sql);

    if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
            $data_c = $row["datacrua"];
        }
    }
    
    $qtd = $_GET['qtd'];
    for ($i = 0; $i < $qtd; $i++) {
        $lote = trim($_GET["lote" . $i]);
        $lotenome[$i] = $lote;
    }
} elseif ($_SESSION['tipo'] == "produto") {
    $lotenome = "none";
    for ($i = 0; $i < $num_prods; $i++) {
        $qtd = $qtd + $qtd_p[$i];
    }
}

if (isset($_GET['btn_env'])) {
    if ($_SESSION["tipo"] == "evento") {
        
        $q_array = array_count_values($lotenome);
        $q_nomes = array_keys($q_array);
        $q_qnts = array_values($q_array);

        for ($i = 0; $i < $qtd; $i++) {
            $sql_l = "select * from lote WHERE nome='$lotenome[$i]' AND nomearq='$nomearq' limit 1";
            $resultado_l = $con->query($sql_l);
            if ($resultado_l->num_rows > 0) {
                while ($row_l = $resultado_l->fetch_assoc()) {
                    for($y = 0; $y < $qtd; $y++){
                        if($q_nomes[$y] == $lotenome[$y]){
                            $q_nome = $q_nomes[$y];
                            $q_qnt = $q_qnts[$y];
                        }
                    }
                    $calculo_l = $row_l["qtd_ing"] - $q_qnt;
                    if ($calculo_l < 0 or $row_l["qtd_ing"] <= 0) {
                        $semest = 1;
                        ?>
                        <script>
                            Swal.fire({
                                confirmButtonColor: '#7592a4',
                                title: "Erro!",
                                html: "A quantidade é maior que o estoque disponível!",
                                icon: "error",
                                type: "error"
                            }).then(function () {
                                window.location = localStorage.getItem("nome_pg");
                            });
                        </script>
                        <?php
                    }
                }
            }
        }
    } elseif ($_SESSION['tipo'] == "produto") {
        for ($c = 0; $c < $num_prods; $c++) {
            $sql_qtd = "select * from produtos WHERE nome='$nomes_p[$c]' limit 1";
            $resultado = $con->query($sql_qtd);
            if ($resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    $bd_qtds[$c] = $row["qtd"];
                }
            }
            if ($t_nomes === $nomes_p[$c]) {
                $bd_qtds[$c] = $bd_qtds[$c] - $t_qtd;
            }
            if($qtd_p[$c] != ""){
                $calculo = $bd_qtds[$c] - $qtd_p[$c];
                if ($calculo < 0 or $bd_qtds[$c] <= 0) {
                    $semest = 1;
                    ?>
                    <script>
    
                        Swal.fire({
                            confirmButtonColor: '#7592a4',
                            title: "Erro!",
                            html: "A quantidade é maior que o estoque disponível!",
                            icon: "error",
                            type: "error"
                        }).then(function () {
                            window.location = localStorage.getItem("nome_pg");
                        });
                    </script>
                    <?php
                }
            }
            $t_qtd = $qtd_p[$c];
            $t_nomes = $nomes_p[$c];
        }
    }
}

if ($_SESSION['tipo'] == "produto") {
    $str_del = "DELETE FROM qtd_temp WHERE nomearq = '$nomearq' AND email = '{$_SESSION['email']}'";
    $con->query($str_del);
    for ($i = 0; $i < $num_prods; $i++) {
        $sql_insert = "INSERT INTO qtd_temp (nomearq, email, nome, qtd) VALUES ('$nomearq', '{$_SESSION['email']}', '$nomes_p[$i]', '$qtd_p[$i]')";
        $con->query($sql_insert);
    }
}

    if (isset($_SESSION['nome_completo']) && isset($_SESSION['email'])) {
        ?>
        <?php if (PagSeguroConfig::getEnvironment() == "sandbox") : ?>
            <script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
        <?php else : ?>
            <script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
        <?php endif; ?>   
        <?php
        $tipo = $_SESSION['tipo'];
        if ($tipo == "evento") {
            $sql = "SELECT * FROM ingressos";
            $result = mysqli_query($con, $sql);
            if ($result) {
                $rowcount = mysqli_num_rows($result);
            }
            for ($i = 0; $i < $qtd; $i++) {
                $nome = mysqli_real_escape_string($con, trim($_GET['nome' . $i]));
                $nomes_a[$i] = $nome;
            }
            $nomes = implode("-", $nomes_a);
            $nomes_l = implode("-", $lotenome);
        } elseif ($tipo == "produto") {
            $sql = "SELECT * FROM produtos";
            $result = mysqli_query($con, $sql);
            if ($result) {
                $rowcount = mysqli_num_rows($result);
            }
            $nomes = "none";
        }
        $iditem = $rowcount + 1;
        $nomeprod = $_SESSION['nomeprod'];
        $paymentRequest = new PagSeguroPaymentRequest();
        if($_SESSION["tipo"] == "evento") {
            for ($i = 0; $i < $qtd; $i++) {
                $iditem++;
                $nomepedido[$i] = "Ingresso - ".$nomes_a[$i];
                if ($lotenome[$i] != "normal") {
                    $sql_v = "select * from lote WHERE nome='$lotenome[$i]' AND nomearq='$nomearq' limit 1";
                    $resultado_v = $con->query($sql_v);
                    if ($resultado_v->num_rows > 0) {
                        while ($row_v = $resultado_v->fetch_assoc()) {
                            $valor[$i] = $row_v["valor"];
                            $paymentRequest->addItem($iditem, $nomepedido[$i], 1, $valor[$i]);
                        }
                    }
                } else {
                    $valor[$i] = $_SESSION['valor'];
                    $paymentRequest->addItem($iditem, $nomepedido[$i], 1, $valor[$i]);
                }
            }
        }elseif($_SESSION['tipo'] == "produto"){
            $paymentRequest->addItem($iditem, $nomeprod, $qtd, $valor);    
        }
        $paymentRequest->setCurrency("BRL");
        $cod = md5(uniqid(rand(), true));
        $referencia = $cod;
        $paymentRequest->setReference($referencia);
        $sum_valor = array_sum($valor);
        $sql_insert = "INSERT INTO compras (codigo, nomeprod, nome_completo, email, valor, nomes, tipo, qtd, nomearq, nomes_l, data) VALUES ('$cod', '$nomeprod', '{$_SESSION['nome_completo']}', '{$_SESSION['email']}', '$sum_valor', '$nomes', '$tipo', '$qtd', '$nomearq', '$nomes_l', '$data_c')";
        $con->query($sql_insert);
        
        $paymentRequest->setRedirectUrl("https://gravadorpub.com.br/sucesso.php");
        $paymentRequest->addParameter('notificationURL', 'https://gravadorpub.com.br/response.php');
            //$onlyCheckoutCode = true;
            $credentials = PagSeguroConfig::getAccountCredentials(); // getApplicationCredentials() 
            $checkoutUrl = $paymentRequest->register($credentials, $onlyCheckoutCode);
            //echo "<a href='{$checkoutUrl}'>Pagar</a>";
            if($semest == 0){
                echo "<script>window.location.assign('".$checkoutUrl."');</script>";
            }
            
    } else {
        ?>
        <script>

                    Swal.fire({
                        confirmButtonColor: '#7592a4',
                        title: "Erro!",
                        html: "Faça <a href='login.php'>login</a> no site para continuar!",
                        icon: "error",
                        type: "error"
                    }).then(function () {
                        window.location = "login.php";
                    });
                    ;

        </script>
        <?php
    }
?>

</html>
