<?php
include('verifica_se_nao_logado.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>Minha Conta</title>
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
                                    <h1 class="visual-title visual-sub-title">Minha Conta</h1>
                                    <div class="breadcrumb-block">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="home.php"> Home </a></li>
                                            <li class="breadcrumb-item active"> Minha Conta </li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <?php
                if (isset($_SESSION['sucesso_update_nome'])) {
                    ?>
                    <script>

                        Swal.fire({
                            confirmButtonColor: '#7592a4',
                            title: "Sucesso!",
                            text: "Nome atualizado!",
                            icon: "success",
                            type: "success"
                        });

                    </script>
                    <?php
                    unset($_SESSION['sucesso_update_nome']);
                }
                ?>

                <?php
                if (isset($_SESSION['sucesso_update_cel'])) {
                    ?>
                    <script>

                        Swal.fire({
                            confirmButtonColor: '#7592a4',
                            title: "Sucesso!",
                            text: "Celular atualizado!",
                            icon: "success",
                            type: "success"
                        });

                    </script>
                    <?php
                    unset($_SESSION['sucesso_update_cel']);
                }
                ?>

                <?php
                if (isset($_SESSION['sucesso_update_senha'])) {
                    ?>
                    <script>

                        Swal.fire({
                            confirmButtonColor: '#7592a4',
                            title: "Sucesso!",
                            text: "Senha atualizada!",
                            icon: "success",
                            type: "success"
                        });

                    </script>
                    <?php
                    unset($_SESSION['sucesso_update_senha']);
                }
                ?>

                <?php
                if (isset($_SESSION['email_existe'])) {
                    ?>
                    <script>

                        Swal.fire({
                            confirmButtonColor: '#7592a4',
                            title: "Erro!",
                            text: "E-mail já cadastrado!",
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
                            text: "Celular já cadastrado!",
                            icon: "error",
                            type: "error"
                        });

                    </script>
                    <?php
                    unset($_SESSION['cel_existe']);
                }
                ?>    

                <section class="content-block">
                    <div class="container">
                        <center><h2 class="bottom-space">Boas-vindas, <?php echo $_SESSION['nome']; ?>!</h2></center>
                        <div class="signup-wrap text-center">
                            <div class="inner-wrap">                               
                                <form action="update_nome.php" onsubmit="return validaNome()" method="post" id="atualiza_nome" class="waituk_contact-form signup-form" name="atualiza_nome">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" placeholder="NOVO NOME" id="nome" name="nome" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="submit" value="ATUALIZAR NOME" style="background-color: #7592a4; border: none; height: 50px;" id="btn_sent" class="btn has-radius-small">
                                        </div> 
                                    </div>
                                </form>
                                <form action="update_numero_cel.php" onsubmit="return validaCel()" method="post" id="atualiza_num" class="waituk_contact-form signup-form" name="atualiza_num">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" placeholder="NOVO NÚMERO DE CELULAR" id="num" name="cel" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="submit" value="ATUALIZAR NÚMERO" style="background-color: #7592a4; border: none; height: 50px;" id="btn_sent" class="btn has-radius-small">
                                        </div> 
                                    </div>
                                </form>
                                <form action="update_senha.php" onsubmit="return validaSenha()" method="post" id="atualiza_senha" class="waituk_contact-form signup-form" name="atualiza_senha">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="password" placeholder="NOVA SENHA" id="senha" name="senha" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="password" placeholder="CONFIRME SUA NOVA SENHA" id="senha_c" name="senha_c" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="submit" value="ATUALIZAR SENHA" style="background-color: #7592a4; border: none; height: 50px;" id="btn_sent" class="btn has-radius-small">
                                        </div>  
                                    </div>
                                </form>
                                <form action="update_email.php" onsubmit="return validaEmail()" method="post" id="atualiza_email" class="waituk_contact-form signup-form" name="atualiza_email">
                                    <div class='row'>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="email" placeholder="NOVO E-MAIL" id="email" name="email" class="form-control">                                                  
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="submit" value="ATUALIZAR E-MAIL" style="background-color: #7592a4; border: none; height: 50px;" id="btn_sent" class="btn has-radius-small">
                                        </div>
                                    </div> 
                                </form>
                                <?php $link = "https://gravadorpub.com.br/reenvio.php?token=" . $_SESSION['token'] . ""; ?>
                                <?php
                                if ($_SESSION['validado'] == 0) {
                                    ?>
                                    <p><a href='<?php echo $link; ?>'>Clique aqui</a> para reenviar o e-mail de confirmação!</p>
                                    <?php
                                }
                                ?>
                                <p>Veja seus dados atuais <a href="dados.php">aqui</a>.</p>    
                                <script>

                                    function validaNome() {
                                        let nome = document.forms["atualiza_nome"]["nome"].value;
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
                                        return true;
                                    }

                                    function validaCel() {
                                        let celular = document.forms["atualiza_num"]["num"].value;
                                        if (celular === "") {
                                            Swal.fire({
                                                confirmButtonColor: '#7592a4',
                                                title: "Erro!",
                                                text: "Informe seu número de celular!",
                                                icon: "error",
                                                type: "error"
                                            });
                                            return false;
                                        }
                                        if (isNaN(celular) === true) {
                                            Swal.fire({
                                                confirmButtonColor: '#7592a4',
                                                title: "Erro!",
                                                text: "No campo Número de Celular insira somente números!",
                                                icon: "error",
                                                type: "error"
                                            });
                                            return false;
                                        }
                                        return true;
                                    }

                                    function validaSenha() {
                                        let senha1 = document.forms["atualiza_senha"]["senha"].value;
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
                                        let senha2 = document.forms["atualiza_senha"]["senha_c"].value;
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
                                        if (senha1 !== senha2) {
                                            Swal.fire({
                                                confirmButtonColor: '#7592a4',
                                                title: "Erro!",
                                                text: "A senha e sua confirmação devem ser iguais!",
                                                icon: "error",
                                                type: "error"
                                            });
                                            return false;
                                        }
                                        return true;
                                    }

                                    function validaEmail() {
                                        let email = document.forms["atualiza_email"]["email"].value;
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
                                        return true;
                                    }

                                </script>

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
