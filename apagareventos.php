<?php
include('verifica_admin.php');
require('conexao.php');
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
        if (isset($_SESSION['evento_apagado'])) {
            ?>
            <script>

                Swal.fire({
                    confirmButtonColor: '#7592a4',
                    title: "Sucesso!",
                    text: "Evento Apagado!",
                    icon: "success",
                    type: "success"
                });

            </script>
            <?php
            unset($_SESSION['evento_apagado']);
        }
        ?>  

        <style>

            .dropdown {
                display: none;
            }
            .filter-nav {
                display: inherit;
            }

            @media only screen and (max-width: 1200px) {
                .dropdown {
                    display: inherit;
                }

                .filter-nav {
                    display: none;
                }

            }

            .dropdown-menu-center {
                right: auto;
                left: 50%;
                -webkit-transform: translate(-50%, 0);
                -o-transform: translate(-50%, 0);
                transform: translate(-50%, 0);
            }

        </style>

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
                                    <h1 class="visual-title visual-sub-title">Apagar Eventos</h1>
                                    <div class="breadcrumb-block">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="administrador.php"> Administrador </a></li>
                                            <li class="breadcrumb-item active"> Apagar Eventos </li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="content-block">
                    <div class="container">
                        <center><h6 class="content-title contact-title">Apagar eventos:</h6></center>                      
                        <div class="d-flex justify-content-center">
                            <div class="description">                              
                                <div class="col col-lg-12">
                                    <br>
                                    <center>                                       
                                        <form method="POST">
                                            <label>Selecione o mês do evento:</label>
                                            <select required class="form-control" name="mes">
                                                <option value="todos">Todos</option>
                                                <option value="janeiro">Janeiro</option>
                                                <option value="fevereiro">Fevereiro</option>
                                                <option value="mar">Março</option>
                                                <option value="abril">Abril</option>
                                                <option value="maio">Maio</option>
                                                <option value="junho">Junho</option>
                                                <option value="julho">Julho</option>
                                                <option value="agosto">Agosto</option>
                                                <option value="setembro">Setembro</option>
                                                <option value="outubro">Outubro</option>
                                                <option value="novembro">Novembro</option>
                                                <option value="dezembro">Dezembro</option>
                                            </select><br>
                                            <input style="color: black;" class="btn" type="submit" value="Enviar" name="enviar">
                                        </form>
                                        <br>
                                        <?php
                                        if (isset($_POST['enviar'])) {
                                            $mes = $_POST['mes'];
                                            if ($mes == "todos") {
                                                $sql = "select * from evento ORDER BY dia ASC";
                                            } else {
                                                $sql = "select * from evento WHERE mes = '$mes' ORDER BY dia ASC";
                                            }
                                            $resultado = $con->query($sql);

                                            if ($resultado->num_rows > 0) {
                                                while ($row = $resultado->fetch_assoc()) {
                                                    $evento_s = '<h2>' . $row["tituloevento"] . '</h2>';
                                                    $evento_s2 = '<h3>' . $row["data"] . '</h3>';
                                                    echo '<br>';
                                                    echo '<br>';
                                                    echo '<div class="row">';
                                                    echo '<div class="col-md-6">';
                                                    echo '<div class="form-group">';
                                                    echo $evento_s;
                                                    echo '<br>';
                                                    echo $evento_s2;
                                                    echo '</div>';
                                                    echo '</div>';
                                                    echo '<div class = "col-md-6">';
                                                    echo '<div class = "form-group">';
                                                    echo '<form action="deletar.php" method="POST">';
                                                    echo '<input value="' . $row["id"] . '" type="hidden" name="id">';
                                                    echo '<input value="' . $row["titulo"] . '" type="hidden" name="nome">';
                                                    echo '<input class="btn" style="color: black;" value="Apagar" type="submit" name="apagar">';
                                                    echo '</form>';
                                                    echo '</div>';
                                                    echo '</div>';
                                                    echo '</div>';
                                                }
                                            } else {
                                                if ($mes == "todos") {
                                                    echo "<br>";
                                                    echo "<h2 class='content-title'>Nenhum evento cadastrado</h2>";
                                                } else {
                                                    echo "<br>";
                                                    echo "<h2 class='content-title'>Nenhum evento cadastrado neste mês</h2>";
                                                }
                                            }
                                        }
                                        ?>  

                                    </center>
                                    <br>   
                                    <br>                                                          
                                </div>
                            </div>
                        </div>
                    </div>
                </section>               
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

</html>


