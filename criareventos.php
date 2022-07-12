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
        <script src="https://rawgit.com/jackmoore/autosize/master/dist/autosize.min.js"></script>
    </head>

    <body>

        <?php
        if (isset($_SESSION['nomearq_existe'])) {
            ?>
            <script>

                Swal.fire({
                    confirmButtonColor: '#7592a4',
                    title: "Erro!",
                    text: "O nome de arquivo ou titulo digitado já existe!",
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
                    text: "Erro no upload das imagens! Utilize imagens em jpg apenas!",
                    icon: "error",
                    type: "error"
                });

            </script>
            <?php
            unset($_SESSION['arqfoto_erro']);
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
                    text: "Evento criado!",
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
        autosize(document.getElementById("descevento"));
    
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
                            <option class="inputform" value="loteutos">Loja</option>
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
                                    <h1 class="visual-title visual-sub-title">Criar Eventos</h1>
                                    <div class="breadcrumb-block">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="administrador.php"> Administrador </a></li>
                                            <li class="breadcrumb-item active"> Criar Eventos </li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="content-block">
                    <div class="container">
                        <center><h6 class="content-title contact-title">Criar um evento:</h6></center>
                        <div class="d-flex justify-content-center">
                            <div class="description text-center">                              
                                <div class="col col-lg-12">
                                    <form method='POST' action='processapg.php' enctype="multipart/form-data">
                                        <div class="text-wrap" id="corpo">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Texto URL:</label>
                                                    <input required value="<?php echo $_SESSION['nomearq_f']; ?>" class="form-control" type='text' name='nomearq' placeholder='Ex: nomeevento'><br>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Título:</label>
                                                    <input required value="<?php echo $_SESSION['titulo_f']; ?>" class="form-control" type='text' name='nomeevento' placeholder='Ex: Título do Evento'><br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="checkbox" id="data_m" name="data_m" value="1" onclick="multiDatas()">
                                                    <label for="teming">Datas Múltiplas</label><br>
                                                </div>
                                            </div>
                                            <div id="data1" class="row">
                                                <div class="col-md-6">
                                                    <label>Data:</label>
                                                    <input value="<?php echo $_SESSION['data1_f']; ?>" required class="form-control" type='date' id="data01" name='dataevento'><br>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Abertura das Portas:</label>
                                                    <input value="<?php echo $_SESSION['abertura_f']; ?>" required class="form-control" type='text' id="data02" name='abertura' placeholder='Ex: 18h'><br>
                                                </div>
                                            </div>
                                            <div id="data2" class="row">
                                                <div class="col-md-6">
                                                    <label>Data Inicial:</label>
                                                    <input value="<?php echo $_SESSION['data1_f']; ?>" required class="form-control" type='date' id="data03" name='data1'><br>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Data Final:</label>
                                                    <input value="<?php echo $_SESSION['data2_f']; ?>" required class="form-control" type='date' id="data04" name='data2'><br>
                                                </div>
                                            </div>
                                            <div id="data3" class="row">
                                                <div class="col-md-12">
                                                    <label>Abertura das Portas:</label>
                                                    <input value="<?php echo $_SESSION['abertura_f']; ?>" required class="form-control" type='text' id="data05" name='abertura2' placeholder='Ex: 18h'><br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Texto de Início:</label>
                                                    <input value="<?php echo $_SESSION['textoini_f']; ?>" required class="form-control" type='text' name='textoini' placeholder='Ex: O Show começará às:'><br>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Início do Evento:</label>
                                                    <input value="<?php echo $_SESSION['horaevento_f']; ?>" required class="form-control" type='text' name='horaevento' placeholder='Ex: 20h'><br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="checkbox" id="nteming" name="nteming" value="1">
                                                    <label for="teming">Sem Ingressos</label><br>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="checkbox" id="entfranca" name="entfranca" value="1">
                                                    <label for="entfranca">Entrada Franca</label><br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label>Link do Youtube:</label>
                                                    <input value="<?php echo $_SESSION['youtube_f']; ?>" class="form-control" type='text' name='link' placeholder='(Opcional)'><br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label>Quantidade de Lotes:</label>
                                                    <input required class="form-control" type='number' id="qtd_lote" name='qtd_lotes' placeholder='Ex: 2'><br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <button type="button" onclick="qtdLotes();" class="btn-sm btn btn-primary">Ok</button>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <button type="button" onclick="zerar_lotes();" class="btn-sm btn btn-primary">Limpar</button>
                                                    </div>
                                                </div>
                                            </div>      
                                            <div id="lotes">
                                            </div>
                                            <br id="brP">
                                            <label for="descevento">Descrição do Evento:</label><br>
                                            <textarea id="descevento" name="descevento" rows="4" cols="50" required><?php echo $_SESSION['desc_f']; ?></textarea><br><br>
                                            <label>Descrição Curta:</label>
                                            <input value="<?php echo $_SESSION['desccur_f']; ?>" required class="form-control" type='text' name='desccur' placeholder='Descrição curta do evento'><br>
                                            <label>Imagem na Agenda:</label>
                                            <input required type="file" class="form-control col-md-12" name="imgq"><br>                                           
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input required class="form-control" type="number" name="qtdfotos" id="qtd" placeholder='Quantidade de Fotos'>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <button type="button" id="btn_qtd" name="btn_qtd" onclick="pegarQtd();" class="btn-sm btn btn-primary">Ok</button>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <button type="button" id="btn_qtd" name="btn_qtd" onclick="zerar();" class="btn-sm btn btn-primary">Limpar</button>
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
            //datas INÍCIO
            
            const data01 = document.getElementById("data01");
            const data02 = document.getElementById("data02");
            const data03 = document.getElementById("data03");
            const data04 = document.getElementById("data04");
            const data05 = document.getElementById("data05");
            
            const data1 = document.getElementById("data1");
            const data2 = document.getElementById("data2");
            const data3 = document.getElementById("data3");
            
            data2.style.display = "none";
            data3.style.display = "none";
            data03.required = false;
            data04.required = false;
            data05.required = false;
        
            function multiDatas(){
                var data_m = document.getElementById("data_m");
                if (data_m.checked == true){
                data1.style.display = "none";
                data2.style.display = "flex";
                data3.style.display = "flex";
                data01.required = false;
                data02.required = false;
                data03.required = true;
                data04.required = true;
                data05.required = true;
              } else {
                data1.style.display = "flex";
                data2.style.display = "none";
                data3.style.display = "none";
                data01.required = true;
                data02.required = true;
                data03.required = false;
                data04.required = false;
                data05.required = false;
              }
            }
        
            //datas FIM
            var qtd_p = 0;
            var atv1 = false;
            document.getElementById('brP').style.display = "none";
            function qtdLotes() {
                if (atv1 === false && document.getElementById("qtd_lote").value !== "") {
                    var qtd_lotes = document.getElementById('qtd_lote').value;
                    qtd_p = qtd_lotes;
                    geraInputsP();
                }
                if (document.getElementById("qtd_lote").value !== "") {
                    atv1 = true;
                }
            }

            function geraInputsP() {
                var cont = 0;
                var div = document.getElementById("lotes");
                for (var i = 0; i < qtd_p; i++) {
                    cont++;
                    var row = document.createElement("div");
                    row.className = "row";
                    var row1 = document.createElement("div");
                    row1.className = "row";
                    var div2 = document.createElement("div");
                    div2.className = "col-md-4";
                    var div3 = document.createElement("div");
                    div3.className = "col-md-4";
                    var div4 = document.createElement("div");
                    div4.className = "col-md-4";
                    var div5 = document.createElement("div");
                    div5.className = "col-md-6";
                    var div6 = document.createElement("div");
                    div6.className = "col-md-6";
                    var input = document.createElement("input");
                    input.type = "text";
                    input.className = "form-control";
                    input.placeholder = "Nome";
                    input.id = "nome_lote" + cont;
                    input.name = "nome_lote" + i;
                    input.required = true;
                    var input2 = document.createElement("input");
                    input2.type = "date";
                    input2.className = "form-control";
                    input2.id = "data_lote" + cont;
                    input2.name = "data_lote" + i;
                    input2.required = true;
                    var input3 = document.createElement("input");
                    input3.type = "time";
                    input3.className = "form-control";
                    input3.id = "hora_lote" + cont;
                    input3.name = "hora_lote" + i;
                    input3.required = true;
                    var input4 = document.createElement("input");
                    input4.type = "number";
                    input4.className = "form-control";
                    input4.placeholder = "Quantidade Ingressos";
                    input4.id = "qtd_lote" + cont;
                    input4.name = "qtd_lote" + i;
                    input4.required = true;
                    var input5 = document.createElement("input");
                    input5.type = "number";
                    input5.className = "form-control";
                    input5.placeholder = "Valor";
                    input5.id = "valor_lote" + cont;
                    input5.name = "valor_lote" + i;
                    input5.required = true;
                    var br = document.createElement("br");
                    br.id = "br_lote" + cont;
                    var br2 = document.createElement("br");
                    br2.id = "br_lotee" + cont;
                    var br3 = document.createElement("br");
                    br3.id = "br_loteee" + cont;
                    div.appendChild(br);
                    div.appendChild(row);
                    row.appendChild(div2);
                    div2.appendChild(input);
                    row.appendChild(div3);
                    div3.appendChild(input2);
                    row.appendChild(div4);
                    div4.appendChild(input3);
                    div.appendChild(br2);
                    div.appendChild(row1);
                    row1.appendChild(div5);
                    div5.appendChild(input4);
                    row1.appendChild(div6);
                    div6.appendChild(input5);
                    div.appendChild(br3);
                }
                document.getElementById('brP').style.display = "inherit";
            }

            function zerar_lotes() {
                var cont = 0;
                for (var i = 0; i < qtd_p; i++) {
                    cont++;
                    inputid1 = "nome_lote" + cont;
                    var inputP1 = document.getElementById(inputid1);
                    inputP1.remove();
                    inputid2 = "qtd_lote" + cont;
                    var inputP2 = document.getElementById(inputid2);
                    inputP2.remove();
                    inputid3 = "valor_lote" + cont;
                    var inputP3 = document.getElementById(inputid3);
                    inputP3.remove();
                    inputid4 = "data_lote" + cont;
                    var inputP4 = document.getElementById(inputid4);
                    inputP4.remove();
                    inputid5 = "hora_lote" + cont;
                    var inputP5 = document.getElementById(inputid5);
                    inputP5.remove();
                    brid1 = "br_lote" + cont;
                    var brP = document.getElementById(brid1);
                    brP.remove();
                    brid2 = "br_lotee" + cont;
                    var brP1 = document.getElementById(brid2);
                    brP1.remove();
                    brid3 = "br_loteee" + cont;
                    var brP2 = document.getElementById(brid3);
                    brP2.remove();
                }
                document.getElementById('qtd_lote').value = "";
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
                    document.getElementById("qtd").value = "";
                }
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


