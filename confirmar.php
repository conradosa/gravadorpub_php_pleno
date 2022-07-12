<?php
session_start();
include('conexao.php');
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="pt-BR">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>Gravador Pub - Confirmação de E-mail</title>
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
    session_start();
    include('conexao.php');

    $token = $_GET['token'];

    $sql1 = "select count(*) as total from usuario where token = '$token'";

    $r1 = mysqli_query($con, $sql1);

    $row1 = mysqli_fetch_assoc($r1);

    if ($row1['total'] >= 1) {

        $sql = "UPDATE usuario SET validado = '1' WHERE token = '$token'";

        if ($con->query($sql) === true) {
            $_SESSION['validado'] = 1;
            ?>
            <script>
                Swal.fire({
                    confirmButtonColor: '#7592a4',
                    title: "Sucesso!",
                    text: "E-mail Confirmado!",
                    icon: "success",
                    type: "success"
                }).then(function () {
                    window.location = "home.php";
                });
            </script>
            <?php
        }
    } else {
        ?>
        <script>
            Swal.fire({
                confirmButtonColor: '#7592a4',
                title: "Erro!",
                text: "Falha no Cadastro!",
                icon: "error",
                type: "error"
            }).then(function () {
                window.location = "home.php";
            });
        </script>
        <?php
    }
    ?>

</html>


