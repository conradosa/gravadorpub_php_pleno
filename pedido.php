<?php
session_start();
require('conexao.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>Pedido</title>
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
                <section class="content-block">
                    <div class="container">
                        <div class="d-flex justify-content-center">
                            <div class="description text-center">                              
                                <div class="col col-lg-12">
                                    <?php
                                    if(!isset($_GET['finalizar'])){
                                    if(!isset($_GET['continuar']) and !isset($_GET['finalizar']) and !isset($_GET['add']) and !isset($_GET['tipo'])){
                                    ?>
                                    <center><h6 class="content-title contact-title">Faça seu Pedido:</h6></center>
                                    <?php
                                    }elseif(!isset($_GET['add'])){
                                    ?>
                                    <center><h6 class="content-title contact-title">Adicione ao seu Pedido:</h6></center>
                                    <?php
                                    }
                                    if(isset($_GET['add'])){
                                    ?>
                                    <center><h6 class="content-title contact-title">Confira seu Pedido:</h6></center>
                                    <?php
                                    }
                                    }else{
                                        ?>
                                        <center><h6 class="content-title contact-title">Confira seu Pedido:</h6></center>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    
                                        function mostraArray($a){
                                            for($i = 0; $i < sizeof($a); $i++){
                                                return $a[$i];
                                            }
                                        }
                                        
                                        if(isset($_GET['mesa'])){
                                            $_SESSION['mesa'] = $_GET['mesa'];
                                            $_SESSION['item'] = array();
                                            $_SESSION['qtd'] = array();
                                        }
                                        
                                        if(isset($_POST['enviar'])){
                                            //Insert Itens Pedido
                                            $cod = md5(uniqid(rand(), true));
                                            for($i = 0; $i < sizeof($_SESSION['item']); $i++){
                                                $item = $_SESSION['item'][$i];
                                                $qtd = $_SESSION['qtd'][$i];
                                                $sql_insert = "INSERT INTO item_pedido (pedido_cod, nome, quantidade) VALUES ('$cod', '$item', '$qtd')";
                                                $con->query($sql_insert);
                                            }
                                            
                                            //Insert Pedido
                                            $mesa = $_SESSION['mesa'];
                                            $obs = $_POST['observacao'];
                                            $sql_insert = "INSERT INTO pedidos (mesa, observacao, data, ok, cod) VALUES ('$mesa', '$obs', NOW(), '0', '$cod')";
                                            $con->query($sql_insert);
                                            ?>
                                            <script>
                                
                                                Swal.fire({
                                                    confirmButtonColor: '#7592a4',
                                                    title: "Sucesso!",
                                                    text: "Pedido Realizado!",
                                                    icon: "success",
                                                    type: "success"
                                                }).then(function() {
                                                    window.location.replace("https://gravadorpub.com.br/pedido.php?limpar=Cancelar+Pedido");
                                                });
                                                
                                            </script>
                                            <?php
                                        }
                                        
                                        if(isset($_GET['limpar'])){
                                            unset($_SESSION['item']);
                                            unset($_SESSION['qtd']);
                                            $_SESSION['item'] = array();
                                            $_SESSION['qtd'] = array();
                                        }
                                        
                                        if(isset($_GET['item'])){
                                        
                                            $item = $_GET['item'];
                                            $qtd = $_GET['qtd'];
                                            
                                            array_push($_SESSION['item'],$item);
                                            array_push($_SESSION['qtd'],$qtd);
                                            
                                        }
                                        
                                    ?>
                                    
                                    <?php
                                     if(!isset($_GET['tipo']) and !isset($_GET['finalizar']) and !isset($_GET['add'])){
                                    ?>
                                    <form method='GET' action='pedido.php' enctype="multipart/form-data">
                                        <div class="text-wrap">
                                        <?php
                                            $sql = "select * from categorias";

                                            $resultado = $con->query($sql);

                                            if ($resultado->num_rows > 0) {
                                            while ($row = $resultado->fetch_assoc()) {
                                              $input = "<div class='row'>
                                                            <div class='col-md-12'>
                                                                <button name='tipo' style='color: black;' type='submit' value='".$row["nome"]."' class='btn'>Pedir ".$row["nome"]."</button>
                                                            </div>
                                                        </div>
                                                        <br>";
                                             
                                              echo $input;
                                              
                                                }
                                            }
                                        ?>
                                            <?php
                                            if(sizeof($_SESSION['item']) >= 1){
                                            ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input name="add" style='color: white;' type='submit' value='Voltar' class='btn btn-secondary'>
                                                </div>
                                            </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </form>
                                    
                                    <br>
                                    
                                    <?php
                                     }
                                    if(isset($_GET['tipo'])){
                                        
                                    $sql = "select * from categorias";

                                    $resultado = $con->query($sql);

                                    if ($resultado->num_rows > 0) {
                                    while ($row = $resultado->fetch_assoc()) {
                                      if($_GET["tipo"] == $row["nome"]) {
                                                $options = array();
                                                  
                                                $sql2 = 'select * from cardapio WHERE tipo = "'.$row["nome"].'"';

                                                $resultado2 = $con->query($sql2);
            
                                                if ($resultado2->num_rows > 0) {
                                                    while ($row2 = $resultado2->fetch_assoc()) {
                                                      $option = '<option value="'.$row2["nome"].'">'.$row2["nome"].'</option>';
                                                      array_push($options,$option);
                                                    }
                                                }
                                                
                                                    $a = implode(" ",$options);
                                                
                                                  echo "<form method='GET' action='pedido.php' enctype='multipart/form-data'>
                                                        <div class='text-wrap'>
                                                            <div class='row'>
                                                                <div class='col-md-12'>
                                                                    <label>Escolha o(a) ".$row["nome"].":</label>
                                                                    <select required class='form-control' name='item'>
                                                                        ".$a."
                                                                    </select><br>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class='row'>
                                                                <div class='col-md-12'>
                                                                    <label>Quantidade:</label>
                                                                    <input required name='qtd' type='number' placeholder='Quantidade' class='form-control'>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class='row'>
                                                                <div class='col-md-12'>
                                                                    <input name='add' style='color: black;' type='submit' value='Adicionar ao Pedido' class='btn-sm btn'>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>";
                                                    
                                                echo"<br><h4 style='color: red'>*Se necessário especifique os detalhes do pedido no campo <b>observações</b> após finalizar o pedido.</h4>";
                                                    
                                                }
                                            }
                                        }
                                        
                                      echo "<br>
                                            <form method='GET' action='pedido.php' enctype='multipart/form-data'>
                                                <div class='text-wrap'>
                                                    <div class='row'>
                                                        <div class='col-md-12'>
                                                            <input name='limpar' style='color: white;' type='submit' value='Voltar' class='btn-sm btn btn-secondary'>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>";
                                        
                                    }
                                     
                                     if(!isset($_GET['tipo'])){
                                         if(isset($_GET['finalizar'])){
                                             if(sizeof($_SESSION['item']) >= 1){
                                                for($i = 0; $i < sizeof($_SESSION['item']); $i++){
                                                    echo "<h4>".$_SESSION['qtd'][$i]."x - ".$_SESSION['item'][$i]."</h4><br>";
                                                }
                                             }
                                         }
                                         if(isset($_GET['add'])){
                                             if(sizeof($_SESSION['item']) >= 1){
                                                for($i = 0; $i < sizeof($_SESSION['item']); $i++){
                                                    echo "<h4>".$_SESSION['qtd'][$i]."x - ".$_SESSION['item'][$i]."</h4><br>";
                                                }     
                                             }
                                        ?>
                                        <?php
                                            if(!isset($_GET['finalizar'])){
                                        ?>
                                        
                                        <?php
                                        if(sizeof($_SESSION['item']) >= 1){
                                        ?>
                                        
                                            <form method='GET' action='pedido.php' enctype="multipart/form-data">
                                                <div class="text-wrap">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <input name="continuar" style='background-color: blue; color: white; border-color: blue;' type='submit' value='Continuar Pedido' class='btn btn-primary'>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            
                                            <br>
                                        
                                            <form method='GET' action='pedido.php' enctype="multipart/form-data">
                                                <div class="text-wrap">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <input name="finalizar" style='background-color: green; color: white; border-color: green;' type='submit' value='Finalizar Pedido' class='btn btn-primary'>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                            <br>
                                            
                                            <form method='GET' action='pedido.php' enctype="multipart/form-data">
                                                <div class="text-wrap">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <input name="limpar" style='color: white;' type='submit' value='Cancelar Pedido' class='btn btn-secondary'>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        <?php
                                    }
                                }
                            }
                        }  
                                if(isset($_GET['finalizar'])){
                                         ?>
                                            <form method='POST' action='pedido.php' enctype="multipart/form-data">
                                                <div class="text-wrap">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>Observações:</label>
                                                            <textarea name="observacao" class="form-control" placeholder="Observações (Opcional)" rows="4" cols="50"></textarea>
                                                        </div>
                                                    </div>
                                                    <br><br>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <input name="enviar" style='background-color: green; color: white; border-color: green;' type='submit' value='Enviar Pedido' class='btn btn-primary'>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <br>
                                            <form method='GET' action='pedido.php' enctype="multipart/form-data">
                                                <div class="text-wrap">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <input name="limpar" style='color: white;' type='submit' value='Cancelar Pedido' class='btn btn-secondary'>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        <?php
                                     }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>               
            </main>
        </div>
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


