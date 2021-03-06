<?php
include('verifica_se_logado.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>Cadastro</title>
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
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="sweetalert2.all.min.js"></script>
    </head>

    <body>

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

    <center>
        <div class="preloader" id="pageLoad">
            <div class="holder">
                <img width="300" height="300" alt="Carregamento P??gina" src="img/load/gravador.gif">
            </div>
        </div>
    </center>

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

            <?php
            if (isset($_SESSION['email_existe'])) {
                ?>
                <script>

                    Swal.fire({
                        confirmButtonColor: '#7592a4',
                        title: "Erro!",
                        text: "E-mail j?? cadastrado!",
                        icon: "error",
                        type: "error"
                    });
                </script>
                <?php
                unset($_SESSION['email_existe']);
            }
            ?>

            <?php
            if (isset($_SESSION['cel_existe'])) {
                ?>
                <script>

                    Swal.fire({
                        confirmButtonColor: '#7592a4',
                        title: "Erro!",
                        text: "Celular j?? cadastrado!",
                        icon: "error",
                        type: "error"
                    });
                </script>
                <?php
                unset($_SESSION['cel_existe']);
            }
            ?>

            <?php
            if (isset($_SESSION['sucesso_cadastro'])) {
                ?>
                <script>

                    Swal.fire({
                        confirmButtonColor: '#7592a4',
                        title: "Sucesso!",
                        text: "Cadastro efetuado!",
                        icon: "success",
                        type: "success"
                    }).then(function () {
                        Swal.fire({
                            confirmButtonColor: '#7592a4',
                            title: "Aten????o!",
                            html: "Um e-mail de confirma????o foi enviado para seu e-mail!<br><br> <b>Confirme seu e-mail!</b>",
                            icon: "warning",
                            type: "warning"
                        }).then(function () {
                            window.location = "login.php";
                        });
                    });
                    ;
                </script>
                <?php
                unset($_SESSION['sucesso_cadastro']);
            }
            ?>

            <main>
                <div class="content-wrapper">
                    <div class="row no-gutters">
                        <div class="col-lg-6 hidden-md-down">
                            <div class="bg-stretch img-wrap">
                                <img src="img/imglogin.jpg" alt="Imagem Gravador Pub">
                            </div>
                        </div>
                        <div class="col-lg-6 signup-block">
                            <div class="signup-wrap text-center">
                                <div class="inner-wrap">                               
                                    <form action="cadastrar.php" onsubmit="return validaForm()" method="post" id="contact_form" class="waituk_contact-form signup-form" name="form_cadastro">
                                        <h2 class="bottom-space">Fa??a Parte do Gravador Pub</h2>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" placeholder="NOME" id="nome" name="nome" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" placeholder="N??MERO DE CELULAR" id="cel" name="cel" class="form-control">    
                                                </div>
                                            </div>                              
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="password" placeholder="SENHA" id="senha" name="senha" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="password" placeholder="CONFIRME SUA SENHA" id="senha_c" name="senha_c" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="email" placeholder="E-MAIL" id="email" name="email" class="form-control">                                                  
                                                </div>
                                            </div>
                                        </div>
                                        <p>Ao criar uma conta voc?? estar?? aceitando os nossos
                                            <a style="color: #7592a4;" href="termosdeservico.php"> termos de servi??o. </a></p>
                                        <div class="btn-container mt-xl-5 mt-lg-2">
                                            <input type="submit" value="CRIAR CONTA" style="background-color: #7592a4; border-color: #7592a4;" id="btn_sent" class="btn btn-primary has-radius-small">
                                        </div>
                                    </form>

                                    <script>
                                        function ehAlfanumerico(str) {
                                            return /^[A-Za-z\s]*$/.test(str);
                                        }

                                        function validaForm() {
                                            let nome = document.forms["form_cadastro"]["nome"].value;
                                            var nome_r = nome.replace("??", "a");
                                            if (nome === "") {
                                                Swal.fire({
                                                    confirmButtonColor: '#7592a4',
                                                    title: "Erro!",
                                                    text: "Informe seu nome!",
                                                    icon: "error",
                                                    type: "error"
                                                });
                                                return false;
                                            }

                                            if (ehAlfanumerico(nome_r) === false) {
                                                Swal.fire({
                                                    confirmButtonColor: '#7592a4',
                                                    title: "Erro!",
                                                    text: "O nome s?? pode conter letras, sem caracteres especiais!",
                                                    icon: "error",
                                                    type: "error"
                                                });
                                                return false;
                                            }

                                            let celular = document.forms["form_cadastro"]["cel"].value;
                                            if (celular === "") {
                                                Swal.fire({
                                                    confirmButtonColor: '#7592a4',
                                                    title: "Erro!",
                                                    text: "Informe seu n??mero de celular!",
                                                    icon: "error",
                                                    type: "error"
                                                });
                                                return false;
                                            }
                                            let senha1 = document.forms["form_cadastro"]["senha"].value;
                                            if (senha1 === "") {
                                                Swal.fire({
                                                    confirmButtonColor: '#7592a4',
                                                    title: "Erro!",
                                                    text: "Informe sua senha!",
                                                    icon: "error",
                                                    type: "error"
                                                });
                                                return false;
                                            }
                                            let senha2 = document.forms["form_cadastro"]["senha_c"].value;
                                            if (senha2 === "") {
                                                Swal.fire({
                                                    confirmButtonColor: '#7592a4',
                                                    title: "Erro!",
                                                    text: "Confirme sua senha!",
                                                    icon: "error",
                                                    type: "error"
                                                });
                                                return false;
                                            }
                                            let email = document.forms["form_cadastro"]["email"].value;
                                            if (email === "") {
                                                Swal.fire({
                                                    confirmButtonColor: '#7592a4',
                                                    title: "Erro!",
                                                    text: "Informe seu E-mail!",
                                                    icon: "error",
                                                    type: "error"
                                                });
                                                return false;
                                            }
                                            if (email.includes("|") === true) {
                                                Swal.fire({
                                                    confirmButtonColor: '#7592a4',
                                                    title: "Erro!",
                                                    text: "O E-mail n??o pode conter caracteres especiais!",
                                                    icon: "error",
                                                    type: "error"
                                                });
                                                return false;
                                            }
                                            if (senha1 !== senha2) {
                                                Swal.fire({
                                                    confirmButtonColor: '#7592a4',
                                                    title: "Erro!",
                                                    text: "A senha e sua confirma????o devem ser iguais!",
                                                    icon: "error",
                                                    type: "error"
                                                });
                                                return false;
                                            }
                                            return true;
                                        }
                                    </script>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                    <p>Copyright ?? 2021 - Gravador Pub</p>
                    <p>Rua Conde de Porto Alegre, 22 - S??o Geraldo, Porto Alegre - RS</p>
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

</html>
