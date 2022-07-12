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
        <title>Editar Cardápio</title>
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
                                        if(!isset($_GET['tipo']) and !isset($_GET['edit_cat']) and !isset($_GET['add_item']) and !isset($_GET['add_tipo']) and !isset($_GET['edit_tipo'])){
                                        ?>
                                        <center><h6 class="content-title contact-title">Categorias:</h6></center>
                                        <?php
                                        }elseif(isset($_GET['tipo'])){
                                        ?>
                                        <center><h6 class="content-title contact-title">Editar Categoria <?php echo $_GET['tipo']; ?>:</h6></center>    
                                        <?php
                                        }elseif(isset($_GET['add_item'])){
                                         ?>
                                        <center><h6 class="content-title contact-title">Adicionar Novo(a) <?php echo $_GET['add_item']; ?>:</h6></center>    
                                        <?php    
                                        }elseif(isset($_GET['edit_cat']) or isset($_GET['edit_tipo'])){
                                        ?>
                                        <center><h6 class="content-title contact-title">Editar Categorias:</h6></center>    
                                        <?php    
                                        }elseif(isset($_GET['add_tipo'])){
                                        ?>
                                        <center><h6 class="content-title contact-title">Adicionar Categoria:</h6></center>    
                                        <?php     
                                        }
                                        
                                    ?>
                                    
                                    <?php
                                     if(!isset($_GET['tipo']) and !isset($_GET['edit_cat']) and !isset($_GET['add_item']) and !isset($_GET['del_item']) and !isset($_GET['add_tipo']) and !isset($_GET['edit_tipo'])){
                                    ?>
                                    <form method='GET' action='editarcardapio.php' enctype="multipart/form-data">
                                        <div class="text-wrap">
                                        <?php
                                            $sql = "select * from categorias ORDER BY nome ASC";

                                            $resultado = $con->query($sql);

                                            if ($resultado->num_rows > 0) {
                                            while ($row = $resultado->fetch_assoc()) {
                                              $input = "<div class='row'>
                                                            <div class='col-md-12'>
                                                                <button name='tipo' style='color: black;' type='submit' value='".$row["nome"]."' class='btn'>".$row["nome"]."</button>
                                                            </div>
                                                        </div>
                                                        <br>";
                                             
                                              echo $input;
                                              
                                                }
                                            }
                                        ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button name="edit_cat" style='color: white;' type='submit' value='Editar' class='btn btn-secondary'>Editar Categorias</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    
                                    <br>
                                    
                                    <?php
                                     }
                                    if(isset($_GET['tipo']) and !isset($_GET['edit_item'])){
                                        
                                    $sql = "select distinct tipo from cardapio";

                                    $resultado = $con->query($sql);

                                    if ($resultado->num_rows > 0) {
                                    while ($row = $resultado->fetch_assoc()) {
                                      if($_GET["tipo"] == $row["tipo"]) {
                                                      
                                                    $sql2 = 'select * from cardapio WHERE tipo = "'.$row["tipo"].'" ORDER BY nome ASC';
    
                                                    $resultado2 = $con->query($sql2);
                
                                                    if ($resultado2->num_rows > 0) {
                                                        while ($row2 = $resultado2->fetch_assoc()) {
                                                          echo "<br><form method='GET' action='editarcardapio.php' enctype='multipart/form-data'>
                                                                    <input type='hidden' name='tipo' value='".$row["tipo"]."'>
                                                                    <div class='text-wrap'>
                                                                        <div class='row'>
                                                                            <div class='col-md-12'>
                                                                                <h4>".$row2["nome"]."</h4>
                                                                            </div>
                                                                        </div>
                                                                        <div class='row'>
                                                                            <div class='col-md-6'>
                                                                                <button name='edit_item' style='background-color: blue; border-color: blue; color: white;' type='submit' value='".$row2["nome"]."' class='btn-sm btn'>Editar</button>
                                                                            </div>
                                                                            <div class='col-md-6'>
                                                                                <button name='del_item' style='background-color: red; border-color: red; color: white;' type='submit' value='".$row2["nome"]."' class='btn-sm btn'>Deletar</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form><br>";
                                                        }
                                                    }
                                                  
                                                }
                                            }
                                        }
                                        echo "<br>";
                                        echo "<form method='GET' action='editarcardapio.php' enctype='multipart/form-data'>
                                                            <div class='text-wrap'>
                                                                <div class='row'>
                                                                    <div class='col-md-12'>
                                                                        <button name='add_item' style='background-color: green; border-color: green; color: white;' type='submit' value='".$_GET["tipo"]."' class='btn'>Adicionar Item</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form><br>";
                                                    
                                          echo "<form method='GET' action='editarcardapio.php' enctype='multipart/form-data'>
                                                    <div class='text-wrap'>
                                                        <div class='row'>
                                                            <div class='col-md-12'>
                                                                <input name='voltar' style='color: white;' type='submit' value='Voltar' class='btn btn-secondary'>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>";
                                        
                                    }
                                    
                                    if(isset($_GET['add_item'])){

                                      echo "<br><form method='GET' action='editarcardapio.php' enctype='multipart/form-data'>
                                                <div class='text-wrap'>
                                                    <div class='row'>
                                                        <div class='col-md-12'>
                                                            <label>Nome:</label>
                                                            <input required name='nome_item' type='text' class='form-control' placeholder='Insira o nome aqui'>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class='row'>
                                                        <div class='col-md-12'>
                                                            <button name='env_item' style='background-color: green; border-color: green; color: white;' type='submit' value='".$_GET['add_item']."' class='btn-sm btn'>Adicionar Item</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form><br>";
                                     echo "<form method='GET' action='editarcardapio.php' enctype='multipart/form-data'>
                                            <div class='text-wrap'>
                                                <div class='row'>
                                                    <div class='col-md-12'>
                                                        <button name='voltar_add' style='color: white;' type='submit' value='".$_GET['add_item']."' class='btn-sm btn btn-secondary'>Voltar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>";        
                                            
                                    }
                                    
                                    if(isset($_GET['edit_item'])){
                                        
                                      $nome = $_GET['edit_item'];
                                      $tipo = $_GET['tipo'];

                                      echo "<br><form method='GET' action='editarcardapio.php' enctype='multipart/form-data'>
                                                <div class='text-wrap'>
                                                    <div class='row'>
                                                        <div class='col-md-12'>
                                                            <label>Nome:</label>
                                                            <input required name='nome_item' type='text' class='form-control' value='".$nome."' placeholder='Insira o nome aqui'>
                                                        </div>
                                                            <input name='tipo_item' type='hidden' class='form-control' value='".$tipo."'>
                                                    </div>
                                                    <br>
                                                    <div class='row'>
                                                        <div class='col-md-12'>
                                                            <button name='env_item_edit' style='background-color: green; border-color: green; color: white;' type='submit' value='".$nome."' class='btn-sm btn'>Editar Item</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form><br>";
                                     echo "<form method='GET' action='editarcardapio.php' enctype='multipart/form-data'>
                                            <div class='text-wrap'>
                                                <div class='row'>
                                                    <div class='col-md-12'>
                                                        <button name='voltar_add' style='color: white;' type='submit' value='".$tipo."' class='btn-sm btn btn-secondary'>Voltar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>";        
                                            
                                    }
                                    
                                    if(isset($_GET['voltar_add'])){
                                      
                                      $tipo = $_GET['voltar_add'];
                                      
                                      ?><script>window.location.replace('https://gravadorpub.com.br/editarcardapio.php?tipo=<?php echo $tipo; ?>');</script><?php
                                            
                                    }
                                    
                                    if(isset($_GET['env_item'])){
                                        
                                      $nome = $_GET['nome_item'];
                                      $tipo = $_GET['env_item'];

                                      $sql_insert = "INSERT INTO cardapio (nome, tipo) VALUES ('$nome', '$tipo')";
                                      $con->query($sql_insert);
                                        
                                      ?>
                                        <script>
                                            Swal.fire({
                                                confirmButtonColor: '#7592a4',
                                                title: "Sucesso!",
                                                text: "Item Adicionado!",
                                                icon: "success",
                                                type: "success"
                                            }).then(function() {
                                                window.location.replace('https://gravadorpub.com.br/editarcardapio.php?tipo=<?php echo $tipo; ?>');
                                            });
                                        </script>
                                      <?php
                                            
                                    }
                                    
                                    if(isset($_GET['env_item_edit'])){
                                        
                                      $nomeold = $_GET['env_item_edit'];  
                                      $nome = $_GET['nome_item'];
                                      $tipo = $_GET['tipo_item'];

                                      $sql_insert = "UPDATE cardapio SET nome = '$nome', tipo = '$tipo' WHERE nome = '$nomeold'";
                                      $con->query($sql_insert);
                                        
                                      ?>
                                        <script>
                                            Swal.fire({
                                                confirmButtonColor: '#7592a4',
                                                title: "Sucesso!",
                                                text: "Item Editado!",
                                                icon: "success",
                                                type: "success"
                                            }).then(function() {
                                                window.location.replace('https://gravadorpub.com.br/editarcardapio.php?tipo=<?php echo $tipo; ?>');
                                            });
                                        </script>
                                      <?php
                                            
                                    }
                                    
                                    if(isset($_GET['del_item'])){
                                        $tipo = $_GET['tipo'];
                                        $sql_del = "DELETE FROM cardapio WHERE nome = '".$_GET['del_item']."'";
                                        $con->query($sql_del);
                                        
                                        ?>
                                        <script>
                                            Swal.fire({
                                                confirmButtonColor: '#7592a4',
                                                title: "Sucesso!",
                                                text: "Item Deletado!",
                                                icon: "success",
                                                type: "success"
                                            }).then(function() {
                                                window.location.replace('https://gravadorpub.com.br/editarcardapio.php?tipo=<?php echo $tipo; ?>');
                                            });
                                        </script>
                                      <?php
                                        
                                    }
                                    
                                    if(isset($_GET['edit_cat'])){
                                        
                                    $sql = "select * from categorias";

                                    $resultado = $con->query($sql);

                                    if ($resultado->num_rows > 0) {
                                    while ($row = $resultado->fetch_assoc()) {

                                          echo "<br><form method='GET' action='editarcardapio.php' enctype='multipart/form-data'>
                                                    <div class='text-wrap'>
                                                        <div class='row'>
                                                            <div class='col-md-12'>
                                                                <h4>".$row["nome"]."</h4><br>
                                                            </div>
                                                        </div> 
                                                        <div class='row'>
                                                            <div class='col-md-6'>
                                                                <button name='edit_tipo' style='background-color: blue; border-color: blue; color: white;' type='submit' value='".$row["nome"]."' class='btn-sm btn'>Editar</button>
                                                            </div>
                                                            <div class='col-md-6'>
                                                                <button name='del_tipo' style='background-color: red; border-color: red; color: white;' type='submit' value='".$row["nome"]."' class='btn-sm btn'>Deletar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form><br>";
                                                        
                                            }
                                        }
                                     echo "<br>";  
                                     echo "<form method='GET' action='editarcardapio.php' enctype='multipart/form-data'>
                                                <div class='text-wrap'>
                                                    <div class='row'>
                                                        <div class='col-md-12'>
                                                            <button name='add_tipo' style='background-color: green; border-color: green; color: white;' type='submit' value='".$_GET['edit_cat']."' class='btn'>Adicionar Item</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form><br>";
                                        
                                      echo "<form method='GET' action='editarcardapio.php' enctype='multipart/form-data'>
                                                <div class='text-wrap'>
                                                    <div class='row'>
                                                        <div class='col-md-12'>
                                                            <input name='voltar' style='color: white;' type='submit' value='Voltar' class='btn btn-secondary'>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>";
                                        
                                    }
                                    
                                    if(isset($_GET['add_tipo'])){

                                      echo "<br><form method='GET' action='editarcardapio.php' enctype='multipart/form-data'>
                                                <div class='text-wrap'>
                                                    <div class='row'>
                                                        <div class='col-md-12'>
                                                            <label>Nome:</label>
                                                            <input required name='nome_tipo' type='text' class='form-control' placeholder='Insira o nome aqui'>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class='row'>
                                                        <div class='col-md-12'>
                                                            <button name='env_tipo' style='background-color: green; border-color: green; color: white;' type='submit' value='Add' class='btn-sm btn'>Adicionar Categoria</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form><br>";
                                     echo "<form method='GET' action='editarcardapio.php' enctype='multipart/form-data'>
                                            <div class='text-wrap'>
                                                <div class='row'>
                                                    <div class='col-md-12'>
                                                        <button name='voltar_tipo' style='color: white;' type='submit' value='".$_GET['add_item']."' class='btn-sm btn btn-secondary'>Voltar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>";        
                                            
                                    }
                                    
                                    if(isset($_GET['edit_tipo'])){
                                        
                                      $nome = $_GET['edit_tipo'];

                                      echo "<br><form method='GET' action='editarcardapio.php' enctype='multipart/form-data'>
                                                <div class='text-wrap'>
                                                    <div class='row'>
                                                        <div class='col-md-12'>
                                                            <label>Nome:</label>
                                                            <input required name='nome_tipo' type='text' class='form-control' value='".$nome."' placeholder='Insira o nome aqui'>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class='row'>
                                                        <div class='col-md-12'>
                                                            <button name='env_tipo_edit' style='background-color: green; border-color: green; color: white;' type='submit' value='".$_GET['edit_tipo']."' class='btn-sm btn'>Editar Categoria</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form><br>";
                                     echo "<form method='GET' action='editarcardapio.php' enctype='multipart/form-data'>
                                            <div class='text-wrap'>
                                                <div class='row'>
                                                    <div class='col-md-12'>
                                                        <button name='voltar_tipo' style='color: white;' type='submit' value='".$tipo."' class='btn-sm btn btn-secondary'>Voltar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>";        
                                            
                                    }
                                    
                                    if(isset($_GET['voltar_tipo'])){
                                      
                                      $tipo = $_GET['voltar_tipo'];
                                      
                                      ?><script>window.location.replace('https://gravadorpub.com.br/editarcardapio.php?edit_cat=Editar');</script><?php
                                            
                                    }
                                    
                                    if(isset($_GET['env_tipo'])){
                                        
                                      $nome = $_GET['nome_tipo'];

                                      $sql_insert = "INSERT INTO categorias (nome) VALUES ('$nome')";
                                      $con->query($sql_insert);
                                        
                                      ?>
                                        <script>
                                            Swal.fire({
                                                confirmButtonColor: '#7592a4',
                                                title: "Sucesso!",
                                                text: "Categoria Adicionada!",
                                                icon: "success",
                                                type: "success"
                                            }).then(function() {
                                                window.location.replace('https://gravadorpub.com.br/editarcardapio.php?edit_cat=Editar');
                                            });
                                        </script>
                                      <?php
                                            
                                    }
                                    
                                    if(isset($_GET['env_tipo_edit'])){
                                        
                                      $nomeold = $_GET['env_tipo_edit'];  
                                      $nome = $_GET['nome_tipo'];

                                      $sql_insert = "UPDATE categorias SET nome = '$nome' WHERE nome = '$nomeold'";
                                      $con->query($sql_insert);
                                      
                                      $sql_insert = "UPDATE cardapio SET tipo = '$nome' WHERE tipo = '$nomeold'";
                                      $con->query($sql_insert);
                                        
                                      ?>
                                        <script>
                                            Swal.fire({
                                                confirmButtonColor: '#7592a4',
                                                title: "Sucesso!",
                                                text: "Categoria Editada!",
                                                icon: "success",
                                                type: "success"
                                            }).then(function() {
                                                window.location.replace('https://gravadorpub.com.br/editarcardapio.php?edit_cat=Editar');
                                            });
                                        </script>
                                      <?php
                                            
                                    }
                                    
                                    if(isset($_GET['del_tipo'])){
                                        $tipo = $_GET['tipo'];
                                        
                                        $sql_del = "DELETE FROM cardapio WHERE tipo = '".$_GET['del_tipo']."'";
                                        $con->query($sql_del);
                                        
                                        $sql_del = "DELETE FROM categorias WHERE nome = '".$_GET['del_tipo']."'";
                                        $con->query($sql_del);
                                        
                                        ?>
                                        <script>
                                            Swal.fire({
                                                confirmButtonColor: '#7592a4',
                                                title: "Sucesso!",
                                                text: "Categoria Deletada!",
                                                icon: "success",
                                                type: "success"
                                            }).then(function() {
                                                window.location.replace('https://gravadorpub.com.br/editarcardapio.php?edit_cat=Editar');
                                            });
                                        </script>
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


