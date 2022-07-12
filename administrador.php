<?php
include('verifica_admin.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>Administrador</title>
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
        if (isset($_SESSION['pedidos_resetados'])) {
            ?>
            <script>

                Swal.fire({
                    confirmButtonColor: '#7592a4',
                    title: "Sucesso!",
                    text: "Pedidos Resetados!",
                    icon: "success",
                    type: "success"
                });

            </script>
            <?php
            unset($_SESSION['pedidos_resetados']);
        }
    ?>
    
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
                                    <h1 class="visual-title visual-sub-title">Administrador</h1>
                                    <div class="breadcrumb-block">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="home.php"> Home </a></li>
                                            <li class="breadcrumb-item active"> Administrador </li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="content-block">
                    <div class="container">
                        <center><h6 class="content-title contact-title">Ferramentas:</h6></center>
                        <div class="d-flex justify-content-center">
                            <div class="description text-center">                                                                
                                <div class="col col-lg-12">
                                    <div class="row inline-block">
                                        <div class="col-md-6">
                                            <button style="height: 100%;" type="button" id="btn_qtd" name="btn_qtd" onclick="window.location.assign('criareventos.php')" class="btn-block btn-sm btn btn-primary">Criar Eventos</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button style="height: 100%;" type="button" id="btn_qtd" name="btn_qtd" onclick="window.location.assign('apagareventos.php')" class="btn-block btn-sm btn btn-primary">Apagar Eventos</button>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row inline-block">
                                        <div class="col-md-6">
                                            <button style="height: 100%;" type="button" id="btn_qtd" name="btn_qtd" onclick="window.location.assign('editaeventos.php')" class="btn-block btn-sm btn btn-primary">Editar Eventos</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button style="height: 100%;" type="button" id="btn_qtd" name="btn_qtd" onclick="window.location.assign('atualizarqtd.php')" class="btn-block btn-sm btn btn-primary">Editar Estoque</button>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row inline-block">
                                        <div class="col-md-6">
                                            <button style="height: 100%;" type="button" id="btn_qtd" name="btn_qtd" onclick="window.location.assign('criarprodutos.php')" class="btn-block btn-sm btn btn-primary">Criar Produtos</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button style="height: 100%;" type="button" id="btn_qtd" name="btn_qtd" onclick="window.location.assign('apagarprodutos.php')" class="btn-block btn-sm btn btn-primary">Apagar Produtos</button>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row inline-block">
                                        <div class="col-md-12">
                                            <button style="height: 100%;" type="button" id="btn_qtd" name="btn_qtd" onclick="window.location.assign('ingvendidos.php')" class="btn-block btn-sm btn btn-primary">Ingressos Vendidos</button>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row inline-block">
                                        <div class="col-md-6">
                                            <button style="height: 100%;" type="button" id="btn_qtd" name="btn_qtd" onclick="window.location.assign('criardestaques.php')" class="btn-block btn-sm btn btn-primary">Criar Destaques</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button style="height: 100%;" type="button" id="btn_qtd" name="btn_qtd" onclick="window.location.assign('apagardestaques.php')" class="btn-block btn-sm btn btn-primary">Apagar Destaques</button>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row inline-block">
                                        <div class="col-md-12">
                                            <button style="height: 100%;" type="button" id="btn_qtd" name="btn_qtd" onclick="window.location.assign('pedidos.php')" class="btn-block btn-sm btn btn-primary">Ver Pedidos</button>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row inline-block">
                                        <div class="col-md-12">
                                            <button style="height: 100%;" type="button" id="btn_qtd" name="btn_qtd" onclick="window.location.assign('resetapedidos.php')" class="btn-block btn-sm btn btn-primary">Resetar Pedidos</button>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row inline-block">
                                        <div class="col-md-12">
                                            <button style="height: 100%;" type="button" id="btn_qtd" name="btn_qtd" onclick="window.location.assign('editarcardapio.php')" class="btn-block btn-sm btn btn-primary">Editar Cardápio</button>
                                        </div>
                                    </div>
                                </div>                               
                            </div>
                        </div>
                    </div>
                </section>               
            </main>
        </div>
        <script>
            var qtd_a = 0;
            function pegarQtd() {
                var qtd = document.getElementById('qtd').value;
                qtd_a = qtd;
                geraInputs();
            }

            function geraInputs() {
                var cont = 0;
                for (var i = 0; i < qtd_a; i++) {
                    cont++;
                    var div = document.getElementById("corpo");
                    var input = document.createElement("input");
                    input.type = "file";
                    input.className = "form-control col-md-12";
                    input.id = "img" + cont;
                    input.name = "img" + cont;
                    var br = document.createElement("br");
                    br.id = "br" + cont;
                    div.appendChild(input);
                    div.appendChild(br);
                }
            }
        </script>
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

</html>


