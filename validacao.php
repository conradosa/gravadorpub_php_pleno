<?php
include('verifica_seguranca.php');
include('conexao.php');

$referencia = $_GET['referencia'];
$valor = $_GET['valor'];
$nome = $_GET['nome'];
$arq_qrcode = $_GET['arq_qrcode'];
$data_envio = $_GET['data_envio'];
$nome_evento = $_GET['nome_evento'];

?>
<!DOCTYPE html>
<html lang="pt-BR">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>Gravador Pub - Validação</title>
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

    <div id="wrapper">        
        <section class="visual visual-sub visual-no-bg">
            <div class="visual-inner no-overlay bg-gray-light">
                <div class="visual-text visual-center">
                    <center><h1 class="visual-title visual-sub-title">Validação de Ingressos</h1></center>
                </div>
            </div>
            <br>
            <div class="d-flex justify-content-center">
                <div class="description">                              
                    <div class="col col-lg-12">
                        <div class="text-wrap">
                            <center>
                                <?php if(isset($nome_evento)){ ?>
                                <h5>Evento:</h5><h4><?php echo $nome_evento; ?></h4>
                                <?php } ?>
                                <h5>Nome:</h5><h4><?php echo $nome; ?></h4>
                                <h5>Valor:</h5><h4>R$<?php echo $valor; ?></h4>
                                <br>
                                <form method="POST">
                                    <input type="submit" name="confirmar" value="Validar Ingresso" class="btn btn-primary">
                                </form>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </section>      
        <script>
            function validar() {
                document.getElementById("cancelar").style.display = "initial";
                document.getElementById("confirmar").style.display = "initial";
                document.getElementById("validar").style.display = "none";
            }
            function zerar() {
                document.getElementById("cancelar").style.display = "none";
                document.getElementById("confirmar").style.display = "none";
                document.getElementById("validar").style.display = "initial";
            }
        </script>
    </main>
</div>
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

<?php
if (isset($_POST['confirmar'])) {

    $sql1 = "select count(*) as total from ingressos where arq_qrcode = '$arq_qrcode'";

    $r1 = mysqli_query($con, $sql1);

    $row1 = mysqli_fetch_assoc($r1);

    if ($row1['total'] >= 1):

        $sql = "select count(*) as total from ingressos where arq_qrcode = '$arq_qrcode' AND validado = '1'";

        $r = mysqli_query($con, $sql);

        $row = mysqli_fetch_assoc($r);

        if ($row['total'] >= 1) {
            ?>
            <script>
            Swal.fire({
                confirmButtonColor: '#7592a4',
                title: "Erro!",
                text: "Ingresso Já Validado!",
                icon: "error",
                type: "error"
            });
            </script>
            <?php
        } else {
            $sql_insert = "UPDATE ingressos SET validado = '1' WHERE referencia = '" . $referencia . "' AND valor = '" . $valor . "' AND nome ='" . $nome . "' AND arq_qrcode = '" . $arq_qrcode . "' AND data_envio = '" . $data_envio . "'";
            if ($con->query($sql_insert) === true) {
                ?>
                <script>
                    Swal.fire({
                        confirmButtonColor: '#7592a4',
                        title: "Sucesso!",
                        text: "Ingresso Validado!",
                        icon: "success",
                        type: "success"
                    });
                </script>
                <?php
            }
        }
    else:
        ?>
        <script>
            Swal.fire({
                confirmButtonColor: '#7592a4',
                title: "Erro!",
                text: "Ingresso não cadastrado!",
                icon: "error",
                type: "error"
            });
        </script>
    <?php
    endif;
}
?>

</html>
