<?php
session_start();
$_SESSION['pg_atual'] = 'home.php';
require('conexao.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta name="Description" content="O Gravador Pub está localizado em uma casa centenária, construída no início do século XX, na Rua Conde de Porto Alegre, 22. Um lugar de resistencia da boa música, da preservação do patrimonio público e da valorização de músicos e artistas.">
        <meta name="robots" content="index, follow">
        <meta name="keywords" content="Gravador Pub, gravador pub, gravador, pub, Gravador, Pub, Porto Alegre, porto alegre, porto, alegre, bebidas, shows, casa de shows, ao vivo">
        <meta property="og:image" content="img/AmigosFoto1.jpg" />
        <title>Gravador Pub</title>
        <link rel="shortcut icon" href="img/gravador.gif" >
        <link media="all" rel="stylesheet" href="css/fonts/icomoon/icomoon.css">
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

    <body class="white-overlay">
        
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

    <div id="wrapper" class="no-overflow-x" data-role="page">
        <div class="page-wrapper">
            <header class="fixed-top main-header header-white transparent with-side-panel-ico" id="waituk-main-header">
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
                        <input class="txt inputform" name="txt_pesq" placeholder="Digite aqui" type="text">
                        <input style="display:none;" type="submit" class="sub inputform" value="Ok">                                   
                    </form>
                </div>               
            </header>              

            <main>
                <div class="banner banner-home">
                    <div id="rev_slider_279_1_wrapper" class="rev_slider_wrapper fullscreen-container" data-alias="restaurant-header" style="margin:0px auto;background-color:#fff;padding:0px;margin-top:0px;margin-bottom:0px;">
                        <div id="rev_slider_70_1" class="rev_slider fullscreenabanner" style="display:none;" data-version="5.1.4">
                            <ul>
                                <li class="slider-color-schema-dark" data-index="rs-2" data-transition="fade" data-slotamount="7" data-easein="default" data-easeout="default" data-masterspeed="1000" data-rotate="0" data-saveperformance="off" data-title="Slide" data-description="">
                                    <img src="img/GravadorFoto2.jpg" alt="Imagem Gravador Pub" data-bgposition="center center" data-kenburns="on" data-duration="30000" data-ease="Linear.easeNone" data-scalestart="100" data-scaleend="120" data-rotatestart="0" data-rotateend="0" data-offsetstart="0 0" data-offsetend="0 0" data-bgparallax="10" class="rev-slidebg" data-bgfit="cover" data-no-retina>
                                    <div class="tp-caption tp-shape tp-shapewrapper" id="slide-1699-layer-10" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']" data-voffset="['0','0','0','0']" data-width="full"
                                         data-height="full" data-whitespace="nowrap" data-type="shape" data-basealign="slide" data-responsive_offset="on" data-responsive="off" data-frames='[{"from":"y:0;sX:1;sY:1;opacity:0;","speed":2500,"to":"o:1;","delay":500,"ease":"Power4.easeOut"},{"delay":"wait","speed":300,"to":"opacity:0;","ease":"nothing"}]' data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="background-color:rgba(0, 0, 0, 0.57);"> </div>                                   
                                <center>
                                    <div class="slider-main-title text-white tp-caption tp-resizeme rs-parallaxlevel-1" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['top','top','middle','middle']" data-voffset="['200','200','50','50']" data-width="['2000','1000','1200','540']" data-textalign="center" data-fontsize="['110','88','70','50']" data-fontweight="900" data-letterspacing="['25','10','5','10']" data-lineheight="['184','100','70','60']" data-height="none" data-whitespace="normal" data-transform_idle="o:1;" data-transform_in="z:0;rX:0deg;rY:0;rZ:0;sX:1.5;sY:1.5;skX:0;skY:0;opacity:0;s:1500;e:Power3.easeInOut;" data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" data-mask_in="x:0px;y:0px;" data-mask_out="x:inherit;y:inherit;" data-start="1000" data-splitin="none" data-splitout="none" data-responsive_offset="on" data-paddingright="[25,25,25,25]" data-paddingleft="[25,25,25,25]">
                                        Gravador Pub
                                    </div>                                   
                                    <div class="tp-caption rev-btn  rs-parallaxlevel-10" id="slide-163-layer-1" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']" data-voffset="['150','110','220','220']" data-width="['600','600','400','350']" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_hover="o:1;rX:0;rY:0;rZ:0;z:0;s:300;e:Power3.easeOut;" data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power4.easeInOut;" data-transform_out="y:[175%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" data-mask_out="x:inherit;y:inherit;" data-start="1250" data-splitin="none" data-splitout="none" data-actions='[{"event":"click","action":"jumptoslide","slide":"rs-164","delay":""}]' data-responsive_offset="on" data-paddingtop="[0,0,0,0]" data-paddingright="[25,25,25,25]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[25,25,25,25]">
                                        <br>
                                        <a style="background-color: rgba(116, 206, 232, 0.5); border: none; font-size: 95%;" class="btn btn-primary has-radius-small" href="contato.php">CONTATO</a>                  
                                        <br class='br-cel'><br class='br-cel'>
                                        <?php
                                        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
                                        date_default_timezone_set('America/Sao_Paulo');
                                        $mes = strftime('%B');
                                        str_replace("ç", "c", $mes);
                                        ?>
                                        <a style="background-color: rgba(116, 206, 232, 0.5); border: none; font-size: 95%;" class="btn btn-primary has-radius-small" href="agenda/<?php echo $mes; ?>.php">AGENDA DE SHOWS</a>
                                    </div>
                                </center>                               
                                </li>                               
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="content-wrapper">
                                        <?php
                                        
                                        $sessionIn = '<section class="content-block">
                                        <style>                          
                                            .carousel{
                                                width: 500px;
                                            }
                                            .carousel-inner { padding-bottom: 115px;}
                                            .carousel-caption { bottom:-115px; color: black;}

                                            @media only screen and (max-width: 1200px) {

                                                .carousel-inner { padding-bottom: 115px;}
                                                .carousel-caption { bottom:-115px; color: black;}

                                                .carousel{
                                                    width: 80%;
                                                }

                                            }     
                                        </style>            
                                        <div class="container">
                                            <div class="container-fluid">
                                                <div class="block-heading bottom-space">
                                                    <center><h2 class="block-top-heading">Destaques da Semana:</h2></center>
                                                    <center><div class="carousel" class="divider"><hr class="my-4"></div></center>
                                                </div>
                                                <center>
                                        <div id="demo" class="carousel slide" data-ride="carousel">';
                                        
                                        $sessionOut = ' <a class="carousel-control-prev" href="#demo" data-slide="prev">
                                                                <span class="carousel-control-prev-icon"></span>
                                                            </a>
                                                            <a class="carousel-control-next" href="#demo" data-slide="next">
                                                                <span class="carousel-control-next-icon"></span>
                                                            </a>

                                                    </div>
                                                    </center>
                                                </div>
                                        </div>
                                        </section>';
                                        
                                        $sql = "select * from destaques";

                                        $resultado = $con->query($sql);

                                        if ($resultado->num_rows > 0) {
                                            echo $sessionIn;
                                            $i = 0;
                                            echo '<ul class="carousel-indicators">';
                                            while ($row = $resultado->fetch_assoc()) {
                                                if ($i === 0) {
                                                    echo '<li data-target="#demo" data-slide-to="0" class="active"></li>';
                                                } else {
                                                    echo '<li data-target="#demo" data-slide-to="'.$i.'"></li>';
                                                }
                                                $i++;
                                            }
                                            echo '</ul>';
                                        } 

                                        $resultado1 = $con->query($sql);

                                        if ($resultado1->num_rows > 0) {
                                            $i = 0;
                                            echo '<div class="carousel-inner">';
                                            while ($row = $resultado1->fetch_assoc()) {
                                                if ($i === 0) {
                                                    $dest = '
                                                <div class="carousel-item active">
                                                    <a href="'.$row['link'].'"><img width=\'100%\' src="'.$row['imgdir'].'" alt="Destaque'.$i.'"></a>
                                                    <div class="carousel-caption">
                                                        <h5>'.$row['titulo'].'</h5>
                                                        <p>'.$row['desc_cur'].'</p>
                                                    </div>
                                                </div>';
                                                } else {
                                                    $dest = '
                                                <div class="carousel-item">
                                                    <a href="'.$row['link'].'"><img width=\'100%\' src="'.$row['imgdir'].'" alt="Destaque'.$i.'"></a>
                                                    <div class="carousel-caption">
                                                        <h5>'.$row['titulo'].'</h5>
                                                        <p>'.$row['desc_cur'].'</p>
                                                    </div>
                                                </div>';
                                                }
                                                echo $dest;
                                                $i++;
                                            }
                                            echo '</div>';
                                            echo $sessionOut;
                                        }

                                        $con->close();
                                        ?>                 
                <section class="content-block pt-0 bg-gray-light">
                    <div class="container">
                        <div class="block-heading bottom-space">
                            <br><br>                             
                            <h3 class="block-top-heading">Nossa História</h3>
                            <h2 class="block-main-heading">Como Surgiu o Gravador?</h2>
                            <span class="block-sub-heading">"Gravando momentos inesquecíveis em sua memória desde 2016"</span>
                            <div class="divider"><hr class="my-4"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="bottom-space-small-only">
                                    <p class="text-justify">O nome, “Gravador Pub”, foi escolhido pois a palavra <b>gravador</b> representa o aparelho que registra momentos, memórias e referências. Todos estes significados remetem a importância do que fica gravado. </p>
                                    <p class="text-justify">É através de registros que cada um desenvolve experiências e passa a perceber o mundo de uma forma mais ampla e inclusiva. Esse é nosso objetivo. Proporcionar ampla experiência cultural, como um lugar de resistência da boa música, da preservação do patrimônio histórico e da valorização de músicos e artistas.  </p>                                          
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bottom-s-space">
                                    <p class="text-justify">Ao longo de seus <b>seis</b> anos de existência, o “Gravador Pub”, já foi palco de mais de 600 (seiscentas) apresentações musicais ao vivo, entre shows nacionais e internacionais, gravações de DVDs, EPs e CDs. Saraus, lançamento de livros, exibições audiovisuais, mostras de cinema, festivais e eventos voltados para o desenvolvimento da cultura local. </p>
                                </div>                                       
                            </div>
                        </div>
                    </div>
                </section>
                <section id="work-section" class="content-block work-block">
                    <div class="bg-stretch">
                        <img src="img/AmigosFoto3.jpg" alt="Amigos">
                    </div>
                    <div class="container">
                        <div class="block-heading bottom-space text-center">
                            <h3 style="color: white;" class="block-top-heading">Não só o Lugar</h3>
                            <h2 style="color: white;" class="block-main-heading">As Pessoas</h2>
                            <span style="color: white;" class="block-sub-heading">Nada disso seria possível sem a ajuda de todos vocês!</span>
                        </div>                               
                    </div>
                </section>                  
                <section class="content-block bg-gray-light">
                    <div class="container">
                        <div class="block-heading bottom-space text-center">
                            <h3 class="block-top-heading">Quem somos nós</h3>
                            <h2 class="block-main-heading">Saiba mais sobre quem está por trás de tudo isso!</h2>
                            <span class="block-sub-heading">"Graças à cultura, o homem torna-se um ser social. Poporcionar esta experiência, ao mesmo tempo valorizar nossa história, é o nosso principal objetivo."</span>
                            <div class="divider"><hr class="my-4"></div>
                        </div>
                        <div class="testimonial-container text-center">
                            <div class="owl-carousel testimonial-slide" id="waituk-owl-slide-3">
                                <div class="slide-item">
                                    <div class="team-wrap">
                                        <div class="img-block">
                                            <img src="img/cris.jpg" alt="Cristina Salomão">
                                        </div>
                                        <div class="text-wrap">
                                            <h3>Cristina Salomão</h3>
                                            <span class="designation bottom-m-space">Psicóloga/Administradora/Proprietária do Gravador Pub</span>                  
                                        </div>
                                    </div>
                                </div>
                                <div class="slide-item">
                                    <div class="team-wrap">
                                        <div class="img-block">
                                            <img src="img/dada.jpg" alt="Gabriel Vieira Lopes Salomão">
                                        </div>
                                        <div class="text-wrap">
                                            <h3>Gabriel Vieira Lopes Salomão</h3>
                                            <span class="designation bottom-m-space">Publicitário/Proprietário do Gravador Pub/Operador de Áudio</span>    
                                        </div>
                                    </div>
                                </div>
                                <div class="slide-item">
                                    <div class="team-wrap">
                                        <div class="img-block">
                                            <img src="img/conrado.jpeg" alt="Conrado Salomão">
                                        </div>
                                        <div class="text-wrap">
                                            <h3>Conrado Salomão</h3>
                                            <span class="designation bottom-m-space">Produtor Multimídia/Webmaster/Web Developer</span>                                       
                                        </div>
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
                                    <a href="https://gravadorpub.com.br/"><img src="img/logogravador.png" alt="Logo Gravador"></a>
                                </div>
                                <div class="slide-item">
                                    <a href="https://www.lojaopenstage.com.br/"><img src="img/logo-02-Open.png" alt="Logo Openstage"></a>
                                </div>
                                <div class="slide-item">
                                    <a href="https://gravadorpub.com.br/"><img src="img/logogravador.png" alt="Logo Gravador"></a>
                                </div>
                                <div class="slide-item">
                                    <a href="https://www.lojaopenstage.com.br/"><img src="img/logo-02-Open.png" alt="Logo Openstage"></a>
                                </div>
                                <div class="slide-item">
                                    <a href="https://gravadorpub.com.br/"><img src="img/logogravador.png" alt="Logo Gravador"></a>
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
    <div class="content-block footer-main text-center naorodartrans">
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
<script src="vendors/owl-carousel/dist/owl.carousel.min.js"></script>
<script src="vendors/waypoint/waypoints.min.js"></script>
<script src="vendors/counter-up/jquery.counterup.min.js"></script>
<script src="vendors/fancyBox/source/jquery.fancybox.pack.js"></script>
<script src="vendors/fancyBox/source/helpers/jquery.fancybox-thumbs.js"></script>
<script src="vendors/image-stretcher-master/image-stretcher.js"></script>
<script src="vendors/wow/wow.min.js"></script>
<script src="vendors/rateyo/jquery.rateyo.min.js"></script>
<script src="vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="vendors/bootstrap-slider-master/src/js/bootstrap-slider.js"></script>
<script src="vendors/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script src="js/mega-menu.js"></script>
<script src="vendors/retina/retina.min.js"></script>
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

</body>

</html>
