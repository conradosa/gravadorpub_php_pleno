<?php
session_start();
$_SESSION['pg_atual'] = 'erro.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>Erro!</title>
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

        <?php
        if (isset($_SESSION['reenvio'])) {
            ?>
            <script>
                Swal.fire({
                    confirmButtonColor: '#7592a4',
                    title: "Atenção!",
                    html: "E-mail de confirmação reenviado!<br><br><b>confirme seu e-mail!</b>",
                    icon: "info",
                    type: "info"
                });
            </script>
            <?php
            unset($_SESSION['reenvio']);
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
        </script>

    <center>
        <div class="preloader" id="pageLoad">
            <div class="holder">
                <img width="300" height="300" alt="Carregamento Página" src="img/load/gravador.gif">
            </div>
        </div>
    </center>

    <div id="wrapper">
        <div class="page-wrapper">
            <header class="fixed-top main-header header-white transparent" id="waituk-main-header">
                <div id="nav-section">
                    <div class="bottom-header container-fluid mega-menus" id="mega-menus">
                        <nav class="navbar navbar-toggleable-md no-border-radius no-margin mega-menu-multiple" id="navbar-inner-container">
                            <button type="button" class="navbar-toggler navbar-toggler-left" onclick="pesq1();" data-toggle="collapse" data-target="#mega-menu">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <button style="color: black; border: none; background: none; position: absolute; right: -45%;" class="btn_pesq btn" onclick="pesq();"><i class="custom-icon-search"></i></button>                            
                            <div class="pesquisa1">
                                <form action="pesquisa.php">
                                    <select required class="sel inputform" name="tipo">
                                        <option class="inputform" value="evento">Shows</option>
                                        <option class="inputform" value="produtos">Loja</option>
                                    </select>
                                    <input class="txt inputform" name="txt_pesq" placeholder="Pesquisar" type="text">
                                    <input style="display:none;" type="submit" class="sub inputform" value="Ok">                                   
                                </form>
                            </div>
                            <br><br><br>
                            <div class="collapse navbar-collapse flex-row-reverse" id="mega-menu">
                                <ul class="nav navbar-nav">

                                    <li><a href="home.php" data-title="Home">Home</a></li>

                                    <li><a href="agenda/janeiro.php">Agenda</a></li>

                                    <li><a href="loja/produtos.php">Loja</a></li>

                                    <li><a href="sobre.php">Sobre</a></li>

                                    <li><a href="contato.php">Contato</a></li>
                                    <?php
                                    if (!isset($_SESSION['email'])) {
                                        ?>
                                        <li><a href="login.php">Login</a></li>

                                        <li><a href="cadastro.php">Cadastro</a></li>
                                        <?php
                                    } else {
                                        ?>
                                        <li><a href="minhaconta.php">Minha Conta</a></li>

                                        <li><a href="sair.php">Sair</a></li>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if (isset($_SESSION['email']) and $_SESSION['email'] == "gravadorpub@gmail.com") {
                                        ?>
                                        <li><a href="administrador.php">Administrador</a></li>
                                        <?php
                                    }
                                    ?>   
                                </ul>
                            </div>                            
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
            <main>
                <section class="visual">
                    <div class="visual-inner about-banner dark-overlay parallax" data-stellar-background-ratio="0.55">
                        <div class="centered">
                            <div class="container">
                                <div class="visual-text visual-center">
                                    <h1 class="visual-title visual-sub-title">Erro!</h1>
                                    <div class="breadcrumb-block">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="home.php"> Home </a></li>
                                            <li class="breadcrumb-item active"> Erro </li>
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
                        <center><h6 class="content-title contact-title">Erro:</h6></center>
                        <div class="d-flex justify-content-center">
                            <div class="description">                              
                                <div class="col col-lg-12">
                                    <div class="text-wrap">                                                                                                                        
                                        <h5>Essa Página Não Existe!</h5>
                                        <br>
                                        <center><a href="https://gravadorpub.com.br/">Voltar ao Site</a></center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>                    
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
</html>
