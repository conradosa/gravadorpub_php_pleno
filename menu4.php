<?php
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$mes = strftime('%B');
str_replace("ç", "c", $mes);
str_replace("mar", "marco", $mes);
?>
<button type="button" class="navbar-toggler navbar-toggler-left" onclick="pesq1();" data-toggle="collapse" data-target="#mega-menu">
    <span class="navbar-toggler-icon"></span>
</button>
<button style="color: black; border: none; background: none; position: absolute; right: -45%;" class="btn_pesq btn" onclick="pesq();"><i class="custom-icon-search"></i></button>                            
<div class="pesquisa1">
    <form action="../pesquisa.php">
        <select required class="sel inputform" name="tipo">
            <option class="inputform" value="evento">Shows</option>
            <option class="inputform" value="produtos">Loja</option>
        </select>
        <input class="txt inputform" name="txt_pesq" placeholder="Pesquisar" type="text">
        <input style="display:none;" type="submit" class="sub inputform" value="Ok">                                   
    </form>
</div>
<br><br><br>
<div class="collapse navbar-collapse flex-row-reverse" id="mega-menu">
    <ul class="nav navbar-nav">

        <li><a href="../home.php" data-title="Home">Home</a></li>

        <li><a href="<?php echo $mes; ?>.php">Agenda</a></li>

        <li><a href="../loja/produtos.php">Loja</a></li>

        <li><a href="../sobre.php">Sobre</a></li>

        <li><a href="../contato.php">Contato</a></li>
        
        <li><a href="../cardapio.php">Cardápio</a></li>
        <?php
        if (!isset($_SESSION['email'])) {
            ?>
            <li><a href="../login.php">Login</a></li>

            <li><a href="../cadastro.php">Cadastro</a></li>
            <?php
        } else {
            ?>
            <li><a href="../minhaconta.php">Minha Conta</a></li>

            <li><a href="../sair.php">Sair</a></li>
            <?php
        }
        ?>
        <?php
        if (isset($_SESSION['email']) and $_SESSION['email'] == "gravadorpub@gmail.com") {
            ?>
            <li><a href="../administrador.php">Administrador</a></li>
            <?php
        }
        ?>
    </ul>
</div>  