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
        if (isset($_SESSION['nomearq_existe'])) {
            ?>
            <script>

                Swal.fire({
                    confirmButtonColor: '#7592a4',
                    title: "Erro!",
                    text: "O nome de arquivo digitado já existe!",
                    icon: "error",
                    type: "error"
                });

            </script>
            <?php
            unset($_SESSION['nomearq_existe']);
        }
        ?>

        <?php
        if (isset($_SESSION['pg_criada_erro'])) {
            ?>
            <script>

                Swal.fire({
                    confirmButtonColor: '#7592a4',
                    title: "Erro!",
                    text: "Erro na criação da página!",
                    icon: "error",
                    type: "error"
                });

            </script>
            <?php
            unset($_SESSION['pg_criada_erro']);
        }
        ?>

        <?php
        if (isset($_SESSION['arqfoto_erro'])) {
            ?>
            <script>

                Swal.fire({
                    confirmButtonColor: '#7592a4',
                    title: "Erro!",
                    text: "Erro no upload das imagens! Use apenas .jpg!",
                    icon: "error",
                    type: "error"
                });

            </script>
            <?php
            unset($_SESSION['arqfoto_erro']);
        }
        ?>

        <?php
        if (isset($_SESSION['arqfoto_nimg'])) {
            ?>
            <script>

                Swal.fire({
                    confirmButtonColor: '#7592a4',
                    title: "Erro!",
                    text: "Algum arquivo selecionado não é uma imagem de formato válido! Use apenas .jpg!",
                    icon: "error",
                    type: "error"
                });

            </script>
            <?php
            unset($_SESSION['arqfoto_nimg']);
        }
        ?>

        <?php
        if (isset($_SESSION['mkdir_erro'])) {
            ?>
            <script>

                Swal.fire({
                    confirmButtonColor: '#7592a4',
                    title: "Erro!",
                    text: "Erro ao criar diretório.",
                    icon: "error",
                    type: "error"
                });

            </script>
            <?php
            unset($_SESSION['mkdir_erro']);
        }
        ?>

        <?php
        if (isset($_SESSION['arqfoto_existe'])) {
            ?>
            <script>

                Swal.fire({
                    confirmButtonColor: '#7592a4',
                    title: "Erro!",
                    text: "Algum arquivo selecionado já existe no servidor!",
                    icon: "error",
                    type: "error"
                });

            </script>
            <?php
            unset($_SESSION['arqfoto_existe']);
        }
        ?>

        <?php
        if (isset($_SESSION['pg_criada'])) {
            ?>
            <script>

                Swal.fire({
                    confirmButtonColor: '#7592a4',
                    title: "Sucesso!",
                    text: "Produto criado!",
                    icon: "success",
                    type: "success"
                });

            </script>
            <?php
            unset($_SESSION['pg_criada']);
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
                                    <h1 class="visual-title visual-sub-title">Criar Produtos</h1>
                                    <div class="breadcrumb-block">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="administrador.php"> Administrador </a></li>
                                            <li class="breadcrumb-item active"> Criar Produtos </li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="content-block">
                    <div class="container">
                        <center><h6 class="content-title contact-title">Criar uma página de produto:</h6></center>
                        <div class="d-flex justify-content-center">
                            <div class="description text-center">                              
                                <div class="col col-lg-12">
                                    <form method='POST' action='processapgprod.php' enctype="multipart/form-data">
                                        <div id="corpo" class="text-wrap">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Texto URL:</label>
                                                    <input required class="form-control" type='text' name='nomearq' placeholder='Ex: nomeproduto'><br>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Nome do Produto:</label>
                                                    <input required class="form-control" type='text' name='nomeprod' placeholder='Ex: Nome do Produto'><br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Subtítulo:</label>
                                                    <input class="form-control" type='text' name='subprod' placeholder='(Opcional)'><br>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Categoria:</label>
                                                    <select required style="height: 50px;" class="form-control" name="tipo">
                                                        <option value="combos">Combos</option>
                                                        <option value="vestuario">Vestuário</option>
                                                        <option value="instrumentos">Instrumentos</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label>Valor:</label>
                                                    <input required class="form-control" type='text' name='valor' placeholder='Ex: 30'><br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label>Quantidade de Tipos de Produto:</label>
                                                    <input required class="form-control" type='number' id="qtd_prod" name='qtd_prod' placeholder='Ex: 1'><br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <button type="button" onclick="qtdProds();" class="btn-sm btn btn-primary">Ok</button>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <button type="button" onclick="zerar_prods();" class="btn-sm btn btn-primary">Limpar</button>
                                                    </div>
                                                </div>
                                            </div>      
                                            <div id="prods">
                                            </div>
                                            <br id="brP">
                                            <label for="descevento">Descrição do Produto:</label><br>
                                            <textarea id="descevento" name="descprod" rows="4" cols="50" required>Insira a descrição do produto aqui...</textarea><br><br>
                                            <input required class="form-control" type='text' name='desccur' placeholder='Descrição Curta'><br>
                                            <label>Imagem na Loja:</label> 
                                            <input required type="file" class="form-control col-md-12" name="imgq"><br>
                                            <div class="row">
                                                <div class="col-md-12">
                                                        <label>Quantidade de Fotos:</label>
                                                        <input required class="form-control" type="number" name="qtdfotos" id="qtd" placeholder='Ex: 1'>
                                                </div>           
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <button type="button" onclick="pegarQtd();" class="btn-sm btn btn-primary">Ok</button>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <button type="button" onclick="zerar();" class="btn-sm btn btn-primary">Limpar</button>
                                                    </div>
                                                </div>
                                            </div>      
                                        </div>
                                        <br>
                                        <input style='color: black;' type='submit' value='Enviar' class='btn'>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </section>               
            </main>
        </div>
        <script>
            var qtd_p = 0;
            var atv1 = false;
            document.getElementById('brP').style.display = "none";
            function qtdProds() {
                if (atv1 === false && document.getElementById("qtd_prod").value !== "") {
                    var qtd_prods = document.getElementById('qtd_prod').value;
                    qtd_p = qtd_prods;
                    geraInputsP();
                }
                if (document.getElementById("qtd_prod").value !== "") {
                    atv1 = true;
                }
            }

            function geraInputsP() {
                var cont = 0;
                var div = document.getElementById("prods");
                for (var i = 0; i < qtd_p; i++) {
                    cont++;
                    var row = document.createElement("div");
                    row.className = "row";
                    var div2 = document.createElement("div");
                    div2.className = "col-md-6";
                    var div3 = document.createElement("div");
                    div3.className = "col-md-6";
                    var input = document.createElement("input");
                    input.type = "text";
                    input.className = "form-control";
                    input.placeholder = "Nome";
                    input.id = "nome_prod" + cont;
                    input.name = "nome_prod" + i;
                    input.required = true;
                    var input2 = document.createElement("input");
                    input2.type = "number";
                    input2.className = "form-control";
                    input2.placeholder = "Estoque";
                    input2.id = "es_prod" + cont;
                    input2.name = "es_prod" + i;
                    input2.required = true;
                    var br = document.createElement("br");
                    br.id = "br_prod" + cont;
                    div.appendChild(br);
                    div.appendChild(row);
                    row.appendChild(div2);
                    div2.appendChild(input);
                    row.appendChild(div3);
                    div3.appendChild(input2);
                }
                document.getElementById('brP').style.display = "inherit";
            }

            function zerar_prods() {
                var cont = 0;
                for (var i = 0; i < qtd_p; i++) {
                    cont++;
                    inputid1 = "nome_prod" + cont;
                    var inputP1 = document.getElementById(inputid1);
                    inputP1.remove();
                    inputid2 = "es_prod" + cont;
                    var inputP2 = document.getElementById(inputid2);
                    inputP2.remove();
                    brid1 = "br_prod" + cont;
                    var brP = document.getElementById(brid1);
                    brP.remove();
                }
                document.getElementById('qtd_prod').value = "";
                document.getElementById('brP').style.display = "none";
                atv1 = false;
            }

            var qtd_a = 0;
            var atv2 = false;
            function pegarQtd() {
                if (atv2 === false) {
                    var qtd = document.getElementById('qtd').value;
                    qtd_a = qtd;
                    geraInputs();
                }
                if (document.getElementById("qtd").value !== "") {
                    atv2 = true;
                }
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
                    input.required = true;
                    var br = document.createElement("br");
                    br.id = "br" + cont;
                    div.appendChild(br);
                    div.appendChild(input);
                }
            }

            function zerar() {
                var cont = 0;
                for (var i = 0; i < qtd_a; i++) {
                    cont++;
                    inputid = "img" + cont;
                    var input1 = document.getElementById(inputid);
                    input1.remove();
                    brid = "br" + cont;
                    var br1 = document.getElementById(brid);
                    br1.remove();
                }
                document.getElementById('qtd').value = "";
                atv2 = false;
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


