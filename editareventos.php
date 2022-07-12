<?php
include('verifica_admin.php');

//Valores Página:

$id = $_POST['id'];
$nomearq = $_POST['nomearq'];
$nomearqedit = $_POST['nomearqedit'];
$titulo = $_POST['titulo'];
$data = $_POST['data'];
$datacrua = $_POST['datacrua'];
$date1 = $_POST['date1'];
$date2 = $_POST['date2'];
$dia = $_POST['dia'];
$abertura = $_POST['abertura'];
$textoini = $_POST['textoini'];
$hora = $_POST['hora'];
$preco = $_POST['preco'];
$valor = $_POST['valor'];
$qtd_ing = $_POST['qtd_ing'];
$link = $_POST['link'];
$descricao = $_POST['descricao'];
$desccur = $_POST['desccur'];
$nteming = $_POST['nteming'];
$entfranca = $_POST['entfranca'];
$data_m = $_POST['data_m'];

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
                                    <h1 class="visual-title visual-sub-title">Editar Eventos</h1>
                                    <div class="breadcrumb-block">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="administrador.php"> Administrador </a></li>
                                            <li class="breadcrumb-item active"> Editar Eventos </li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="content-block">
                    <div class="container">
                        <center><h6 class="content-title contact-title">Editar evento:</h6></center>
                        <div class="d-flex justify-content-center">
                            <div class="description text-center">                              
                                <div class="col col-lg-12">
                                    <form action="alterarlotes.php" method="POST">
                                        <input value="<?php echo $nomearq; ?>" type="hidden" name="nomearq">
                                        <input style='color: black;' type='submit' value='Editar Lotes' class='btn'>
                                    </form><br><br>
                                    <form method='POST' action='processapgedit.php' enctype="multipart/form-data">
                                        <div class="text-wrap" id="corpo">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Texto URL:</label>
                                                    <input required class="form-control" type='text' value='<?php echo $nomearqedit; ?>' name='nomearqedit' placeholder='URL'><br>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Título:</label>
                                                    <input required class="form-control" type='text' value='<?php echo $titulo; ?>' name='nomeevento' placeholder='Titulo (Nome)'><br>
                                                </div>
                                            </div>
                                            <?php if($data_m == 0){ ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="checkbox" id="data_m" name="data_m" value="1" onclick="multiDatas()">
                                                    <label for="teming">Datas Múltiplas</label><br>
                                                </div>
                                            </div>
                                            <?php }else{ ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="checkbox" id="data_m" name="data_m" value="1" onclick="multiDatas()" checked>
                                                    <label for="teming">Datas Múltiplas</label><br>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <div id="data1" class="row">
                                                <div class="col-md-6">
                                                    <label>Data:</label>
                                                    <input required class="form-control" type='date' value='<?php echo $date1; ?>' id="data01" name='dataevento'><br>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Abertura das Portas:</label>
                                                    <input required class="form-control" type='text' value='<?php echo $abertura; ?>' name='abertura' id="data02" placeholder='Ex: 18h'><br>
                                                </div>
                                            </div>
                                            <div id="data2" class="row">
                                                <div class="col-md-6">
                                                    <label>Data Inicial:</label>
                                                    <input required class="form-control" type='date' value='<?php echo $date1; ?>' id="data03" name='data1'><br>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Data Final:</label>
                                                    <input required class="form-control" type='date' value='<?php echo $date2; ?>' id="data04" name='data2'><br>
                                                </div>
                                            </div>
                                            <div id="data3" class="row">
                                                <div class="col-md-12">
                                                    <label>Abertura das Portas:</label>
                                                    <input required class="form-control" type='text' value='<?php echo $abertura; ?>' id="data05" name='abertura2' placeholder='Ex: 18h'><br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Texto de Início:</label>
                                                    <input required class="form-control" type='text' value='<?php echo $textoini; ?>' name='textoini' placeholder='Texto Inicio Evento'><br>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Início do Evento:</label>
                                                    <input required class="form-control" type='text' value='<?php echo $hora; ?>' name='horaevento' placeholder='Hora (Das 18 às 17 horas)'><br>
                                                </div>
                                            </div>
                                            <?php if($nteming == 1 and $entfranca == 0){ ?>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Ingressos:</label><br>
                                                    <select required style="height: 50px;" class="form-control" id="nteming" name="nteming">
                                                        <option value="0">Sim</option>
                                                        <option value="1" selected>Não</option>
                                                    </select><br>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Entrada Franca:</label><br>
                                                    <select required style="height: 50px;" class="form-control" id="entfranca" name="entfranca">
                                                        <option value="1">Sim</option>
                                                        <option value="0" selected>Não</option>
                                                    </select><br>
                                                </div>
                                            </div>
                                            <?php }if($nteming == 0 and $entfranca == 0){ ?>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Ingressos:</label><br>
                                                    <select required style="height: 50px;" class="form-control" id="nteming" name="nteming">
                                                        <option value="0" selected>Sim</option>
                                                        <option value="1">Não</option>
                                                    </select><br>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Entrada Franca:</label><br>
                                                    <select required style="height: 50px;" class="form-control" id="entfranca" name="entfranca">
                                                        <option value="1">Sim</option>
                                                        <option value="0" selected>Não</option>
                                                    </select><br>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <?php if($nteming == 0 and $entfranca == 1){ ?>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Ingressos:</label><br>
                                                    <select required style="height: 50px;" class="form-control" id="nteming" name="nteming">
                                                        <option value="0" selected>Sim</option>
                                                        <option value="1">Não</option>
                                                    </select><br>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Entrada Franca:</label><br>
                                                    <select required style="height: 50px;" class="form-control" id="entfranca" name="entfranca">
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    </select><br>
                                                </div>
                                            </div>
                                            <?php } if($nteming == 1 and $entfranca == 1){ ?>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Ingressos:</label><br>
                                                    <select required style="height: 50px;" class="form-control" id="nteming" name="nteming">
                                                        <option value="0">Sim</option>
                                                        <option value="1" selected>Não</option>
                                                    </select><br>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Entrada Franca:</label><br>
                                                    <select required style="height: 50px;" class="form-control" id="entfranca" name="entfranca">
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    </select><br>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label>Link do Youtube:</label>
                                                    <input class="form-control" type='text' value='<?php echo $link; ?>' name='link' placeholder='Link do Youtube'><br>
                                                </div>
                                            </div>
                                            <label for="descevento">Descrição do Evento:</label><br>
                                            <textarea style="text-align:left;" id="descevento" name="descevento" rows="4" cols="50" required><?php echo $descricao; ?></textarea><br><br>
                                            <label>Descrição Curta:</label>
                                            <input required class="form-control" type='text' value='<?php echo $desccur; ?>' name='desccur' placeholder='Descrição Curta'><br>
                                            <label>Imagem na Agenda:</label>
                                            <input type="file" class="form-control col-md-12" name="imgq"><br>                                           
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input class="form-control" type="number" name="qtdfotos" id="qtd" placeholder='Quantidade de Fotos'>
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
                                        <input type='hidden' name='id' value='<?php echo $id; ?>'>
                                        <input type='hidden' name='nomearq' value='<?php echo $nomearq; ?>'>
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
        <?php if($data_m == 1){ ?>
        <script>multiDatas();</script>
        <?php } ?>
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


