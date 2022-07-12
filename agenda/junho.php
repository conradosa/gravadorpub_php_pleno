<?php
session_start();
require('../conexao.php');
$_SESSION['pg_atual'] = 'agenda/junho.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>Agenda - Junho</title>
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
        <script src = "//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="sweetalert2.all.min.js"></script>
    </head>

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
    </script>

    <div id="wrapper">
        <div class="page-wrapper">
            <header class="fixed-top main-header header-white transparent" id="waituk-main-header">
                <div id="nav-section">
                    <div class="bottom-header container-fluid mega-menus" id="mega-menus">
                        <nav class="navbar navbar-toggleable-md no-border-radius no-margin mega-menu-multiple" id="navbar-inner-container">
                            <?php include('../menu4.php'); ?>                             
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
            <main>
                <section class="visual">
                    <div class="visual-inner portfolio-banner-v1 black-overlay-3 parallax" data-stellar-background-ratio="0.55">
                        <div class="centered">
                            <div class="container">
                                <div class="visual-text visual-center">
                                    <h1 class="visual-title visual-sub-title text-white">Agenda de Shows do Gravador Pub:</h1>
                                    <div class="breadcrumb-block">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="../home.php"> Home </a></li>
                                            <li class="breadcrumb-item"> Agenda </li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="content-wrapper">
                    <br>
                    <center>
                        <div class="dropdown">
                            <button style="background-color: #3867ff; border: none;" class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Selecione a Data
                            </button>
                            <div class="dropdown-menu dropdown-menu-center" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="janeiro.php">Janeiro</a>
                                <a class="dropdown-item" href="fevereiro.php">Fevereiro</a>
                                <a class="dropdown-item" href="marco.php">Março</a>
                                <a class="dropdown-item" href="abril.php">Abril</a>
                                <a class="dropdown-item" href="maio.php">Maio</a>
                                <a class="dropdown-item" href="junho.php">Junho</a>
                                <a class="dropdown-item" href="julho.php">Julho</a>
                                <a class="dropdown-item" href="agosto.php">Agosto</a>
                                <a class="dropdown-item" href="setembro.php">Setembro</a>
                                <a class="dropdown-item" href="outubro.php">Outubro</a>
                                <a class="dropdown-item" href="novembro.php">Novembro</a>
                                <a class="dropdown-item" href="dezembro.php">Dezembro</a>
                            </div>
                        </div>
                    </center>
                    <br>                   
                    <ul class="filter-nav filter-nav-v2 text-center button-group filter-button-group">
                        <li>
                            <button style="color: #9e9e9e;" onclick="window.location.href = 'janeiro.php'"><b>Janeiro</b></button>
                        </li>
                        <li>
                            <button style="color: #9e9e9e;" onclick="window.location.href = 'fevereiro.php'"><b>Fevereiro</b></button>
                        </li>     
                        <li>
                            <button style="color: #9e9e9e;" onclick="window.location.href = 'marco.php'"><b>Março</b></button>
                        </li>
                        <li>
                            <button style="color: #9e9e9e;" onclick="window.location.href = 'abril.php'"><b>Abril</b></button>
                        </li>
                        <li>
                            <button style="color: #9e9e9e;" onclick="window.location.href = 'maio.php'"><b>Maio</b></button>
                        </li>
                        <li>
                            <button class='is-checked' onclick="window.location.href = 'junho.php'"><b>Junho</b></button>
                        </li>
                        <li>
                            <button style="color: #9e9e9e;" onclick="window.location.href = 'julho.php'"><b>Julho</b></button>
                        </li>
                        <li>
                            <button style="color: #9e9e9e;" onclick="window.location.href = 'agosto.php'"><b>Agosto</b></button>
                        </li>
                        <li>
                            <button style="color: #9e9e9e;" onclick="window.location.href = 'setembro.php'"><b>Setembro</b></button>
                        </li>
                        <li>
                            <button style="color: #9e9e9e;" onclick="window.location.href = 'outubro.php'"><b>Outubro</b></button>
                        </li>
                        <li>
                            <button style="color: #9e9e9e;" onclick="window.location.href = 'novembro.php'"><b>Novembro</b></button>
                        </li>
                        <li>
                            <button style="color: #9e9e9e;" onclick="window.location.href = 'dezembro.php'"><b>Dezembro</b></button>
                        </li>
                    </ul>           
                    <div class="container-fluid">
                        <div class="row masonary-block grid">               
                            <?php
                            $sql = "select * from evento WHERE mes = 'junho' ORDER BY dia ASC";

                            $resultado = $con->query($sql);

                            if ($resultado->num_rows > 0) {
                                while ($row = $resultado->fetch_assoc()) {
                                    $evento_s = '<div class="gallery-item col-lg-6 col-xl-4">
                                <figure class="caption-hover-full">
                                    <a class="fancy-pop" href="../' . $row["url"] . '"></a>
                                    <div class="image-wrapper"><img src="../' . $row["imgdir"] . '" alt="' . $row["titulo"] . '"></div>
                                    <div class="image-details">
                                        <div class="figcaption">
                                            <div class="trigger">
                                                <div class="custom-icon-plus"><span class="sr-only">&nbsp;</span></div>
                                            </div>
                                            <div class="info">
                                                <h2 class="content-title">' . $row["tituloevento"] . '</h2><br>
                                                <h6 class="content-wrapper">' . $row["data_evento"] . '</h6>
                                                <p class="content-wrapper">' . $row["desc_cur"] . '</p>
                                                <p class="content-wrapper">Clique para saber mais!</p>
                                            </div>
                                        </div>
                                    </div>
                                </figure>
                            </div>';
                                    echo $evento_s;
                                }
                            }

                            $con->close();
                            ?>                           
                        </div>
                    </div>
                    <br><br><br>
                </div>
            </main>
        </div>
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

</html>
