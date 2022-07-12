<?php
session_start();
header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");
include('conexao.php');
include('phpqrcode/qrlib.php');
include("PagSeguroLibrary/PagSeguroLibrary.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require('lib/vendor/autoload.php');

$mail = new PHPMailer(true);

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

if (isset($_POST['notificationCode'])) {
    $notificationCode = $_POST['notificationCode'];

    try {
        $credentials = PagSeguroConfig::getAccountCredentials(); // getApplicationCredentials()  
        $response = PagSeguroNotificationService::checkTransaction(
                        $credentials,
                        $notificationCode
        );

        $reference = $response->getReference();
        $status = $response->getStatus()->getTypeFromValue();
        $sql_ref = "select * from compras WHERE codigo = '$reference' limit 1";
                    $resultado_ref = $con->query($sql_ref);
                    if ($resultado_ref->num_rows > 0) {
                        while ($row_ref = $resultado_ref->fetch_assoc()) {
                        $email = $row_ref['email'];
                        $nomeprod = $row_ref['nomeprod'];
                        $nomes = $row_ref['nomes'];
                        $tipo = $row_ref['tipo'];
                        $qtd = $row_ref['qtd'];
                        $data_c = $row_ref['data'];
                        if($qtd > 1){
                            $valor = $row_ref['valor'] / $qtd;
                        }else if($qtd == 1){
                            $valor = $row_ref['valor'];
                        }
                        $nomearq = $row_ref['nomearq'];
                        $lotenome = $row_ref['nomes_l'];
                        $nome_com = $row_ref['nome_completo'];
                        $nome_pri = explode(' ', trim($row_ref['nome_completo']));
                        $nomesing_a = explode('-', trim($row_ref['nomes']));
                        $lotes = explode('-', trim($row_ref['nomes_l']));
                        }
                    }

        switch ($status) {
            case "WAITING_PAYMENT":
                $status1 = "AGUARDANDO PAGAMENTO";
                $sql_insert = "INSERT INTO transacao (codigo, referencia, estado, nomearq, data_transacao) VALUES ('$notificationCode', '$reference', '$status1', '$nomearq', NOW()) ON DUPLICATE KEY UPDATE codigo = VALUES(codigo), estado = VALUES(estado), data_transacao = VALUES(data_transacao)";
                $open_sans = "'Open Sans'";
                $nunito = "'Nunito'";
                $raleway = "'Raleway'";
                if ($tipo == "evento") {
                    $qtd_ing = count($nomesing_a);
                    $altbody1 = 'Olá, ' . $nome_pri[0] . '! Você acabou de adquirir ' . count($nomesing_a) . ' ingressos do Gravador Pub para o ' . $nomeprod . '! Obrigado pela preferência! O estado atual de sua transação é: ' . $status1 . '.' . ' Seus ' . count($nomesing_a) . ' ingressos serão enviados para este e-mail após a confirmação do pagamento!';
                    $altbody2 = 'Olá, ' . $nome_pri[0] . '! Você acabou de adquirir um ingresso do Gravador Pub para o ' . $nomeprod . '! Obrigado pela preferência! O estado atual de sua transação é: ' . $status1 . '.' . ' Seu ingresso será enviado para este e-mail após a confirmação do pagamento!';
                    $msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--[if !mso]><!--><meta http-equiv="X-UA-Compatible" content="IE=edge" /><!--<![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Gravador Pub</title>
        <style>


            @import url(https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900|Raleway:200,300,400,500,600,700,800,900);

            html{width:100%}
            body{-webkit-text-size-adjust:none;-ms-text-size-adjust:none;margin:0;padding:0;font-family:' . $open_sans . ',Arial,Sans-serif!important}
            table{border-spacing:0;table-layout:auto;margin:0 auto}
            img{display:block!important;overflow:hidden!important}
            a{text-decoration: none;color:unset}
            .ReadMsgBody{width:100%;background-color:#fff}
            .ExternalClass{width:100%;background-color:#fff}
            .ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:100%}
            .yshortcuts a{border-bottom:none!important}
            .full{width:100%}
            .pad{width:92%}
            @media only screen and (max-width: 650px) {
                .res-pad{width:92%;max-width:92%}
                .res-full{width:100%;max-width:100%}
                .res-left{text-align:left!important}
                .res-right{text-align:right!important}
                .res-center{text-align:center!important}
            }@media only screen and (max-width: 750px) {
                .margin-full{width:100%;max-width:100%}
                .margin-pad{width:92%;max-width:92%;max-width:600px}
            }
        </style>
    </head>
    <body><repeater><layout label="Module 1 - Header">
                <!-- ====== Module : Header ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- column x2 -->
                                            <tr >
                                                <td>
                                                    <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">GRAVADOR PUB</singleline></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- column x2 end -->
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                </table></layout><layout label="Module 2 - Intro">
                <!-- ====== Module : Intro ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="#304050" align="center" width="750" class="margin-full" style="background-size:cover; background-position:center;" border="0" cellpadding="0" cellspacing="0" background="img/module02-bg01.png">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 2px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle">STATUS DA TRANSAÇÃO:</singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="12" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">' . $status1 . '</singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="20" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- dash -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table bgcolor="white" align="center" style="border-radius: 10px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td width="60" height="3" style="font-size:0px" >&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- dash end -->
                                            <tr><td height="21" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: justify; text-indent: 5%; color: white; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                    Olá, ' . $nome_pri[0] . '! Este e-mail é referente a <b>' . $nomeprod . '</b>! Obrigado pela preferência! Seus ' . count($nomesing_a) . ' ingressos serão enviados para este e-mail após a confirmação do pagamento!
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="24" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- button -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table align="center" bgcolor="#006D89" style="border: 1.5px solid white; border-radius: 4px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td height="43" style="padding: 0 23px; text-align: center;" >
                                                                             <a href="https://gravadorpub.com.br/home.php" style="color: white; letter-spacing: 1px; font-size: 17px; font-family: ' . $nunito . ', Arial, Sans-serif; text-decoration: none; text-align: center; line-height: 24px; word-break: break-word;" ><singleline label="Button">VOLTAR AO SITE</singleline></a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- button end -->
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout><layout label="Module 3 - Trending Events summary">
                    
                <!-- ====== Module : Trending Events summary ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 0.7px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle"></singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="7" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #505050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 22px; letter-spacing: 0.7px; word-break: break-word" ><singleline label="Title"></singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="13" style="font-size:0px" >&nbsp;</td></tr>
                                            
                                            <tr><td height="25" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                       
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="15" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- link -->
                                            <tr >
                                                <td class="res-center" style="text-align: center;" >
                                                    <a href="https://example.com" style="color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.7px; text-decoration: none; word-break: break-word;" ><singleline label="Link"></singleline></a>
                                                </td>
                                            </tr>
                                            <!-- link end -->
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout></repeater>

        <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table bgcolor="#F5F5F5" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                    <tr>
                                        <td>
                                            <table align="center" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                            
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #909090; font-family: ' . $nunito . ', Arial, Sans-serif; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; font-size: 15px;" ><multiline label="Paragraph">Veja mais eventos do Gravador Pub!</multiline></td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                           
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; padding-left: 7px; font-weight: 600;" >
                                                                    <a href="https://gravadorpub.com.br/agenda/janeiro.php">Clique Aqui</a>
                                                                </td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </body>
</html>';
                    $msg2 = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--[if !mso]><!--><meta http-equiv="X-UA-Compatible" content="IE=edge" /><!--<![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Gravador Pub</title>
        <style>


            @import url(https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900|Raleway:200,300,400,500,600,700,800,900);

            html{width:100%}
            body{-webkit-text-size-adjust:none;-ms-text-size-adjust:none;margin:0;padding:0;font-family:' . $open_sans . ',Arial,Sans-serif!important}
            table{border-spacing:0;table-layout:auto;margin:0 auto}
            img{display:block!important;overflow:hidden!important}
            a{text-decoration: none;color:unset}
            .ReadMsgBody{width:100%;background-color:#fff}
            .ExternalClass{width:100%;background-color:#fff}
            .ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:100%}
            .yshortcuts a{border-bottom:none!important}
            .full{width:100%}
            .pad{width:92%}
            @media only screen and (max-width: 650px) {
                .res-pad{width:92%;max-width:92%}
                .res-full{width:100%;max-width:100%}
                .res-left{text-align:left!important}
                .res-right{text-align:right!important}
                .res-center{text-align:center!important}
            }@media only screen and (max-width: 750px) {
                .margin-full{width:100%;max-width:100%}
                .margin-pad{width:92%;max-width:92%;max-width:600px}
            }
        </style>
    </head>
    <body><repeater><layout label="Module 1 - Header">
                <!-- ====== Module : Header ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- column x2 -->
                                            <tr >
                                                <td>
                                                    <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">GRAVADOR PUB</singleline></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- column x2 end -->
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                </table></layout><layout label="Module 2 - Intro">
                <!-- ====== Module : Intro ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="#304050" align="center" width="750" class="margin-full" style="background-size:cover; background-position:center;" border="0" cellpadding="0" cellspacing="0" background="img/module02-bg01.png">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 2px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle">STATUS DA TRANSAÇÃO:</singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="12" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">' . $status1 . '</singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="20" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- dash -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table bgcolor="white" align="center" style="border-radius: 10px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td width="60" height="3" style="font-size:0px" >&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- dash end -->
                                            <tr><td height="21" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: justify; text-indent: 5%; color: white; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                    Olá, ' . $nome_pri[0] . '! Este e-mail é referente a <b>' . $nomeprod . '</b>! Obrigado pela preferência! Seu ingresso será enviado para este e-mail após a confirmação do pagamento!
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="24" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- button -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table align="center" bgcolor="#006D89" style="border: 1.5px solid white; border-radius: 4px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td height="43" style="padding: 0 23px; text-align: center;" >
                                                                             <a href="https://gravadorpub.com.br/home.php" style="color: white; letter-spacing: 1px; font-size: 17px; font-family: ' . $nunito . ', Arial, Sans-serif; text-decoration: none; text-align: center; line-height: 24px; word-break: break-word;" ><singleline label="Button">VOLTAR AO SITE</singleline></a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- button end -->
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout><layout label="Module 3 - Trending Events summary">
                    
                <!-- ====== Module : Trending Events summary ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 0.7px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle"></singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="7" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #505050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 22px; letter-spacing: 0.7px; word-break: break-word" ><singleline label="Title"></singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="13" style="font-size:0px" >&nbsp;</td></tr>
                                            
                                            <tr><td height="25" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                       
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="15" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- link -->
                                            <tr >
                                                <td class="res-center" style="text-align: center;" >
                                                    <a href="https://example.com" style="color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.7px; text-decoration: none; word-break: break-word;" ><singleline label="Link"></singleline></a>
                                                </td>
                                            </tr>
                                            <!-- link end -->
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout></repeater>

        <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table bgcolor="#F5F5F5" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                    <tr>
                                        <td>
                                            <table align="center" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                            
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #909090; font-family: ' . $nunito . ', Arial, Sans-serif; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; font-size: 15px;" ><multiline label="Paragraph">Veja mais eventos do Gravador Pub!</multiline></td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                           
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; padding-left: 7px; font-weight: 600;" >
                                                                    <a href="https://gravadorpub.com.br/agenda/janeiro.php">Clique Aqui</a>
                                                                </td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </body>
</html>';
                } elseif ($tipo == "produto") {
                    $qtd_ing = $qtd;
                    $altbody2 = 'Olá, ' . $nome_pri[0] . '! Este e-mail é referente à compra do produto ' . $nomeprod . '! Obrigado pela preferência! O estado atual de sua transação é: ' . $status1 . '.';
                    $altbody1 = 'Olá, ' . $nome_pri[0] . '! Este e-mail é referente à compra dos ' . $qtd . ' produtos ' . $nomeprod . '! Obrigado pela preferência! O estado atual de sua transação é: ' . $status1 . '.';
                    $msg2 = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--[if !mso]><!--><meta http-equiv="X-UA-Compatible" content="IE=edge" /><!--<![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Gravador Pub</title>
        <style>


            @import url(https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900|Raleway:200,300,400,500,600,700,800,900);

            html{width:100%}
            body{-webkit-text-size-adjust:none;-ms-text-size-adjust:none;margin:0;padding:0;font-family:' . $open_sans . ',Arial,Sans-serif!important}
            table{border-spacing:0;table-layout:auto;margin:0 auto}
            img{display:block!important;overflow:hidden!important}
            a{text-decoration: none;color:unset}
            .ReadMsgBody{width:100%;background-color:#fff}
            .ExternalClass{width:100%;background-color:#fff}
            .ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:100%}
            .yshortcuts a{border-bottom:none!important}
            .full{width:100%}
            .pad{width:92%}
            @media only screen and (max-width: 650px) {
                .res-pad{width:92%;max-width:92%}
                .res-full{width:100%;max-width:100%}
                .res-left{text-align:left!important}
                .res-right{text-align:right!important}
                .res-center{text-align:center!important}
            }@media only screen and (max-width: 750px) {
                .margin-full{width:100%;max-width:100%}
                .margin-pad{width:92%;max-width:92%;max-width:600px}
            }
        </style>
    </head>
    <body><repeater><layout label="Module 1 - Header">
                <!-- ====== Module : Header ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- column x2 -->
                                            <tr >
                                                <td>
                                                    <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">GRAVADOR PUB</singleline></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- column x2 end -->
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                </table></layout><layout label="Module 2 - Intro">
                <!-- ====== Module : Intro ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="#304050" align="center" width="750" class="margin-full" style="background-size:cover; background-position:center;" border="0" cellpadding="0" cellspacing="0" background="img/module02-bg01.png">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 2px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle">STATUS DA TRANSAÇÃO:</singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="12" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">' . $status1 . '</singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="20" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- dash -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table bgcolor="white" align="center" style="border-radius: 10px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td width="60" height="3" style="font-size:0px" >&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- dash end -->
                                            <tr><td height="21" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: justify; text-indent: 5%; color: white; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                    Olá, ' . $nome_pri[0] . '! Este e-mail é referente à compra do produto <b>' . $nomeprod . '</b>! Obrigado pela preferência!
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="24" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- button -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table align="center" bgcolor="#006D89" style="border: 1.5px solid white; border-radius: 4px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td height="43" style="padding: 0 23px; text-align: center;" >
                                                                             <a href="https://gravadorpub.com.br/home.php" style="color: white; letter-spacing: 1px; font-size: 17px; font-family: ' . $nunito . ', Arial, Sans-serif; text-decoration: none; text-align: center; line-height: 24px; word-break: break-word;" ><singleline label="Button">VOLTAR AO SITE</singleline></a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- button end -->
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout><layout label="Module 3 - Trending Events summary">
                    
                <!-- ====== Module : Trending Events summary ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 0.7px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle"></singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="7" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #505050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 22px; letter-spacing: 0.7px; word-break: break-word" ><singleline label="Title"></singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="13" style="font-size:0px" >&nbsp;</td></tr>
                                            
                                            <tr><td height="25" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                       
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="15" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- link -->
                                            <tr >
                                                <td class="res-center" style="text-align: center;" >
                                                    <a href="https://example.com" style="color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.7px; text-decoration: none; word-break: break-word;" ><singleline label="Link"></singleline></a>
                                                </td>
                                            </tr>
                                            <!-- link end -->
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout></repeater>

        <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table bgcolor="#F5F5F5" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                    <tr>
                                        <td>
                                            <table align="center" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                            
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #909090; font-family: ' . $nunito . ', Arial, Sans-serif; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; font-size: 15px;" ><multiline label="Paragraph">Veja mais produtos do Gravador Pub!</multiline></td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                           
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; padding-left: 7px; font-weight: 600;" >
                                                                    <a href="https://gravadorpub.com.br/loja/produtos.php">Clique Aqui</a>
                                                                </td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </body>
</html>';

                    $msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--[if !mso]><!--><meta http-equiv="X-UA-Compatible" content="IE=edge" /><!--<![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Gravador Pub</title>
        <style>


            @import url(https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900|Raleway:200,300,400,500,600,700,800,900);

            html{width:100%}
            body{-webkit-text-size-adjust:none;-ms-text-size-adjust:none;margin:0;padding:0;font-family:' . $open_sans . ',Arial,Sans-serif!important}
            table{border-spacing:0;table-layout:auto;margin:0 auto}
            img{display:block!important;overflow:hidden!important}
            a{text-decoration: none;color:unset}
            .ReadMsgBody{width:100%;background-color:#fff}
            .ExternalClass{width:100%;background-color:#fff}
            .ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:100%}
            .yshortcuts a{border-bottom:none!important}
            .full{width:100%}
            .pad{width:92%}
            @media only screen and (max-width: 650px) {
                .res-pad{width:92%;max-width:92%}
                .res-full{width:100%;max-width:100%}
                .res-left{text-align:left!important}
                .res-right{text-align:right!important}
                .res-center{text-align:center!important}
            }@media only screen and (max-width: 750px) {
                .margin-full{width:100%;max-width:100%}
                .margin-pad{width:92%;max-width:92%;max-width:600px}
            }
        </style>
    </head>
    <body><repeater><layout label="Module 1 - Header">
                <!-- ====== Module : Header ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- column x2 -->
                                            <tr >
                                                <td>
                                                    <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">GRAVADOR PUB</singleline></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- column x2 end -->
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                </table></layout><layout label="Module 2 - Intro">
                <!-- ====== Module : Intro ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="#304050" align="center" width="750" class="margin-full" style="background-size:cover; background-position:center;" border="0" cellpadding="0" cellspacing="0" background="img/module02-bg01.png">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 2px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle">STATUS DA TRANSAÇÃO:</singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="12" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">' . $status1 . '</singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="20" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- dash -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table bgcolor="white" align="center" style="border-radius: 10px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td width="60" height="3" style="font-size:0px" >&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- dash end -->
                                            <tr><td height="21" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: justify; text-indent: 5%; color: white; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                    Olá, ' . $nome_pri[0] . '! Este e-mail é referente à compra dos ' . $qtd . ' produtos <b>' . $nomeprod . '</b>! Obrigado pela preferência!
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="24" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- button -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table align="center" bgcolor="#006D89" style="border: 1.5px solid white; border-radius: 4px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td height="43" style="padding: 0 23px; text-align: center;" >
                                                                             <a href="https://gravadorpub.com.br/home.php" style="color: white; letter-spacing: 1px; font-size: 17px; font-family: ' . $nunito . ', Arial, Sans-serif; text-decoration: none; text-align: center; line-height: 24px; word-break: break-word;" ><singleline label="Button">VOLTAR AO SITE</singleline></a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- button end -->
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout><layout label="Module 3 - Trending Events summary">
                    
                <!-- ====== Module : Trending Events summary ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 0.7px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle"></singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="7" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #505050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 22px; letter-spacing: 0.7px; word-break: break-word" ><singleline label="Title"></singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="13" style="font-size:0px" >&nbsp;</td></tr>
                                            
                                            <tr><td height="25" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                       
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="15" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- link -->
                                            <tr >
                                                <td class="res-center" style="text-align: center;" >
                                                    <a href="https://example.com" style="color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.7px; text-decoration: none; word-break: break-word;" ><singleline label="Link"></singleline></a>
                                                </td>
                                            </tr>
                                            <!-- link end -->
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout></repeater>

        <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table bgcolor="#F5F5F5" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                    <tr>
                                        <td>
                                            <table align="center" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                            
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #909090; font-family: ' . $nunito . ', Arial, Sans-serif; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; font-size: 15px;" ><multiline label="Paragraph">Veja mais produtos do Gravador Pub!</multiline></td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                           
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; padding-left: 7px; font-weight: 600;" >
                                                                    <a href="https://gravadorpub.com.br/loja/produtos.php">Clique Aqui</a>
                                                                </td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </body>
</html>';
                }
                if ($con->query($sql_insert) === true) {
                    try {
                        $mail->SMTPDebug = 0;
                        $mail->isSMTP();
                        $mail->Host = 'smtp.titan.email';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'compras@gravadorpub.com.br';
                        $mail->Password = 'gravador12!';
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
                       $mail->Port = 465;
                        $mail->CharSet = 'UTF-8';
                        $mail->setFrom('compras@gravadorpub.com.br', 'Gravador Pub');
                        $mail->addAddress($email);
                        $mail->isHTML(true);
                        $mail->Subject = 'Atualização na Transação - Gravador Pub - ' . $status1 . '';
                        if ($qtd_ing > 1) {
                            $mail->Body = $msg;
                            $mail->AltBody = $altbody1;
                        } else {
                            $mail->Body = $msg2;
                            $mail->AltBody = $altbody2;
                        }

                        $mail->send();
                        $mail->ClearAllRecipients();
                    } catch (Exception $e) {
                        echo "O e-mail não pôde ser enviado: {$mail->ErrorInfo}";
                    }
                }

                $con->close();
                break;

            case "PAID":
                $status1 = "PAGA";
                $sql_insert = "INSERT INTO transacao (codigo, referencia, estado, nomearq, data_transacao) VALUES ('$notificationCode', '$reference', '$status1', '$nomearq', NOW()) ON DUPLICATE KEY UPDATE codigo = VALUES(codigo), estado = VALUES(estado), data_transacao = VALUES(data_transacao)";
                $open_sans = "'Open Sans'";
                $nunito = "'Nunito'";
                $raleway = "'Raleway'";
                if ($tipo == "evento") {
                    $qtd_ing = count($nomesing_a);
                    $altbody1 = 'Olá, ' . $nome_pri[0] . '! Você acabou de adquirir ' . count($nomesing_a) . ' ingressos do Gravador Pub para o ' . $nomeprod . '! Obrigado pela preferência! O estado atual de sua transação é: ' . $status1 . '.' . ' Seus ' . count($nomesing_a) . ' ingressos serão enviados para este e-mail após a confirmação do pagamento!';
                    $altbody2 = 'Olá, ' . $nome_pri[0] . '! Você acabou de adquirir um ingresso do Gravador Pub para o ' . $nomeprod . '! Obrigado pela preferência! O estado atual de sua transação é: ' . $status1 . '.' . ' Seu ingresso será enviado para este e-mail após a confirmação do pagamento!';
                    $msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--[if !mso]><!--><meta http-equiv="X-UA-Compatible" content="IE=edge" /><!--<![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Gravador Pub</title>
        <style>


            @import url(https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900|Raleway:200,300,400,500,600,700,800,900);

            html{width:100%}
            body{-webkit-text-size-adjust:none;-ms-text-size-adjust:none;margin:0;padding:0;font-family:' . $open_sans . ',Arial,Sans-serif!important}
            table{border-spacing:0;table-layout:auto;margin:0 auto}
            img{display:block!important;overflow:hidden!important}
            a{text-decoration: none;color:unset}
            .ReadMsgBody{width:100%;background-color:#fff}
            .ExternalClass{width:100%;background-color:#fff}
            .ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:100%}
            .yshortcuts a{border-bottom:none!important}
            .full{width:100%}
            .pad{width:92%}
            @media only screen and (max-width: 650px) {
                .res-pad{width:92%;max-width:92%}
                .res-full{width:100%;max-width:100%}
                .res-left{text-align:left!important}
                .res-right{text-align:right!important}
                .res-center{text-align:center!important}
            }@media only screen and (max-width: 750px) {
                .margin-full{width:100%;max-width:100%}
                .margin-pad{width:92%;max-width:92%;max-width:600px}
            }
        </style>
    </head>
    <body><repeater><layout label="Module 1 - Header">
                <!-- ====== Module : Header ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- column x2 -->
                                            <tr >
                                                <td>
                                                    <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">GRAVADOR PUB</singleline></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- column x2 end -->
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                </table></layout><layout label="Module 2 - Intro">
                <!-- ====== Module : Intro ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="#304050" align="center" width="750" class="margin-full" style="background-size:cover; background-position:center;" border="0" cellpadding="0" cellspacing="0" background="img/module02-bg01.png">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 2px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle">STATUS DA TRANSAÇÃO:</singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="12" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">' . $status1 . '</singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="20" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- dash -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table bgcolor="white" align="center" style="border-radius: 10px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td width="60" height="3" style="font-size:0px" >&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- dash end -->
                                            <tr><td height="21" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: justify; text-indent: 5%; color: white; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                    Olá, ' . $nome_pri[0] . '! Este e-mail é referente a <b>' . $nomeprod . '</b>! Obrigado pela preferência! Seus ' . count($nomesing_a) . ' ingressos serão enviados para este e-mail em seguida!
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="24" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- button -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table align="center" bgcolor="#006D89" style="border: 1.5px solid white; border-radius: 4px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td height="43" style="padding: 0 23px; text-align: center;" >
                                                                             <a href="https://gravadorpub.com.br/home.php" style="color: white; letter-spacing: 1px; font-size: 17px; font-family: ' . $nunito . ', Arial, Sans-serif; text-decoration: none; text-align: center; line-height: 24px; word-break: break-word;" ><singleline label="Button">VOLTAR AO SITE</singleline></a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- button end -->
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout><layout label="Module 3 - Trending Events summary">
                    
                <!-- ====== Module : Trending Events summary ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 0.7px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle"></singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="7" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #505050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 22px; letter-spacing: 0.7px; word-break: break-word" ><singleline label="Title"></singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="13" style="font-size:0px" >&nbsp;</td></tr>
                                            
                                            <tr><td height="25" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                       
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="15" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- link -->
                                            <tr >
                                                <td class="res-center" style="text-align: center;" >
                                                    <a href="https://example.com" style="color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.7px; text-decoration: none; word-break: break-word;" ><singleline label="Link"></singleline></a>
                                                </td>
                                            </tr>
                                            <!-- link end -->
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout></repeater>

        <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table bgcolor="#F5F5F5" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                    <tr>
                                        <td>
                                            <table align="center" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                            
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #909090; font-family: ' . $nunito . ', Arial, Sans-serif; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; font-size: 15px;" ><multiline label="Paragraph">Veja mais eventos do Gravador Pub!</multiline></td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                           
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; padding-left: 7px; font-weight: 600;" >
                                                                    <a href="https://gravadorpub.com.br/agenda/janeiro.php">Clique Aqui</a>
                                                                </td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </body>
</html>';
                    $msg2 = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--[if !mso]><!--><meta http-equiv="X-UA-Compatible" content="IE=edge" /><!--<![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Gravador Pub</title>
        <style>


            @import url(https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900|Raleway:200,300,400,500,600,700,800,900);

            html{width:100%}
            body{-webkit-text-size-adjust:none;-ms-text-size-adjust:none;margin:0;padding:0;font-family:' . $open_sans . ',Arial,Sans-serif!important}
            table{border-spacing:0;table-layout:auto;margin:0 auto}
            img{display:block!important;overflow:hidden!important}
            a{text-decoration: none;color:unset}
            .ReadMsgBody{width:100%;background-color:#fff}
            .ExternalClass{width:100%;background-color:#fff}
            .ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:100%}
            .yshortcuts a{border-bottom:none!important}
            .full{width:100%}
            .pad{width:92%}
            @media only screen and (max-width: 650px) {
                .res-pad{width:92%;max-width:92%}
                .res-full{width:100%;max-width:100%}
                .res-left{text-align:left!important}
                .res-right{text-align:right!important}
                .res-center{text-align:center!important}
            }@media only screen and (max-width: 750px) {
                .margin-full{width:100%;max-width:100%}
                .margin-pad{width:92%;max-width:92%;max-width:600px}
            }
        </style>
    </head>
    <body><repeater><layout label="Module 1 - Header">
                <!-- ====== Module : Header ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- column x2 -->
                                            <tr >
                                                <td>
                                                    <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">GRAVADOR PUB</singleline></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- column x2 end -->
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                </table></layout><layout label="Module 2 - Intro">
                <!-- ====== Module : Intro ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="#304050" align="center" width="750" class="margin-full" style="background-size:cover; background-position:center;" border="0" cellpadding="0" cellspacing="0" background="img/module02-bg01.png">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 2px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle">STATUS DA TRANSAÇÃO:</singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="12" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">' . $status1 . '</singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="20" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- dash -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table bgcolor="white" align="center" style="border-radius: 10px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td width="60" height="3" style="font-size:0px" >&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- dash end -->
                                            <tr><td height="21" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: justify; text-indent: 5%; color: white; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                    Olá, ' . $nome_pri[0] . '! Este e-mail é referente a <b>' . $nomeprod . '</b>! Obrigado pela preferência! Seu ingresso será enviado para este e-mail em seguida!
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="24" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- button -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table align="center" bgcolor="#006D89" style="border: 1.5px solid white; border-radius: 4px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td height="43" style="padding: 0 23px; text-align: center;" >
                                                                             <a href="https://gravadorpub.com.br/home.php" style="color: white; letter-spacing: 1px; font-size: 17px; font-family: ' . $nunito . ', Arial, Sans-serif; text-decoration: none; text-align: center; line-height: 24px; word-break: break-word;" ><singleline label="Button">VOLTAR AO SITE</singleline></a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- button end -->
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout><layout label="Module 3 - Trending Events summary">
                    
                <!-- ====== Module : Trending Events summary ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 0.7px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle"></singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="7" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #505050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 22px; letter-spacing: 0.7px; word-break: break-word" ><singleline label="Title"></singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="13" style="font-size:0px" >&nbsp;</td></tr>
                                            
                                            <tr><td height="25" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                       
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="15" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- link -->
                                            <tr >
                                                <td class="res-center" style="text-align: center;" >
                                                    <a href="https://example.com" style="color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.7px; text-decoration: none; word-break: break-word;" ><singleline label="Link"></singleline></a>
                                                </td>
                                            </tr>
                                            <!-- link end -->
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout></repeater>

        <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table bgcolor="#F5F5F5" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                    <tr>
                                        <td>
                                            <table align="center" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                            
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #909090; font-family: ' . $nunito . ', Arial, Sans-serif; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; font-size: 15px;" ><multiline label="Paragraph">Veja mais eventos do Gravador Pub!</multiline></td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                           
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; padding-left: 7px; font-weight: 600;" >
                                                                    <a href="https://gravadorpub.com.br/agenda/janeiro.php">Clique Aqui</a>
                                                                </td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </body>
</html>';
                } elseif ($tipo == "produto") {
                    $qtd_ing = $qtd;
                    $altbody2 = 'Olá, ' . $nome_pri[0] . '! Este e-mail é referente à compra do produto ' . $nomeprod . '! Obrigado pela preferência! O estado atual de sua transação é: ' . $status1 . '.';
                    $altbody1 = 'Olá, ' . $nome_pri[0] . '! Este e-mail é referente à compra dos ' . $qtd . ' produtos ' . $nomeprod . '! Obrigado pela preferência! O estado atual de sua transação é: ' . $status1 . '.';
                    $msg2 = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--[if !mso]><!--><meta http-equiv="X-UA-Compatible" content="IE=edge" /><!--<![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Gravador Pub</title>
        <style>


            @import url(https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900|Raleway:200,300,400,500,600,700,800,900);

            html{width:100%}
            body{-webkit-text-size-adjust:none;-ms-text-size-adjust:none;margin:0;padding:0;font-family:' . $open_sans . ',Arial,Sans-serif!important}
            table{border-spacing:0;table-layout:auto;margin:0 auto}
            img{display:block!important;overflow:hidden!important}
            a{text-decoration: none;color:unset}
            .ReadMsgBody{width:100%;background-color:#fff}
            .ExternalClass{width:100%;background-color:#fff}
            .ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:100%}
            .yshortcuts a{border-bottom:none!important}
            .full{width:100%}
            .pad{width:92%}
            @media only screen and (max-width: 650px) {
                .res-pad{width:92%;max-width:92%}
                .res-full{width:100%;max-width:100%}
                .res-left{text-align:left!important}
                .res-right{text-align:right!important}
                .res-center{text-align:center!important}
            }@media only screen and (max-width: 750px) {
                .margin-full{width:100%;max-width:100%}
                .margin-pad{width:92%;max-width:92%;max-width:600px}
            }
        </style>
    </head>
    <body><repeater><layout label="Module 1 - Header">
                <!-- ====== Module : Header ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- column x2 -->
                                            <tr >
                                                <td>
                                                    <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">GRAVADOR PUB</singleline></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- column x2 end -->
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                </table></layout><layout label="Module 2 - Intro">
                <!-- ====== Module : Intro ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="#304050" align="center" width="750" class="margin-full" style="background-size:cover; background-position:center;" border="0" cellpadding="0" cellspacing="0" background="img/module02-bg01.png">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 2px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle">STATUS DA TRANSAÇÃO:</singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="12" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">' . $status1 . '</singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="20" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- dash -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table bgcolor="white" align="center" style="border-radius: 10px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td width="60" height="3" style="font-size:0px" >&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- dash end -->
                                            <tr><td height="21" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: justify; text-indent: 5%; color: white; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                    Olá, ' . $nome_pri[0] . '! Este e-mail é referente à compra do produto <b>' . $nomeprod . '</b>! Obrigado pela preferência!
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="24" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- button -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table align="center" bgcolor="#006D89" style="border: 1.5px solid white; border-radius: 4px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td height="43" style="padding: 0 23px; text-align: center;" >
                                                                             <a href="https://gravadorpub.com.br/home.php" style="color: white; letter-spacing: 1px; font-size: 17px; font-family: ' . $nunito . ', Arial, Sans-serif; text-decoration: none; text-align: center; line-height: 24px; word-break: break-word;" ><singleline label="Button">VOLTAR AO SITE</singleline></a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- button end -->
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout><layout label="Module 3 - Trending Events summary">
                    
                <!-- ====== Module : Trending Events summary ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 0.7px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle"></singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="7" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #505050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 22px; letter-spacing: 0.7px; word-break: break-word" ><singleline label="Title"></singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="13" style="font-size:0px" >&nbsp;</td></tr>
                                            
                                            <tr><td height="25" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                       
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="15" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- link -->
                                            <tr >
                                                <td class="res-center" style="text-align: center;" >
                                                    <a href="https://example.com" style="color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.7px; text-decoration: none; word-break: break-word;" ><singleline label="Link"></singleline></a>
                                                </td>
                                            </tr>
                                            <!-- link end -->
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout></repeater>

        <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table bgcolor="#F5F5F5" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                    <tr>
                                        <td>
                                            <table align="center" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                            
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #909090; font-family: ' . $nunito . ', Arial, Sans-serif; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; font-size: 15px;" ><multiline label="Paragraph">Veja mais produtos do Gravador Pub!</multiline></td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                           
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; padding-left: 7px; font-weight: 600;" >
                                                                    <a href="https://gravadorpub.com.br/loja/produtos.php">Clique Aqui</a>
                                                                </td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </body>
</html>';

                    $msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--[if !mso]><!--><meta http-equiv="X-UA-Compatible" content="IE=edge" /><!--<![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Gravador Pub</title>
        <style>


            @import url(https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900|Raleway:200,300,400,500,600,700,800,900);

            html{width:100%}
            body{-webkit-text-size-adjust:none;-ms-text-size-adjust:none;margin:0;padding:0;font-family:' . $open_sans . ',Arial,Sans-serif!important}
            table{border-spacing:0;table-layout:auto;margin:0 auto}
            img{display:block!important;overflow:hidden!important}
            a{text-decoration: none;color:unset}
            .ReadMsgBody{width:100%;background-color:#fff}
            .ExternalClass{width:100%;background-color:#fff}
            .ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:100%}
            .yshortcuts a{border-bottom:none!important}
            .full{width:100%}
            .pad{width:92%}
            @media only screen and (max-width: 650px) {
                .res-pad{width:92%;max-width:92%}
                .res-full{width:100%;max-width:100%}
                .res-left{text-align:left!important}
                .res-right{text-align:right!important}
                .res-center{text-align:center!important}
            }@media only screen and (max-width: 750px) {
                .margin-full{width:100%;max-width:100%}
                .margin-pad{width:92%;max-width:92%;max-width:600px}
            }
        </style>
    </head>
    <body><repeater><layout label="Module 1 - Header">
                <!-- ====== Module : Header ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- column x2 -->
                                            <tr >
                                                <td>
                                                    <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">GRAVADOR PUB</singleline></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- column x2 end -->
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                </table></layout><layout label="Module 2 - Intro">
                <!-- ====== Module : Intro ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="#304050" align="center" width="750" class="margin-full" style="background-size:cover; background-position:center;" border="0" cellpadding="0" cellspacing="0" background="img/module02-bg01.png">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 2px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle">STATUS DA TRANSAÇÃO:</singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="12" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">' . $status1 . '</singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="20" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- dash -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table bgcolor="white" align="center" style="border-radius: 10px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td width="60" height="3" style="font-size:0px" >&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- dash end -->
                                            <tr><td height="21" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: justify; text-indent: 5%; color: white; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                    Olá, ' . $nome_pri[0] . '! Este e-mail é referente à compra dos ' . $qtd . ' produtos <b>' . $nomeprod . '</b>! Obrigado pela preferência!
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="24" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- button -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table align="center" bgcolor="#006D89" style="border: 1.5px solid white; border-radius: 4px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td height="43" style="padding: 0 23px; text-align: center;" >
                                                                             <a href="https://gravadorpub.com.br/home.php" style="color: white; letter-spacing: 1px; font-size: 17px; font-family: ' . $nunito . ', Arial, Sans-serif; text-decoration: none; text-align: center; line-height: 24px; word-break: break-word;" ><singleline label="Button">VOLTAR AO SITE</singleline></a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- button end -->
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout><layout label="Module 3 - Trending Events summary">
                    
                <!-- ====== Module : Trending Events summary ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 0.7px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle"></singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="7" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #505050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 22px; letter-spacing: 0.7px; word-break: break-word" ><singleline label="Title"></singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="13" style="font-size:0px" >&nbsp;</td></tr>
                                            
                                            <tr><td height="25" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                       
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="15" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- link -->
                                            <tr >
                                                <td class="res-center" style="text-align: center;" >
                                                    <a href="https://example.com" style="color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.7px; text-decoration: none; word-break: break-word;" ><singleline label="Link"></singleline></a>
                                                </td>
                                            </tr>
                                            <!-- link end -->
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout></repeater>

        <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table bgcolor="#F5F5F5" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                    <tr>
                                        <td>
                                            <table align="center" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                            
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #909090; font-family: ' . $nunito . ', Arial, Sans-serif; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; font-size: 15px;" ><multiline label="Paragraph">Veja mais produtos do Gravador Pub!</multiline></td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                           
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; padding-left: 7px; font-weight: 600;" >
                                                                    <a href="https://gravadorpub.com.br/loja/produtos.php">Clique Aqui</a>
                                                                </td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </body>
</html>';
                }
                if ($con->query($sql_insert) === true) {
                    if (date("Y-m-d") <= $data_c) {
                    try {
                        $mail->SMTPDebug = 0;
                        $mail->isSMTP();
                        $mail->Host = 'smtp.titan.email';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'compras@gravadorpub.com.br';
                        $mail->Password = 'gravador12!';
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                        $mail->Port = 465;
                        $mail->CharSet = 'UTF-8';
                        $mail->setFrom('compras@gravadorpub.com.br', 'Gravador Pub');
                        $mail->addAddress($email);
                        $mail->isHTML(true);
                        $mail->Subject = 'Atualização na Transação - Gravador Pub - ' . $status1 . '';
                        if ($qtd_ing > 1) {
                            $mail->Body = $msg;
                            $mail->AltBody = $altbody1;
                        } else {
                            $mail->Body = $msg2;
                            $mail->AltBody = $altbody2;
                        }

                        $mail->send();
                        $mail->ClearAllRecipients();
                        $mail->SmtpClose();
                    } catch (Exception $e) {
                        echo "O e-mail não pôde ser enviado: {$mail->ErrorInfo}";
                    }
                    if ($tipo == "evento") {

                        $sql_insert_i = "UPDATE evento SET qtd_ing = qtd_ing - $qtd, ingvendidos = ingvendidos + $qtd WHERE nomearq = '$nomearq'";
                        $con->query($sql_insert_i);
                        for ($i = 0; $i < $qtd; $i++) {
                            if ($lotes[$i] != "normal") {
                                $sql_insert_l = "UPDATE lote SET qtd_ing = qtd_ing - 1, ingvendidos = ingvendidos + 1 WHERE nome='$lotes[$i]' AND nomearq = '$nomearq'";
                                $con->query($sql_insert_l);
                            }
                        }
                        $c = 0;
                        for ($i = 0; $i < count($nomesing_a); $i++) {
                            $c++;
                            $data = date("Y-m-d") . " " . date("H:i:s");
                            $nome = $nomesing_a[$i];
                            $pasta = 'qrcodes/';
                            $arq = md5(uniqid(rand(), true)) . ".png";
                            $file = $pasta . $arq;
                            if ($lotes[$i] === "normal") {
                                $texto = "https://gravadorpub.com.br/validacao.php?referencia=" . $reference . "&valor=" . $valor . "&nome=" . $nome . "&arq_qrcode=" . $arq . "&nome_evento=". $nomeprod . "&data_envio=" . $data;
                                QRcode::png($texto, $file);
                                $sql_insert2 = "INSERT INTO ingressos (referencia, valor, nome, arq_qrcode, validado, nome_evento, data_envio) VALUES ('$reference', '$valor', '$nome', '$arq', '0', '$nomeprod', '$data') ON DUPLICATE KEY UPDATE data_envio = VALUES(data_envio)";
                                $con->query($sql_insert2);
                            } else {
                                $sql_v = "select * from lote WHERE nome='$lotes[$i]' AND nomearq='$nomearq' limit 1";
                                $resultado_v = $con->query($sql_v);
                                if ($resultado_v->num_rows > 0) {
                                    while ($row_v = $resultado_v->fetch_assoc()) {
                                        $texto = "https://gravadorpub.com.br/validacao.php?referencia=" . $reference . "&valor=" . $row_v["valor"] . "&nome=" . $nome . "&arq_qrcode=" . $arq . "&data_envio=" . $data;
                                        QRcode::png($texto, $file);
                                        $sql_insert2 = "INSERT INTO ingressos (referencia, valor, nome, arq_qrcode, validado, nome_evento, lote, data_envio) VALUES ('$reference', '{$row_v["valor"]}', '$nome', '$arq', '0', '$nomeprod', '$lotes[$i]', '$data') ON DUPLICATE KEY UPDATE data_envio = VALUES(data_envio)";
                                        $con->query($sql_insert2);
                                    }
                                }
                            }
                            $open_sans = "'Open Sans'";
                            $nunito = "'Nunito'";
                            $raleway = "'Raleway'";
                            $msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--[if !mso]><!--><meta http-equiv="X-UA-Compatible" content="IE=edge" /><!--<![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Gravador Pub</title>
        <style>


            @import url(https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900|Raleway:200,300,400,500,600,700,800,900);

            html{width:100%}
            body{-webkit-text-size-adjust:none;-ms-text-size-adjust:none;margin:0;padding:0;font-family:' . $open_sans . ',Arial,Sans-serif!important}
            table{border-spacing:0;table-layout:auto;margin:0 auto}
            img{display:block!important;overflow:hidden!important}
            a{text-decoration: none;color:unset}
            .ReadMsgBody{width:100%;background-color:#fff}
            .ExternalClass{width:100%;background-color:#fff}
            .ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:100%}
            .yshortcuts a{border-bottom:none!important}
            .full{width:100%}
            .pad{width:92%}
            @media only screen and (max-width: 650px) {
                .res-pad{width:92%;max-width:92%}
                .res-full{width:100%;max-width:100%}
                .res-left{text-align:left!important}
                .res-right{text-align:right!important}
                .res-center{text-align:center!important}
            }@media only screen and (max-width: 750px) {
                .margin-full{width:100%;max-width:100%}
                .margin-pad{width:92%;max-width:92%;max-width:600px}
            }
        </style>
    </head>
    <body><repeater><layout label="Module 1 - Header">
                <!-- ====== Module : Header ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- column x2 -->
                                            <tr >
                                                <td>
                                                    <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">GRAVADOR PUB</singleline></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- column x2 end -->
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                </table></layout><layout label="Module 2 - Intro">
                <!-- ====== Module : Intro ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="#304050" align="center" width="750" class="margin-full" style="background-size:cover; background-position:center;" border="0" cellpadding="0" cellspacing="0" background="img/module02-bg01.png">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 2px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle">INGRESSO:</singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="12" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">' . $nomeprod . '</singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="20" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- dash -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table bgcolor="white" align="center" style="border-radius: 10px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td width="60" height="3" style="font-size:0px" >&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- dash end -->
                                            <tr><td height="21" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: justify; text-indent: 5%; color: white; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                    Ingresso pertencente a <b>' . $nome . '</b> para o <b>' . $nomeprod . '</b> no Gravador Pub! Abaixo segue seu ticket com um <b>QRcode</b> para ser apresentado na entrada, após ser escaneado ele validará seu ingresso! Caso não consiga acessar o ticket o QRCode também vai estar em <b>anexo</b> no e-mail.
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="24" style="font-size:0px" >&nbsp;</td></tr>                                           
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout><layout label="Module 3 - Trending Events summary">
                    
                <!-- ====== Module : Trending Events summary ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 0.7px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle">TICKET</singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="7" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #505050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 22px; letter-spacing: 0.7px; word-break: break-word" ><singleline label="Title">' . $nomeprod . '</singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="13" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- dash -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table bgcolor="#006D89" align="center" style="border-radius: 10px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td width="50" height="3" style="font-size:0px" >&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- dash end -->
                                            <tr><td height="25" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" >
                                                    <center><img src="cid:'.$nome.''.$i.'" alt="QRcode"></center>
                                                </td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="15" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- link -->
                                            <tr >
                                                <td class="res-center" style="text-align: center;" >
                                                    <p style="color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.7px; text-decoration: none; word-break: break-word;" ><singleline label="Link">Apresente este <b>QRcode</b> na entrada do Gravador Pub</singleline></p>
                                                </td>
                                            </tr>
                                            <!-- link end -->
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout></repeater>
        <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table bgcolor="#F5F5F5" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                    <tr>
                                        <td>
                                            <table align="center" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                            
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #909090; font-family: ' . $nunito . ', Arial, Sans-serif; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; font-size: 15px;" ><multiline label="Paragraph">Veja mais eventos do Gravador Pub! </multiline></td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                           
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; padding-left: 7px; font-weight: 600;" >
                                                                    <a href="https://gravadorpub.com.br/agenda/janeiro.php">Clique Aqui</a>
                                                                </td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>';
                            try {
                                $mail->SMTPDebug = 0;
                                $mail->isSMTP();
                                $mail->Host = 'smtp.titan.email';
                                $mail->SMTPKeepAlive = true;
                                $mail->SMTPAuth = true;
                                $mail->Username = 'compras@gravadorpub.com.br';
                                $mail->Password = 'gravador12!';
                                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                                $mail->Port = 465;
                                $mail->CharSet = 'UTF-8';
                                $mail->setFrom('compras@gravadorpub.com.br', 'Gravador Pub');
                                $mail->addAddress($email);
                                $mail->AddCC('ingressos@gravadorpub.com.br', 'Ingressos Gravador Pub');
                                $mail->AddEmbeddedImage($file, $nome.$i, $nome.$i);
                                $mail->addAttachment($file, 'QRCode-' . $nome . '.png');
                                $mail->isHTML(true);
                                $mail->Subject = 'Ingresso Gravador Pub - ' . $nomeprod . ' - ' . $nome . '';
                                $mail->Body = $msg;
                                $mail->AltBody = 'Ingresso pertencente a ' . $nome . ' para o ' . $nomeprod . ' no Gravador Pub! Abaixo segue um QRcode para ser apresentado na portaria, após ser escaneado ele validará sua entrada!';
                                $mail->send();
                                $mail->ClearAllRecipients();
                                $mail->ClearAttachments();
                            } catch (Exception $e) {
                                echo "O e-mail não pôde ser enviado: {$mail->ErrorInfo}";
                            }
                            sleep(1);
                            }
                        }
                    }
                    if ($tipo == "produto") {
                        $mail->SmtpClose();
                        $sql_p = "SELECT * FROM qtd_temp WHERE nomearq = '$nomearq'";
                        $resultado = $con->query($sql_p);
                        if ($resultado->num_rows > 0) {
                            $i = 0;
                            while ($row = $resultado->fetch_assoc()) {
                                $sql_insert2 = "UPDATE produtos SET qtd = qtd - {$row["qtd"]} WHERE nome = '{$row["nome"]}' AND nomearq = '$nomearq'";
                                $con->query($sql_insert2);
                                $p_nome[$i] = $row["nome"];
                                $p_qtd[$i] = $row["qtd"];
                                $i++;
                            }
                        }
                        $str_del = "DELETE FROM qtd_temp WHERE nomearq = '$nomearq'";
                        $con->query($str_del);
                        try {
                            $mail->SMTPDebug = 0;
                            $mail->isSMTP();
                            $mail->Host = 'smtp.titan.email';
                            $mail->SMTPKeepAlive = true;
                            $mail->SMTPAuth = true;
                            $mail->Username = 'compras@gravadorpub.com.br';
                            $mail->Password = 'gravador12!';
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                            $mail->Port = 465;
                            $mail->CharSet = 'UTF-8';
                            $mail->setFrom('compras@gravadorpub.com.br', 'Gravador Pub');
                            $mail->addAddress('loja@gravadorpub.com.br');
                            $mail->isHTML(true);
                            $mail->Subject = $nome_pri[0]." - ".$nomeprod;
                            $mail->Body = 'De: ' . $nome_com . ' | Produto: ' . $nomeprod . ' | Tipo: ' . implode(' - ', $p_nome) . ' | Quantidade: ' . implode(' - ', $p_qtd);
                            $mail->AltBody = 'De: ' . $nome_com . ' | Produto: ' . $nomeprod . ' | Tipo: ' . implode(' - ', $p_nome) . ' | Quantidade: ' . implode(' - ', $p_qtd);
                            $mail->send();
                            $mail->ClearAllRecipients();
                            $mail->ClearAttachments();
                        } catch (Exception $e) {
                            echo "O e-mail não pôde ser enviado: {$mail->ErrorInfo}";
                        }
                    }
                }

                $con->close();
                break;

            case "AVAILABLE":
                $status1 = "DISPONÍVEL";
                $sql_insert = "INSERT INTO transacao (codigo, referencia, estado, nomearq, data_transacao) VALUES ('$notificationCode', '$reference', '$status1', '$nomearq', NOW()) ON DUPLICATE KEY UPDATE codigo = VALUES(codigo), estado = VALUES(estado), data_transacao = VALUES(data_transacao)";
                $open_sans = "'Open Sans'";
                $nunito = "'Nunito'";
                $raleway = "'Raleway'";
                if ($tipo == "evento") {
                    $qtd_ing = count($nomesing_a);
                    $altbody1 = 'Olá, ' . $nome_pri[0] . '! Você acabou de adquirir ' . count($nomesing_a) . ' ingressos do Gravador Pub para o ' . $nomeprod . '! Obrigado pela preferência! O estado atual de sua transação é: ' . $status1 . '.' . ' Seus ' . count($nomesing_a) . ' ingressos serão enviados para este e-mail após a confirmação do pagamento!';
                    $altbody2 = 'Olá, ' . $nome_pri[0] . '! Você acabou de adquirir um ingresso do Gravador Pub para o ' . $nomeprod . '! Obrigado pela preferência! O estado atual de sua transação é: ' . $status1 . '.' . ' Seu ingresso será enviado para este e-mail após a confirmação do pagamento!';
                    $msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--[if !mso]><!--><meta http-equiv="X-UA-Compatible" content="IE=edge" /><!--<![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Gravador Pub</title>
        <style>


            @import url(https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900|Raleway:200,300,400,500,600,700,800,900);

            html{width:100%}
            body{-webkit-text-size-adjust:none;-ms-text-size-adjust:none;margin:0;padding:0;font-family:' . $open_sans . ',Arial,Sans-serif!important}
            table{border-spacing:0;table-layout:auto;margin:0 auto}
            img{display:block!important;overflow:hidden!important}
            a{text-decoration: none;color:unset}
            .ReadMsgBody{width:100%;background-color:#fff}
            .ExternalClass{width:100%;background-color:#fff}
            .ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:100%}
            .yshortcuts a{border-bottom:none!important}
            .full{width:100%}
            .pad{width:92%}
            @media only screen and (max-width: 650px) {
                .res-pad{width:92%;max-width:92%}
                .res-full{width:100%;max-width:100%}
                .res-left{text-align:left!important}
                .res-right{text-align:right!important}
                .res-center{text-align:center!important}
            }@media only screen and (max-width: 750px) {
                .margin-full{width:100%;max-width:100%}
                .margin-pad{width:92%;max-width:92%;max-width:600px}
            }
        </style>
    </head>
    <body><repeater><layout label="Module 1 - Header">
                <!-- ====== Module : Header ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- column x2 -->
                                            <tr >
                                                <td>
                                                    <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">GRAVADOR PUB</singleline></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- column x2 end -->
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                </table></layout><layout label="Module 2 - Intro">
                <!-- ====== Module : Intro ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="#304050" align="center" width="750" class="margin-full" style="background-size:cover; background-position:center;" border="0" cellpadding="0" cellspacing="0" background="img/module02-bg01.png">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 2px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle">STATUS DA TRANSAÇÃO:</singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="12" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">' . $status1 . '</singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="20" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- dash -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table bgcolor="white" align="center" style="border-radius: 10px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td width="60" height="3" style="font-size:0px" >&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- dash end -->
                                            <tr><td height="21" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: justify; text-indent: 5%; color: white; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                    Olá, ' . $nome_pri[0] . '! Este e-mail é referente a <b>' . $nomeprod . '</b>! Obrigado pela preferência! Seus ' . count($nomesing_a) . ' ingressos serão enviados para este e-mail em seguida!
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="24" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- button -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table align="center" bgcolor="#006D89" style="border: 1.5px solid white; border-radius: 4px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td height="43" style="padding: 0 23px; text-align: center;" >
                                                                             <a href="https://gravadorpub.com.br/home.php" style="color: white; letter-spacing: 1px; font-size: 17px; font-family: ' . $nunito . ', Arial, Sans-serif; text-decoration: none; text-align: center; line-height: 24px; word-break: break-word;" ><singleline label="Button">VOLTAR AO SITE</singleline></a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- button end -->
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout><layout label="Module 3 - Trending Events summary">
                    
                <!-- ====== Module : Trending Events summary ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 0.7px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle"></singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="7" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #505050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 22px; letter-spacing: 0.7px; word-break: break-word" ><singleline label="Title"></singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="13" style="font-size:0px" >&nbsp;</td></tr>
                                            
                                            <tr><td height="25" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                       
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="15" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- link -->
                                            <tr >
                                                <td class="res-center" style="text-align: center;" >
                                                    <a href="https://example.com" style="color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.7px; text-decoration: none; word-break: break-word;" ><singleline label="Link"></singleline></a>
                                                </td>
                                            </tr>
                                            <!-- link end -->
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout></repeater>

        <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table bgcolor="#F5F5F5" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                    <tr>
                                        <td>
                                            <table align="center" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                            
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #909090; font-family: ' . $nunito . ', Arial, Sans-serif; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; font-size: 15px;" ><multiline label="Paragraph">Veja mais eventos do Gravador Pub!</multiline></td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                           
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; padding-left: 7px; font-weight: 600;" >
                                                                    <a href="https://gravadorpub.com.br/agenda/janeiro.php">Clique Aqui</a>
                                                                </td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </body>
</html>';
                    $msg2 = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--[if !mso]><!--><meta http-equiv="X-UA-Compatible" content="IE=edge" /><!--<![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Gravador Pub</title>
        <style>


            @import url(https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900|Raleway:200,300,400,500,600,700,800,900);

            html{width:100%}
            body{-webkit-text-size-adjust:none;-ms-text-size-adjust:none;margin:0;padding:0;font-family:' . $open_sans . ',Arial,Sans-serif!important}
            table{border-spacing:0;table-layout:auto;margin:0 auto}
            img{display:block!important;overflow:hidden!important}
            a{text-decoration: none;color:unset}
            .ReadMsgBody{width:100%;background-color:#fff}
            .ExternalClass{width:100%;background-color:#fff}
            .ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:100%}
            .yshortcuts a{border-bottom:none!important}
            .full{width:100%}
            .pad{width:92%}
            @media only screen and (max-width: 650px) {
                .res-pad{width:92%;max-width:92%}
                .res-full{width:100%;max-width:100%}
                .res-left{text-align:left!important}
                .res-right{text-align:right!important}
                .res-center{text-align:center!important}
            }@media only screen and (max-width: 750px) {
                .margin-full{width:100%;max-width:100%}
                .margin-pad{width:92%;max-width:92%;max-width:600px}
            }
        </style>
    </head>
    <body><repeater><layout label="Module 1 - Header">
                <!-- ====== Module : Header ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- column x2 -->
                                            <tr >
                                                <td>
                                                    <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">GRAVADOR PUB</singleline></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- column x2 end -->
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                </table></layout><layout label="Module 2 - Intro">
                <!-- ====== Module : Intro ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="#304050" align="center" width="750" class="margin-full" style="background-size:cover; background-position:center;" border="0" cellpadding="0" cellspacing="0" background="img/module02-bg01.png">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 2px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle">STATUS DA TRANSAÇÃO:</singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="12" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">' . $status1 . '</singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="20" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- dash -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table bgcolor="white" align="center" style="border-radius: 10px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td width="60" height="3" style="font-size:0px" >&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- dash end -->
                                            <tr><td height="21" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: justify; text-indent: 5%; color: white; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                    Olá, ' . $nome_pri[0] . '! Este e-mail é referente a <b>' . $nomeprod . '</b>! Obrigado pela preferência! Seu ingresso será enviado para este e-mail em seguida!
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="24" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- button -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table align="center" bgcolor="#006D89" style="border: 1.5px solid white; border-radius: 4px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td height="43" style="padding: 0 23px; text-align: center;" >
                                                                             <a href="https://gravadorpub.com.br/home.php" style="color: white; letter-spacing: 1px; font-size: 17px; font-family: ' . $nunito . ', Arial, Sans-serif; text-decoration: none; text-align: center; line-height: 24px; word-break: break-word;" ><singleline label="Button">VOLTAR AO SITE</singleline></a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- button end -->
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout><layout label="Module 3 - Trending Events summary">
                    
                <!-- ====== Module : Trending Events summary ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 0.7px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle"></singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="7" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #505050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 22px; letter-spacing: 0.7px; word-break: break-word" ><singleline label="Title"></singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="13" style="font-size:0px" >&nbsp;</td></tr>
                                            
                                            <tr><td height="25" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                       
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="15" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- link -->
                                            <tr >
                                                <td class="res-center" style="text-align: center;" >
                                                    <a href="https://example.com" style="color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.7px; text-decoration: none; word-break: break-word;" ><singleline label="Link"></singleline></a>
                                                </td>
                                            </tr>
                                            <!-- link end -->
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout></repeater>

        <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table bgcolor="#F5F5F5" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                    <tr>
                                        <td>
                                            <table align="center" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                            
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #909090; font-family: ' . $nunito . ', Arial, Sans-serif; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; font-size: 15px;" ><multiline label="Paragraph">Veja mais eventos do Gravador Pub!</multiline></td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                           
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; padding-left: 7px; font-weight: 600;" >
                                                                    <a href="https://gravadorpub.com.br/agenda/janeiro.php">Clique Aqui</a>
                                                                </td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </body>
</html>';
                } elseif ($tipo == "produto") {
                    $qtd_ing = $qtd;
                    $altbody2 = 'Olá, ' . $nome_pri[0] . '! Este e-mail é referente à compra do produto ' . $nomeprod . '! Obrigado pela preferência! O estado atual de sua transação é: ' . $status1 . '.';
                    $altbody1 = 'Olá, ' . $nome_pri[0] . '! Este e-mail é referente à compra dos ' . $qtd . ' produtos ' . $nomeprod . '! Obrigado pela preferência! O estado atual de sua transação é: ' . $status1 . '.';
                    $msg2 = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--[if !mso]><!--><meta http-equiv="X-UA-Compatible" content="IE=edge" /><!--<![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Gravador Pub</title>
        <style>


            @import url(https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900|Raleway:200,300,400,500,600,700,800,900);

            html{width:100%}
            body{-webkit-text-size-adjust:none;-ms-text-size-adjust:none;margin:0;padding:0;font-family:' . $open_sans . ',Arial,Sans-serif!important}
            table{border-spacing:0;table-layout:auto;margin:0 auto}
            img{display:block!important;overflow:hidden!important}
            a{text-decoration: none;color:unset}
            .ReadMsgBody{width:100%;background-color:#fff}
            .ExternalClass{width:100%;background-color:#fff}
            .ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:100%}
            .yshortcuts a{border-bottom:none!important}
            .full{width:100%}
            .pad{width:92%}
            @media only screen and (max-width: 650px) {
                .res-pad{width:92%;max-width:92%}
                .res-full{width:100%;max-width:100%}
                .res-left{text-align:left!important}
                .res-right{text-align:right!important}
                .res-center{text-align:center!important}
            }@media only screen and (max-width: 750px) {
                .margin-full{width:100%;max-width:100%}
                .margin-pad{width:92%;max-width:92%;max-width:600px}
            }
        </style>
    </head>
    <body><repeater><layout label="Module 1 - Header">
                <!-- ====== Module : Header ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- column x2 -->
                                            <tr >
                                                <td>
                                                    <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">GRAVADOR PUB</singleline></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- column x2 end -->
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                </table></layout><layout label="Module 2 - Intro">
                <!-- ====== Module : Intro ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="#304050" align="center" width="750" class="margin-full" style="background-size:cover; background-position:center;" border="0" cellpadding="0" cellspacing="0" background="img/module02-bg01.png">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 2px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle">STATUS DA TRANSAÇÃO:</singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="12" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">' . $status1 . '</singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="20" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- dash -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table bgcolor="white" align="center" style="border-radius: 10px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td width="60" height="3" style="font-size:0px" >&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- dash end -->
                                            <tr><td height="21" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: justify; text-indent: 5%; color: white; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                    Olá, ' . $nome_pri[0] . '! Este e-mail é referente à compra do produto <b>' . $nomeprod . '</b>! Obrigado pela preferência!
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="24" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- button -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table align="center" bgcolor="#006D89" style="border: 1.5px solid white; border-radius: 4px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td height="43" style="padding: 0 23px; text-align: center;" >
                                                                             <a href="https://gravadorpub.com.br/home.php" style="color: white; letter-spacing: 1px; font-size: 17px; font-family: ' . $nunito . ', Arial, Sans-serif; text-decoration: none; text-align: center; line-height: 24px; word-break: break-word;" ><singleline label="Button">VOLTAR AO SITE</singleline></a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- button end -->
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout><layout label="Module 3 - Trending Events summary">
                    
                <!-- ====== Module : Trending Events summary ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 0.7px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle"></singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="7" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #505050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 22px; letter-spacing: 0.7px; word-break: break-word" ><singleline label="Title"></singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="13" style="font-size:0px" >&nbsp;</td></tr>
                                            
                                            <tr><td height="25" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                       
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="15" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- link -->
                                            <tr >
                                                <td class="res-center" style="text-align: center;" >
                                                    <a href="https://example.com" style="color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.7px; text-decoration: none; word-break: break-word;" ><singleline label="Link"></singleline></a>
                                                </td>
                                            </tr>
                                            <!-- link end -->
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout></repeater>

        <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table bgcolor="#F5F5F5" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                    <tr>
                                        <td>
                                            <table align="center" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                            
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #909090; font-family: ' . $nunito . ', Arial, Sans-serif; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; font-size: 15px;" ><multiline label="Paragraph">Veja mais produtos do Gravador Pub!</multiline></td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                           
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; padding-left: 7px; font-weight: 600;" >
                                                                    <a href="https://gravadorpub.com.br/loja/produtos.php">Clique Aqui</a>
                                                                </td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </body>
</html>';

                    $msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--[if !mso]><!--><meta http-equiv="X-UA-Compatible" content="IE=edge" /><!--<![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Gravador Pub</title>
        <style>


            @import url(https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900|Raleway:200,300,400,500,600,700,800,900);

            html{width:100%}
            body{-webkit-text-size-adjust:none;-ms-text-size-adjust:none;margin:0;padding:0;font-family:' . $open_sans . ',Arial,Sans-serif!important}
            table{border-spacing:0;table-layout:auto;margin:0 auto}
            img{display:block!important;overflow:hidden!important}
            a{text-decoration: none;color:unset}
            .ReadMsgBody{width:100%;background-color:#fff}
            .ExternalClass{width:100%;background-color:#fff}
            .ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:100%}
            .yshortcuts a{border-bottom:none!important}
            .full{width:100%}
            .pad{width:92%}
            @media only screen and (max-width: 650px) {
                .res-pad{width:92%;max-width:92%}
                .res-full{width:100%;max-width:100%}
                .res-left{text-align:left!important}
                .res-right{text-align:right!important}
                .res-center{text-align:center!important}
            }@media only screen and (max-width: 750px) {
                .margin-full{width:100%;max-width:100%}
                .margin-pad{width:92%;max-width:92%;max-width:600px}
            }
        </style>
    </head>
    <body><repeater><layout label="Module 1 - Header">
                <!-- ====== Module : Header ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- column x2 -->
                                            <tr >
                                                <td>
                                                    <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">GRAVADOR PUB</singleline></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- column x2 end -->
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                </table></layout><layout label="Module 2 - Intro">
                <!-- ====== Module : Intro ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="#304050" align="center" width="750" class="margin-full" style="background-size:cover; background-position:center;" border="0" cellpadding="0" cellspacing="0" background="img/module02-bg01.png">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 2px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle">STATUS DA TRANSAÇÃO:</singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="12" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">' . $status1 . '</singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="20" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- dash -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table bgcolor="white" align="center" style="border-radius: 10px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td width="60" height="3" style="font-size:0px" >&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- dash end -->
                                            <tr><td height="21" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: justify; text-indent: 5%; color: white; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                    Olá, ' . $nome_pri[0] . '! Este e-mail é referente à compra dos ' . $qtd . ' produtos <b>' . $nomeprod . '</b>! Obrigado pela preferência!
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="24" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- button -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table align="center" bgcolor="#006D89" style="border: 1.5px solid white; border-radius: 4px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td height="43" style="padding: 0 23px; text-align: center;" >
                                                                             <a href="https://gravadorpub.com.br/home.php" style="color: white; letter-spacing: 1px; font-size: 17px; font-family: ' . $nunito . ', Arial, Sans-serif; text-decoration: none; text-align: center; line-height: 24px; word-break: break-word;" ><singleline label="Button">VOLTAR AO SITE</singleline></a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- button end -->
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout><layout label="Module 3 - Trending Events summary">
                    
                <!-- ====== Module : Trending Events summary ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 0.7px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle"></singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="7" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #505050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 22px; letter-spacing: 0.7px; word-break: break-word" ><singleline label="Title"></singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="13" style="font-size:0px" >&nbsp;</td></tr>
                                            
                                            <tr><td height="25" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                       
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="15" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- link -->
                                            <tr >
                                                <td class="res-center" style="text-align: center;" >
                                                    <a href="https://example.com" style="color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.7px; text-decoration: none; word-break: break-word;" ><singleline label="Link"></singleline></a>
                                                </td>
                                            </tr>
                                            <!-- link end -->
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout></repeater>

        <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table bgcolor="#F5F5F5" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                    <tr>
                                        <td>
                                            <table align="center" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                            
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #909090; font-family: ' . $nunito . ', Arial, Sans-serif; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; font-size: 15px;" ><multiline label="Paragraph">Veja mais produtos do Gravador Pub!</multiline></td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                           
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; padding-left: 7px; font-weight: 600;" >
                                                                    <a href="https://gravadorpub.com.br/loja/produtos.php">Clique Aqui</a>
                                                                </td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </body>
</html>';
                }
                if ($con->query($sql_insert) === true) {
                    if (date("Y-m-d") <= $data_c) {
                    try {
                        $mail->SMTPDebug = 0;
                        $mail->isSMTP();
                        $mail->Host = 'smtp.titan.email';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'compras@gravadorpub.com.br';
                        $mail->Password = 'gravador12!';
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                        $mail->Port = 465;
                        $mail->CharSet = 'UTF-8';
                        $mail->setFrom('compras@gravadorpub.com.br', 'Gravador Pub');
                        $mail->addAddress($email);
                        $mail->isHTML(true);
                        $mail->Subject = 'Atualização na Transação - Gravador Pub - ' . $status1 . '';
                        if ($qtd_ing > 1) {
                            $mail->Body = $msg;
                            $mail->AltBody = $altbody1;
                        } else {
                            $mail->Body = $msg2;
                            $mail->AltBody = $altbody2;
                        }

                        $mail->send();
                        $mail->ClearAllRecipients();
                    } catch (Exception $e) {
                        echo "O e-mail não pôde ser enviado: {$mail->ErrorInfo}";
                    }
                    $mail->SmtpClose();
                    if ($tipo == "evento") {

                        $sql_insert_i = "UPDATE evento SET qtd_ing = qtd_ing - $qtd, ingvendidos = ingvendidos + $qtd WHERE nomearq = '$nomearq'";
                        $con->query($sql_insert_i);
                        for ($i = 0; $i < $qtd; $i++) {
                            if ($lotes[$i] != "normal") {
                                $sql_insert_l = "UPDATE lote SET qtd_ing = qtd_ing - 1, ingvendidos = ingvendidos + 1 WHERE nome='$lotes[$i]' AND nomearq = '$nomearq'";
                                $con->query($sql_insert_l);
                            }
                        }

                        $c = 0;
                        for ($i = 0; $i < count($nomesing_a); $i++) {
                            $c++;
                            $data = date("Y-m-d") . " " . date("H:i:s");
                            $nome = $nomesing_a[$i];
                            $pasta = 'qrcodes/';
                            $arq = md5(uniqid(rand(), true)) . ".png";
                            $file = $pasta . $arq;
                            if ($lotes[$i] === "normal") {
                                $texto = "https://gravadorpub.com.br/validacao.php?referencia=" . $reference . "&valor=" . $valor . "&nome=" . $nome . "&arq_qrcode=" . $arq . "&nome_evento=". $nomeprod . "&data_envio=" . $data;
                                QRcode::png($texto, $file);
                                $sql_insert2 = "INSERT INTO ingressos (referencia, valor, nome, arq_qrcode, validado, nome_evento, data_envio) VALUES ('$reference', '$valor', '$nome', '$arq', '0', '$nomeprod', '$data') ON DUPLICATE KEY UPDATE data_envio = VALUES(data_envio)";
                                $con->query($sql_insert2);
                            } else {
                                $sql_v = "select * from lote WHERE nome='$lotes[$i]' AND nomearq='$nomearq' limit 1";
                                $resultado_v = $con->query($sql_v);
                                if ($resultado_v->num_rows > 0) {
                                    while ($row_v = $resultado_v->fetch_assoc()) {
                                        $texto = "https://gravadorpub.com.br/validacao.php?referencia=" . $reference . "&valor=" . $row_v["valor"] . "&nome=" . $nome . "&arq_qrcode=" . $arq . "&data_envio=" . $data;
                                        QRcode::png($texto, $file);
                                        $sql_insert2 = "INSERT INTO ingressos (referencia, valor, nome, arq_qrcode, validado, nome_evento, lote, data_envio) VALUES ('$reference', '{$row_v["valor"]}', '$nome', '$arq', '0', '$nomeprod', '$lotes[$i]', '$data') ON DUPLICATE KEY UPDATE data_envio = VALUES(data_envio)";
                                        $con->query($sql_insert2);
                                    }
                                }
                            }
                            $open_sans = "'Open Sans'";
                            $nunito = "'Nunito'";
                            $raleway = "'Raleway'";
                            $msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--[if !mso]><!--><meta http-equiv="X-UA-Compatible" content="IE=edge" /><!--<![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Gravador Pub</title>
        <style>


            @import url(https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900|Raleway:200,300,400,500,600,700,800,900);

            html{width:100%}
            body{-webkit-text-size-adjust:none;-ms-text-size-adjust:none;margin:0;padding:0;font-family:' . $open_sans . ',Arial,Sans-serif!important}
            table{border-spacing:0;table-layout:auto;margin:0 auto}
            img{display:block!important;overflow:hidden!important}
            a{text-decoration: none;color:unset}
            .ReadMsgBody{width:100%;background-color:#fff}
            .ExternalClass{width:100%;background-color:#fff}
            .ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:100%}
            .yshortcuts a{border-bottom:none!important}
            .full{width:100%}
            .pad{width:92%}
            @media only screen and (max-width: 650px) {
                .res-pad{width:92%;max-width:92%}
                .res-full{width:100%;max-width:100%}
                .res-left{text-align:left!important}
                .res-right{text-align:right!important}
                .res-center{text-align:center!important}
            }@media only screen and (max-width: 750px) {
                .margin-full{width:100%;max-width:100%}
                .margin-pad{width:92%;max-width:92%;max-width:600px}
            }
        </style>
    </head>
    <body><repeater><layout label="Module 1 - Header">
                <!-- ====== Module : Header ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- column x2 -->
                                            <tr >
                                                <td>
                                                    <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">GRAVADOR PUB</singleline></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- column x2 end -->
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                </table></layout><layout label="Module 2 - Intro">
                <!-- ====== Module : Intro ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="#304050" align="center" width="750" class="margin-full" style="background-size:cover; background-position:center;" border="0" cellpadding="0" cellspacing="0" background="img/module02-bg01.png">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 2px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle">INGRESSO:</singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="12" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">' . $nomeprod . '</singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="20" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- dash -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table bgcolor="white" align="center" style="border-radius: 10px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td width="60" height="3" style="font-size:0px" >&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- dash end -->
                                            <tr><td height="21" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: justify; text-indent: 5%; color: white; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                    Ingresso pertencente a <b>' . $nome . '</b> para o <b>' . $nomeprod . '</b> no Gravador Pub! Abaixo segue seu ticket com um <b>QRcode</b> para ser apresentado na entrada, após ser escaneado ele validará seu ingresso! Caso não consiga acessar o ticket o QRCode também vai estar em <b>anexo</b> no e-mail.
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="24" style="font-size:0px" >&nbsp;</td></tr>                                           
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout><layout label="Module 3 - Trending Events summary">
                    
                <!-- ====== Module : Trending Events summary ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 0.7px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle">TICKET</singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="7" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #505050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 22px; letter-spacing: 0.7px; word-break: break-word" ><singleline label="Title">' . $nomeprod . '</singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="13" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- dash -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table bgcolor="#006D89" align="center" style="border-radius: 10px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td width="50" height="3" style="font-size:0px" >&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- dash end -->
                                            <tr><td height="25" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" >
                                                    <center><img src="cid:'.$nome.''.$i.'" alt="QRcode"></center>
                                                </td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="15" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- link -->
                                            <tr >
                                                <td class="res-center" style="text-align: center;" >
                                                    <p style="color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.7px; text-decoration: none; word-break: break-word;" ><singleline label="Link">Apresente este <b>QRcode</b> na entrada do Gravador Pub</singleline></p>
                                                </td>
                                            </tr>
                                            <!-- link end -->
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout></repeater>
        <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table bgcolor="#F5F5F5" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                    <tr>
                                        <td>
                                            <table align="center" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                            
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #909090; font-family: ' . $nunito . ', Arial, Sans-serif; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; font-size: 15px;" ><multiline label="Paragraph">Veja mais eventos do Gravador Pub! </multiline></td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                           
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; padding-left: 7px; font-weight: 600;" >
                                                                    <a href="https://gravadorpub.com.br/agenda/janeiro.php">Clique Aqui</a>
                                                                </td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>';
                            if ($con->query($sql_insert2) === true) {
                                try {
                                    $mail->SMTPDebug = 0;
                                    $mail->isSMTP();
                                    $mail->Host = 'smtp.titan.email';
                                    $mail->SMTPKeepAlive = true;
                                    $mail->SMTPAuth = true;
                                    $mail->Username = 'compras@gravadorpub.com.br';
                                    $mail->Password = 'gravador12!';
                                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                                    $mail->Port = 465;
                                    $mail->CharSet = 'UTF-8';
                                    $mail->setFrom('compras@gravadorpub.com.br', 'Gravador Pub');
                                    $mail->addAddress($email);
                                    $mail->AddCC('ingressos@gravadorpub.com.br', 'Ingressos Gravador Pub');
                                    $mail->AddEmbeddedImage($file, $nome.$i, $nome.$i);
                                    $mail->addAttachment($file, 'QRCode-' . $nome . '.png');
                                    $mail->isHTML(true);
                                    $mail->Subject = 'Ingresso Gravador Pub - ' . $nomeprod . ' - ' . $nome . '';
                                    $mail->Body = $msg;
                                    $mail->AltBody = 'Ingresso pertencente a ' . $nome . ' para o ' . $nomeprod . ' no Gravador Pub! Abaixo segue um QRcode para ser apresentado na portaria, após ser escaneado ele validará sua entrada!';
                                    $mail->send();
                                    $mail->ClearAllRecipients();
                                    $mail->ClearAttachments();
                                    $mail->SmtpClose();
                                } catch (Exception $e) {
                                    echo "O e-mail não pôde ser enviado: {$mail->ErrorInfo}";
                                }
                            }
                            sleep(1);
                            }
                        }
                    }    
                    if ($tipo == "produto") {
                        $mail->SmtpClose();
                        $sql_p = "SELECT * FROM qtd_temp WHERE nomearq = '$nomearq'";
                        $resultado = $con->query($sql_p);
                        if ($resultado->num_rows > 0) {
                            $i = 0;
                            while ($row = $resultado->fetch_assoc()) {
                                $sql_insert2 = "UPDATE produtos SET qtd = qtd - {$row["qtd"]} WHERE nome = '{$row["nome"]}' AND nomearq = '$nomearq'";
                                $con->query($sql_insert2);
                                $p_nome[$i] = $row["nome"];
                                $p_qtd[$i] = $row["qtd"];
                                $i++;
                            }
                        }
                        $str_del = "DELETE FROM qtd_temp WHERE nomearq = '$nomearq'";
                        $con->query($str_del);
                        try {
                            $mail->SMTPDebug = 0;
                            $mail->isSMTP();
                            $mail->Host = 'smtp.titan.email';
                            $mail->SMTPKeepAlive = true;
                            $mail->SMTPAuth = true;
                            $mail->Username = 'compras@gravadorpub.com.br';
                            $mail->Password = 'gravador12!';
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                            $mail->Port = 465;
                            $mail->CharSet = 'UTF-8';
                            $mail->setFrom('compras@gravadorpub.com.br', 'Gravador Pub');
                            $mail->addAddress('loja@gravadorpub.com.br');
                            $mail->isHTML(true);
                            $mail->Subject = $nome_pri[0]." - ".$nomeprod;
                            $mail->Body = 'De: ' . $nome_com . ' | Produto: ' . $nomeprod . ' | Tipo: ' . implode(' - ', $p_nome) . ' | Quantidade: ' . implode(' - ', $p_qtd);
                            $mail->AltBody = 'De: ' . $nome_com . ' | Produto: ' . $nomeprod . ' | Tipo: ' . implode(' - ', $p_nome) . ' | Quantidade: ' . implode(' - ', $p_qtd);
                            $mail->send();
                            $mail->ClearAllRecipients();
                            $mail->ClearAttachments();
                        } catch (Exception $e) {
                            echo "O e-mail não pôde ser enviado: {$mail->ErrorInfo}";
                        }
                    }
                }

                $con->close();
                break;

            case "IN_DISPUTE":
                $status1 = "EM DISPUTA";
                $sql_insert = "INSERT INTO transacao (codigo, referencia, estado, nomearq, data_transacao) VALUES ('$notificationCode', '$reference', '$status1', '$nomearq', NOW()) ON DUPLICATE KEY UPDATE codigo = VALUES(codigo), estado = VALUES(estado), data_transacao = VALUES(data_transacao)";
                $open_sans = "'Open Sans'";
                $nunito = "'Nunito'";
                $raleway = "'Raleway'";
                if ($tipo == "evento") {
                    $qtd_ing = count($nomesing_a);
                    $altbody1 = 'Olá, ' . $nome_pri[0] . '! Você acabou de adquirir ' . count($nomesing_a) . ' ingressos do Gravador Pub para o ' . $nomeprod . '! Obrigado pela preferência! O estado atual de sua transação é: ' . $status1 . '.' . ' Seus ' . count($nomesing_a) . ' ingressos serão enviados para este e-mail após a confirmação do pagamento!';
                    $altbody2 = 'Olá, ' . $nome_pri[0] . '! Você acabou de adquirir um ingresso do Gravador Pub para o ' . $nomeprod . '! Obrigado pela preferência! O estado atual de sua transação é: ' . $status1 . '.' . ' Seu ingresso será enviado para este e-mail após a confirmação do pagamento!';
                    $msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--[if !mso]><!--><meta http-equiv="X-UA-Compatible" content="IE=edge" /><!--<![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Gravador Pub</title>
        <style>


            @import url(https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900|Raleway:200,300,400,500,600,700,800,900);

            html{width:100%}
            body{-webkit-text-size-adjust:none;-ms-text-size-adjust:none;margin:0;padding:0;font-family:' . $open_sans . ',Arial,Sans-serif!important}
            table{border-spacing:0;table-layout:auto;margin:0 auto}
            img{display:block!important;overflow:hidden!important}
            a{text-decoration: none;color:unset}
            .ReadMsgBody{width:100%;background-color:#fff}
            .ExternalClass{width:100%;background-color:#fff}
            .ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:100%}
            .yshortcuts a{border-bottom:none!important}
            .full{width:100%}
            .pad{width:92%}
            @media only screen and (max-width: 650px) {
                .res-pad{width:92%;max-width:92%}
                .res-full{width:100%;max-width:100%}
                .res-left{text-align:left!important}
                .res-right{text-align:right!important}
                .res-center{text-align:center!important}
            }@media only screen and (max-width: 750px) {
                .margin-full{width:100%;max-width:100%}
                .margin-pad{width:92%;max-width:92%;max-width:600px}
            }
        </style>
    </head>
    <body><repeater><layout label="Module 1 - Header">
                <!-- ====== Module : Header ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- column x2 -->
                                            <tr >
                                                <td>
                                                    <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">GRAVADOR PUB</singleline></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- column x2 end -->
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                </table></layout><layout label="Module 2 - Intro">
                <!-- ====== Module : Intro ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="#304050" align="center" width="750" class="margin-full" style="background-size:cover; background-position:center;" border="0" cellpadding="0" cellspacing="0" background="img/module02-bg01.png">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 2px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle">STATUS DA TRANSAÇÃO:</singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="12" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">' . $status1 . '</singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="20" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- dash -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table bgcolor="white" align="center" style="border-radius: 10px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td width="60" height="3" style="font-size:0px" >&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- dash end -->
                                            <tr><td height="21" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: justify; text-indent: 5%; color: white; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                    Olá, ' . $nome_pri[0] . '! Este e-mail é referente a <b>' . $nomeprod . '</b>! Obrigado pela preferência! Seus ' . count($nomesing_a) . ' ingressos serão enviados para este e-mail após a confirmação do pagamento!
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="24" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- button -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table align="center" bgcolor="#006D89" style="border: 1.5px solid white; border-radius: 4px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td height="43" style="padding: 0 23px; text-align: center;" >
                                                                             <a href="https://gravadorpub.com.br/home.php" style="color: white; letter-spacing: 1px; font-size: 17px; font-family: ' . $nunito . ', Arial, Sans-serif; text-decoration: none; text-align: center; line-height: 24px; word-break: break-word;" ><singleline label="Button">VOLTAR AO SITE</singleline></a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- button end -->
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout><layout label="Module 3 - Trending Events summary">
                    
                <!-- ====== Module : Trending Events summary ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 0.7px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle"></singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="7" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #505050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 22px; letter-spacing: 0.7px; word-break: break-word" ><singleline label="Title"></singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="13" style="font-size:0px" >&nbsp;</td></tr>
                                            
                                            <tr><td height="25" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                       
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="15" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- link -->
                                            <tr >
                                                <td class="res-center" style="text-align: center;" >
                                                    <a href="https://example.com" style="color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.7px; text-decoration: none; word-break: break-word;" ><singleline label="Link"></singleline></a>
                                                </td>
                                            </tr>
                                            <!-- link end -->
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout></repeater>

        <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table bgcolor="#F5F5F5" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                    <tr>
                                        <td>
                                            <table align="center" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                            
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #909090; font-family: ' . $nunito . ', Arial, Sans-serif; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; font-size: 15px;" ><multiline label="Paragraph">Veja mais eventos do Gravador Pub!</multiline></td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                           
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; padding-left: 7px; font-weight: 600;" >
                                                                    <a href="https://gravadorpub.com.br/agenda/janeiro.php">Clique Aqui</a>
                                                                </td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </body>
</html>';
                    $msg2 = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--[if !mso]><!--><meta http-equiv="X-UA-Compatible" content="IE=edge" /><!--<![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Gravador Pub</title>
        <style>


            @import url(https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900|Raleway:200,300,400,500,600,700,800,900);

            html{width:100%}
            body{-webkit-text-size-adjust:none;-ms-text-size-adjust:none;margin:0;padding:0;font-family:' . $open_sans . ',Arial,Sans-serif!important}
            table{border-spacing:0;table-layout:auto;margin:0 auto}
            img{display:block!important;overflow:hidden!important}
            a{text-decoration: none;color:unset}
            .ReadMsgBody{width:100%;background-color:#fff}
            .ExternalClass{width:100%;background-color:#fff}
            .ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:100%}
            .yshortcuts a{border-bottom:none!important}
            .full{width:100%}
            .pad{width:92%}
            @media only screen and (max-width: 650px) {
                .res-pad{width:92%;max-width:92%}
                .res-full{width:100%;max-width:100%}
                .res-left{text-align:left!important}
                .res-right{text-align:right!important}
                .res-center{text-align:center!important}
            }@media only screen and (max-width: 750px) {
                .margin-full{width:100%;max-width:100%}
                .margin-pad{width:92%;max-width:92%;max-width:600px}
            }
        </style>
    </head>
    <body><repeater><layout label="Module 1 - Header">
                <!-- ====== Module : Header ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- column x2 -->
                                            <tr >
                                                <td>
                                                    <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">GRAVADOR PUB</singleline></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- column x2 end -->
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                </table></layout><layout label="Module 2 - Intro">
                <!-- ====== Module : Intro ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="#304050" align="center" width="750" class="margin-full" style="background-size:cover; background-position:center;" border="0" cellpadding="0" cellspacing="0" background="img/module02-bg01.png">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 2px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle">STATUS DA TRANSAÇÃO:</singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="12" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">' . $status1 . '</singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="20" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- dash -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table bgcolor="white" align="center" style="border-radius: 10px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td width="60" height="3" style="font-size:0px" >&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- dash end -->
                                            <tr><td height="21" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: justify; text-indent: 5%; color: white; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                    Olá, ' . $nome_pri[0] . '! Este e-mail é referente a <b>' . $nomeprod . '</b>! Obrigado pela preferência! Seu ingresso será enviado para este e-mail após a confirmação do pagamento!
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="24" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- button -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table align="center" bgcolor="#006D89" style="border: 1.5px solid white; border-radius: 4px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td height="43" style="padding: 0 23px; text-align: center;" >
                                                                             <a href="https://gravadorpub.com.br/home.php" style="color: white; letter-spacing: 1px; font-size: 17px; font-family: ' . $nunito . ', Arial, Sans-serif; text-decoration: none; text-align: center; line-height: 24px; word-break: break-word;" ><singleline label="Button">VOLTAR AO SITE</singleline></a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- button end -->
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout><layout label="Module 3 - Trending Events summary">
                    
                <!-- ====== Module : Trending Events summary ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 0.7px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle"></singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="7" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #505050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 22px; letter-spacing: 0.7px; word-break: break-word" ><singleline label="Title"></singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="13" style="font-size:0px" >&nbsp;</td></tr>
                                            
                                            <tr><td height="25" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                       
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="15" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- link -->
                                            <tr >
                                                <td class="res-center" style="text-align: center;" >
                                                    <a href="https://example.com" style="color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.7px; text-decoration: none; word-break: break-word;" ><singleline label="Link"></singleline></a>
                                                </td>
                                            </tr>
                                            <!-- link end -->
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout></repeater>

        <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table bgcolor="#F5F5F5" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                    <tr>
                                        <td>
                                            <table align="center" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                            
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #909090; font-family: ' . $nunito . ', Arial, Sans-serif; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; font-size: 15px;" ><multiline label="Paragraph">Veja mais eventos do Gravador Pub!</multiline></td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                           
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; padding-left: 7px; font-weight: 600;" >
                                                                    <a href="https://gravadorpub.com.br/agenda/janeiro.php">Clique Aqui</a>
                                                                </td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </body>
</html>';
                } elseif ($tipo == "produto") {
                    $qtd_ing = $qtd;
                    $altbody2 = 'Olá, ' . $nome_pri[0] . '! Este e-mail é referente à compra do produto ' . $nomeprod . '! Obrigado pela preferência! O estado atual de sua transação é: ' . $status1 . '.';
                    $altbody1 = 'Olá, ' . $nome_pri[0] . '! Este e-mail é referente à compra dos ' . $qtd . ' produtos ' . $nomeprod . '! Obrigado pela preferência! O estado atual de sua transação é: ' . $status1 . '.';
                    $msg2 = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--[if !mso]><!--><meta http-equiv="X-UA-Compatible" content="IE=edge" /><!--<![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Gravador Pub</title>
        <style>


            @import url(https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900|Raleway:200,300,400,500,600,700,800,900);

            html{width:100%}
            body{-webkit-text-size-adjust:none;-ms-text-size-adjust:none;margin:0;padding:0;font-family:' . $open_sans . ',Arial,Sans-serif!important}
            table{border-spacing:0;table-layout:auto;margin:0 auto}
            img{display:block!important;overflow:hidden!important}
            a{text-decoration: none;color:unset}
            .ReadMsgBody{width:100%;background-color:#fff}
            .ExternalClass{width:100%;background-color:#fff}
            .ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:100%}
            .yshortcuts a{border-bottom:none!important}
            .full{width:100%}
            .pad{width:92%}
            @media only screen and (max-width: 650px) {
                .res-pad{width:92%;max-width:92%}
                .res-full{width:100%;max-width:100%}
                .res-left{text-align:left!important}
                .res-right{text-align:right!important}
                .res-center{text-align:center!important}
            }@media only screen and (max-width: 750px) {
                .margin-full{width:100%;max-width:100%}
                .margin-pad{width:92%;max-width:92%;max-width:600px}
            }
        </style>
    </head>
    <body><repeater><layout label="Module 1 - Header">
                <!-- ====== Module : Header ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- column x2 -->
                                            <tr >
                                                <td>
                                                    <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">GRAVADOR PUB</singleline></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- column x2 end -->
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                </table></layout><layout label="Module 2 - Intro">
                <!-- ====== Module : Intro ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="#304050" align="center" width="750" class="margin-full" style="background-size:cover; background-position:center;" border="0" cellpadding="0" cellspacing="0" background="img/module02-bg01.png">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 2px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle">STATUS DA TRANSAÇÃO:</singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="12" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">' . $status1 . '</singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="20" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- dash -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table bgcolor="white" align="center" style="border-radius: 10px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td width="60" height="3" style="font-size:0px" >&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- dash end -->
                                            <tr><td height="21" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: justify; text-indent: 5%; color: white; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                    Olá, ' . $nome_pri[0] . '! Este e-mail é referente à compra do produto <b>' . $nomeprod . '</b>! Obrigado pela preferência!
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="24" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- button -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table align="center" bgcolor="#006D89" style="border: 1.5px solid white; border-radius: 4px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td height="43" style="padding: 0 23px; text-align: center;" >
                                                                             <a href="https://gravadorpub.com.br/home.php" style="color: white; letter-spacing: 1px; font-size: 17px; font-family: ' . $nunito . ', Arial, Sans-serif; text-decoration: none; text-align: center; line-height: 24px; word-break: break-word;" ><singleline label="Button">VOLTAR AO SITE</singleline></a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- button end -->
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout><layout label="Module 3 - Trending Events summary">
                    
                <!-- ====== Module : Trending Events summary ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 0.7px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle"></singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="7" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #505050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 22px; letter-spacing: 0.7px; word-break: break-word" ><singleline label="Title"></singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="13" style="font-size:0px" >&nbsp;</td></tr>
                                            
                                            <tr><td height="25" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                       
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="15" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- link -->
                                            <tr >
                                                <td class="res-center" style="text-align: center;" >
                                                    <a href="https://example.com" style="color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.7px; text-decoration: none; word-break: break-word;" ><singleline label="Link"></singleline></a>
                                                </td>
                                            </tr>
                                            <!-- link end -->
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout></repeater>

        <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table bgcolor="#F5F5F5" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                    <tr>
                                        <td>
                                            <table align="center" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                            
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #909090; font-family: ' . $nunito . ', Arial, Sans-serif; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; font-size: 15px;" ><multiline label="Paragraph">Veja mais produtos do Gravador Pub!</multiline></td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                           
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; padding-left: 7px; font-weight: 600;" >
                                                                    <a href="https://gravadorpub.com.br/loja/produtos.php">Clique Aqui</a>
                                                                </td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </body>
</html>';

                    $msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--[if !mso]><!--><meta http-equiv="X-UA-Compatible" content="IE=edge" /><!--<![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Gravador Pub</title>
        <style>


            @import url(https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900|Raleway:200,300,400,500,600,700,800,900);

            html{width:100%}
            body{-webkit-text-size-adjust:none;-ms-text-size-adjust:none;margin:0;padding:0;font-family:' . $open_sans . ',Arial,Sans-serif!important}
            table{border-spacing:0;table-layout:auto;margin:0 auto}
            img{display:block!important;overflow:hidden!important}
            a{text-decoration: none;color:unset}
            .ReadMsgBody{width:100%;background-color:#fff}
            .ExternalClass{width:100%;background-color:#fff}
            .ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:100%}
            .yshortcuts a{border-bottom:none!important}
            .full{width:100%}
            .pad{width:92%}
            @media only screen and (max-width: 650px) {
                .res-pad{width:92%;max-width:92%}
                .res-full{width:100%;max-width:100%}
                .res-left{text-align:left!important}
                .res-right{text-align:right!important}
                .res-center{text-align:center!important}
            }@media only screen and (max-width: 750px) {
                .margin-full{width:100%;max-width:100%}
                .margin-pad{width:92%;max-width:92%;max-width:600px}
            }
        </style>
    </head>
    <body><repeater><layout label="Module 1 - Header">
                <!-- ====== Module : Header ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- column x2 -->
                                            <tr >
                                                <td>
                                                    <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">GRAVADOR PUB</singleline></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- column x2 end -->
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                </table></layout><layout label="Module 2 - Intro">
                <!-- ====== Module : Intro ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="#304050" align="center" width="750" class="margin-full" style="background-size:cover; background-position:center;" border="0" cellpadding="0" cellspacing="0" background="img/module02-bg01.png">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 2px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle">STATUS DA TRANSAÇÃO:</singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="12" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">' . $status1 . '</singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="20" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- dash -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table bgcolor="white" align="center" style="border-radius: 10px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td width="60" height="3" style="font-size:0px" >&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- dash end -->
                                            <tr><td height="21" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: justify; text-indent: 5%; color: white; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                    Olá, ' . $nome_pri[0] . '! Este e-mail é referente à compra dos ' . $qtd . ' produtos <b>' . $nomeprod . '</b>! Obrigado pela preferência!
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="24" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- button -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table align="center" bgcolor="#006D89" style="border: 1.5px solid white; border-radius: 4px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td height="43" style="padding: 0 23px; text-align: center;" >
                                                                             <a href="https://gravadorpub.com.br/home.php" style="color: white; letter-spacing: 1px; font-size: 17px; font-family: ' . $nunito . ', Arial, Sans-serif; text-decoration: none; text-align: center; line-height: 24px; word-break: break-word;" ><singleline label="Button">VOLTAR AO SITE</singleline></a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- button end -->
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout><layout label="Module 3 - Trending Events summary">
                    
                <!-- ====== Module : Trending Events summary ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 0.7px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle"></singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="7" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #505050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 22px; letter-spacing: 0.7px; word-break: break-word" ><singleline label="Title"></singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="13" style="font-size:0px" >&nbsp;</td></tr>
                                            
                                            <tr><td height="25" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                       
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="15" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- link -->
                                            <tr >
                                                <td class="res-center" style="text-align: center;" >
                                                    <a href="https://example.com" style="color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.7px; text-decoration: none; word-break: break-word;" ><singleline label="Link"></singleline></a>
                                                </td>
                                            </tr>
                                            <!-- link end -->
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout></repeater>

        <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table bgcolor="#F5F5F5" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                    <tr>
                                        <td>
                                            <table align="center" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                            
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #909090; font-family: ' . $nunito . ', Arial, Sans-serif; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; font-size: 15px;" ><multiline label="Paragraph">Veja mais produtos do Gravador Pub!</multiline></td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                           
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; padding-left: 7px; font-weight: 600;" >
                                                                    <a href="https://gravadorpub.com.br/loja/produtos.php">Clique Aqui</a>
                                                                </td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </body>
</html>';
                }
                if ($con->query($sql_insert) === true) {
                    try {
                        $mail->SMTPDebug = 0;
                        $mail->isSMTP();
                        $mail->Host = 'smtp.titan.email';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'compras@gravadorpub.com.br';
                        $mail->Password = 'gravador12!';
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                        $mail->Port = 465;
                        $mail->CharSet = 'UTF-8';
                        $mail->setFrom('compras@gravadorpub.com.br', 'Gravador Pub');
                        $mail->addAddress($email);
                        $mail->isHTML(true);
                        $mail->Subject = 'Atualização na Transação - Gravador Pub - ' . $status1 . '';
                        if ($qtd_ing > 1) {
                            $mail->Body = $msg;
                            $mail->AltBody = $altbody1;
                        } else {
                            $mail->Body = $msg2;
                            $mail->AltBody = $altbody2;
                        }

                        $mail->send();
                        $mail->ClearAllRecipients();
                    } catch (Exception $e) {
                        echo "O e-mail não pôde ser enviado: {$mail->ErrorInfo}";
                    }
                }

                $con->close();
                break;

            case "CANCELLED":
                $status1 = "CANCELADA";
                $sql_insert = "INSERT INTO transacao (codigo, referencia, estado, nomearq, data_transacao) VALUES ('$notificationCode', '$reference', '$status1', '$nomearq', NOW()) ON DUPLICATE KEY UPDATE codigo = VALUES(codigo), estado = VALUES(estado), data_transacao = VALUES(data_transacao)";
                $open_sans = "'Open Sans'";
                $nunito = "'Nunito'";
                $raleway = "'Raleway'";
                if ($tipo == "evento") {
                    $altbody1 = 'Olá, ' . $nome_pri[0] . '! Este e-mail é referente a ' . $nomeprod . '. Sua compra foi cancelada com sucesso. Aguardamos ansiosamente seu retorno para mais eventos!';
                    $msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--[if !mso]><!--><meta http-equiv="X-UA-Compatible" content="IE=edge" /><!--<![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Gravador Pub</title>
        <style>


            @import url(https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900|Raleway:200,300,400,500,600,700,800,900);

            html{width:100%}
            body{-webkit-text-size-adjust:none;-ms-text-size-adjust:none;margin:0;padding:0;font-family:' . $open_sans . ',Arial,Sans-serif!important}
            table{border-spacing:0;table-layout:auto;margin:0 auto}
            img{display:block!important;overflow:hidden!important}
            a{text-decoration: none;color:unset}
            .ReadMsgBody{width:100%;background-color:#fff}
            .ExternalClass{width:100%;background-color:#fff}
            .ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:100%}
            .yshortcuts a{border-bottom:none!important}
            .full{width:100%}
            .pad{width:92%}
            @media only screen and (max-width: 650px) {
                .res-pad{width:92%;max-width:92%}
                .res-full{width:100%;max-width:100%}
                .res-left{text-align:left!important}
                .res-right{text-align:right!important}
                .res-center{text-align:center!important}
            }@media only screen and (max-width: 750px) {
                .margin-full{width:100%;max-width:100%}
                .margin-pad{width:92%;max-width:92%;max-width:600px}
            }
        </style>
    </head>
    <body><repeater><layout label="Module 1 - Header">
                <!-- ====== Module : Header ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- column x2 -->
                                            <tr >
                                                <td>
                                                    <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">GRAVADOR PUB</singleline></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- column x2 end -->
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                </table></layout><layout label="Module 2 - Intro">
                <!-- ====== Module : Intro ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="#304050" align="center" width="750" class="margin-full" style="background-size:cover; background-position:center;" border="0" cellpadding="0" cellspacing="0" background="img/module02-bg01.png">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 2px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle">STATUS DA TRANSAÇÃO:</singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="12" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">' . $status1 . '</singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="20" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- dash -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table bgcolor="white" align="center" style="border-radius: 10px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td width="60" height="3" style="font-size:0px" >&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- dash end -->
                                            <tr><td height="21" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: justify; text-indent: 5%; color: white; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                    Olá, ' . $nome_pri[0] . '! Este e-mail é referente a <b>' . $nomeprod . '</b>. Sua compra foi cancelada com sucesso, aguardamos ansiosamente seu retorno para mais eventos!
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="24" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- button -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table align="center" bgcolor="#006D89" style="border: 1.5px solid white; border-radius: 4px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td height="43" style="padding: 0 23px; text-align: center;" >
                                                                             <a href="https://gravadorpub.com.br/home.php" style="color: white; letter-spacing: 1px; font-size: 17px; font-family: ' . $nunito . ', Arial, Sans-serif; text-decoration: none; text-align: center; line-height: 24px; word-break: break-word;" ><singleline label="Button">VOLTAR AO SITE</singleline></a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- button end -->
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout><layout label="Module 3 - Trending Events summary">
                    
                <!-- ====== Module : Trending Events summary ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 0.7px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle"></singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="7" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #505050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 22px; letter-spacing: 0.7px; word-break: break-word" ><singleline label="Title"></singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="13" style="font-size:0px" >&nbsp;</td></tr>
                                            
                                            <tr><td height="25" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                       
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="15" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- link -->
                                            <tr >
                                                <td class="res-center" style="text-align: center;" >
                                                    <a href="https://example.com" style="color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.7px; text-decoration: none; word-break: break-word;" ><singleline label="Link"></singleline></a>
                                                </td>
                                            </tr>
                                            <!-- link end -->
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout></repeater>

        <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table bgcolor="#F5F5F5" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                    <tr>
                                        <td>
                                            <table align="center" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                            
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #909090; font-family: ' . $nunito . ', Arial, Sans-serif; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; font-size: 15px;" ><multiline label="Paragraph">Veja mais eventos do Gravador Pub!</multiline></td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                           
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; padding-left: 7px; font-weight: 600;" >
                                                                    <a href="https://gravadorpub.com.br/agenda/janeiro.php">Clique Aqui</a>
                                                                </td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </body>
</html>';
                } elseif ($tipo == "produto") {
                    $altbody1 = 'Olá, ' . $nome_pri[0] . '! Este e-mail é referente à compra do produto ' . $nomeprod . '. Sua compra foi cancelada com sucesso.';
                    $msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--[if !mso]><!--><meta http-equiv="X-UA-Compatible" content="IE=edge" /><!--<![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Gravador Pub</title>
        <style>


            @import url(https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900|Raleway:200,300,400,500,600,700,800,900);

            html{width:100%}
            body{-webkit-text-size-adjust:none;-ms-text-size-adjust:none;margin:0;padding:0;font-family:' . $open_sans . ',Arial,Sans-serif!important}
            table{border-spacing:0;table-layout:auto;margin:0 auto}
            img{display:block!important;overflow:hidden!important}
            a{text-decoration: none;color:unset}
            .ReadMsgBody{width:100%;background-color:#fff}
            .ExternalClass{width:100%;background-color:#fff}
            .ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:100%}
            .yshortcuts a{border-bottom:none!important}
            .full{width:100%}
            .pad{width:92%}
            @media only screen and (max-width: 650px) {
                .res-pad{width:92%;max-width:92%}
                .res-full{width:100%;max-width:100%}
                .res-left{text-align:left!important}
                .res-right{text-align:right!important}
                .res-center{text-align:center!important}
            }@media only screen and (max-width: 750px) {
                .margin-full{width:100%;max-width:100%}
                .margin-pad{width:92%;max-width:92%;max-width:600px}
            }
        </style>
    </head>
    <body><repeater><layout label="Module 1 - Header">
                <!-- ====== Module : Header ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- column x2 -->
                                            <tr >
                                                <td>
                                                    <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">GRAVADOR PUB</singleline></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- column x2 end -->
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                </table></layout><layout label="Module 2 - Intro">
                <!-- ====== Module : Intro ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="#304050" align="center" width="750" class="margin-full" style="background-size:cover; background-position:center;" border="0" cellpadding="0" cellspacing="0" background="img/module02-bg01.png">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 2px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle">STATUS DA TRANSAÇÃO:</singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="12" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">' . $status1 . '</singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="20" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- dash -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table bgcolor="white" align="center" style="border-radius: 10px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td width="60" height="3" style="font-size:0px" >&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- dash end -->
                                            <tr><td height="21" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: justify; text-indent: 5%; color: white; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                    Olá, ' . $nome_pri[0] . '! Este e-mail é referente à compra do produto ' . $nomeprod . '. Sua compra foi cancelada com sucesso.
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="24" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- button -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table align="center" bgcolor="#006D89" style="border: 1.5px solid white; border-radius: 4px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td height="43" style="padding: 0 23px; text-align: center;" >
                                                                             <a href="https://gravadorpub.com.br/home.php" style="color: white; letter-spacing: 1px; font-size: 17px; font-family: ' . $nunito . ', Arial, Sans-serif; text-decoration: none; text-align: center; line-height: 24px; word-break: break-word;" ><singleline label="Button">VOLTAR AO SITE</singleline></a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- button end -->
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout><layout label="Module 3 - Trending Events summary">
                    
                <!-- ====== Module : Trending Events summary ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 0.7px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle"></singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="7" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #505050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 22px; letter-spacing: 0.7px; word-break: break-word" ><singleline label="Title"></singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="13" style="font-size:0px" >&nbsp;</td></tr>
                                            
                                            <tr><td height="25" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                       
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="15" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- link -->
                                            <tr >
                                                <td class="res-center" style="text-align: center;" >
                                                    <a href="https://example.com" style="color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.7px; text-decoration: none; word-break: break-word;" ><singleline label="Link"></singleline></a>
                                                </td>
                                            </tr>
                                            <!-- link end -->
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout></repeater>

        <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table bgcolor="#F5F5F5" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                    <tr>
                                        <td>
                                            <table align="center" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                            
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #909090; font-family: ' . $nunito . ', Arial, Sans-serif; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; font-size: 15px;" ><multiline label="Paragraph">Veja mais produtos do Gravador Pub!</multiline></td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                           
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; padding-left: 7px; font-weight: 600;" >
                                                                    <a href="https://gravadorpub.com.br/loja/produtos.php">Clique Aqui</a>
                                                                </td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </body>
</html>';
                }
                if ($con->query($sql_insert) === true) {
                    try {
                        $mail->SMTPDebug = 0;
                        $mail->isSMTP();
                        $mail->Host = 'smtp.titan.email';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'compras@gravadorpub.com.br';
                        $mail->Password = 'gravador12!';
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                        $mail->Port = 465;
                        $mail->CharSet = 'UTF-8';
                        $mail->setFrom('compras@gravadorpub.com.br', 'Gravador Pub');
                        $mail->addAddress($email);
                        $mail->isHTML(true);
                        $mail->Subject = 'Atualização na Transação - Gravador Pub - ' . $status1 . '';
                        $mail->Body = $msg;
                        $mail->AltBody = $altbody1;

                        $mail->send();
                        $mail->ClearAllRecipients();
                    } catch (Exception $e) {
                        echo "O e-mail não pôde ser enviado: {$mail->ErrorInfo}";
                    }
                }

                $con->close();
                break;

            case "REFUNDED":
                $status1 = "REEMBOLSADA";
                $sql_insert = "INSERT INTO transacao (codigo, referencia, estado, nomearq, data_transacao) VALUES ('$notificationCode', '$reference', '$status1', '$nomearq', NOW()) ON DUPLICATE KEY UPDATE codigo = VALUES(codigo), estado = VALUES(estado), data_transacao = VALUES(data_transacao)";
                $open_sans = "'Open Sans'";
                $nunito = "'Nunito'";
                $raleway = "'Raleway'";
                if ($tipo == "evento") {
                    $altbody1 = 'Olá, ' . $nome_pri[0] . '! Este e-mail é referente a ' . $nomeprod . '. Sua compra foi reembolsada com sucesso. Aguardamos ansiosamente seu retorno para mais eventos!';
                    $msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--[if !mso]><!--><meta http-equiv="X-UA-Compatible" content="IE=edge" /><!--<![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Gravador Pub</title>
        <style>


            @import url(https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900|Raleway:200,300,400,500,600,700,800,900);

            html{width:100%}
            body{-webkit-text-size-adjust:none;-ms-text-size-adjust:none;margin:0;padding:0;font-family:' . $open_sans . ',Arial,Sans-serif!important}
            table{border-spacing:0;table-layout:auto;margin:0 auto}
            img{display:block!important;overflow:hidden!important}
            a{text-decoration: none;color:unset}
            .ReadMsgBody{width:100%;background-color:#fff}
            .ExternalClass{width:100%;background-color:#fff}
            .ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:100%}
            .yshortcuts a{border-bottom:none!important}
            .full{width:100%}
            .pad{width:92%}
            @media only screen and (max-width: 650px) {
                .res-pad{width:92%;max-width:92%}
                .res-full{width:100%;max-width:100%}
                .res-left{text-align:left!important}
                .res-right{text-align:right!important}
                .res-center{text-align:center!important}
            }@media only screen and (max-width: 750px) {
                .margin-full{width:100%;max-width:100%}
                .margin-pad{width:92%;max-width:92%;max-width:600px}
            }
        </style>
    </head>
    <body><repeater><layout label="Module 1 - Header">
                <!-- ====== Module : Header ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- column x2 -->
                                            <tr >
                                                <td>
                                                    <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">GRAVADOR PUB</singleline></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- column x2 end -->
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                </table></layout><layout label="Module 2 - Intro">
                <!-- ====== Module : Intro ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="#304050" align="center" width="750" class="margin-full" style="background-size:cover; background-position:center;" border="0" cellpadding="0" cellspacing="0" background="img/module02-bg01.png">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 2px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle">STATUS DA TRANSAÇÃO:</singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="12" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">' . $status1 . '</singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="20" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- dash -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table bgcolor="white" align="center" style="border-radius: 10px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td width="60" height="3" style="font-size:0px" >&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- dash end -->
                                            <tr><td height="21" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: justify; text-indent: 5%; color: white; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                    Olá, ' . $nome_pri[0] . '! Este e-mail é referente a <b>' . $nomeprod . '</b>. Sua compra foi reembolsada com sucesso, aguardamos ansiosamente seu retorno para mais eventos!
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="24" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- button -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table align="center" bgcolor="#006D89" style="border: 1.5px solid white; border-radius: 4px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td height="43" style="padding: 0 23px; text-align: center;" >
                                                                             <a href="https://gravadorpub.com.br/home.php" style="color: white; letter-spacing: 1px; font-size: 17px; font-family: ' . $nunito . ', Arial, Sans-serif; text-decoration: none; text-align: center; line-height: 24px; word-break: break-word;" ><singleline label="Button">VOLTAR AO SITE</singleline></a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- button end -->
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout><layout label="Module 3 - Trending Events summary">
                    
                <!-- ====== Module : Trending Events summary ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 0.7px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle"></singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="7" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #505050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 22px; letter-spacing: 0.7px; word-break: break-word" ><singleline label="Title"></singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="13" style="font-size:0px" >&nbsp;</td></tr>
                                            
                                            <tr><td height="25" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                       
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="15" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- link -->
                                            <tr >
                                                <td class="res-center" style="text-align: center;" >
                                                    <a href="https://example.com" style="color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.7px; text-decoration: none; word-break: break-word;" ><singleline label="Link"></singleline></a>
                                                </td>
                                            </tr>
                                            <!-- link end -->
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout></repeater>

        <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table bgcolor="#F5F5F5" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                    <tr>
                                        <td>
                                            <table align="center" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                            
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #909090; font-family: ' . $nunito . ', Arial, Sans-serif; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; font-size: 15px;" ><multiline label="Paragraph">Veja mais eventos do Gravador Pub!</multiline></td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                           
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; padding-left: 7px; font-weight: 600;" >
                                                                    <a href="https://gravadorpub.com.br/agenda/janeiro.php">Clique Aqui</a>
                                                                </td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </body>
</html>';
                } elseif ($tipo == "produto") {
                    $altbody1 = 'Olá, ' . $nome_pri[0] . '! Este e-mail é referente à compra do produto ' . $nomeprod . '. Sua compra foi reembolsada com sucesso.';
                    $msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--[if !mso]><!--><meta http-equiv="X-UA-Compatible" content="IE=edge" /><!--<![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Gravador Pub</title>
        <style>


            @import url(https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900|Raleway:200,300,400,500,600,700,800,900);

            html{width:100%}
            body{-webkit-text-size-adjust:none;-ms-text-size-adjust:none;margin:0;padding:0;font-family:' . $open_sans . ',Arial,Sans-serif!important}
            table{border-spacing:0;table-layout:auto;margin:0 auto}
            img{display:block!important;overflow:hidden!important}
            a{text-decoration: none;color:unset}
            .ReadMsgBody{width:100%;background-color:#fff}
            .ExternalClass{width:100%;background-color:#fff}
            .ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:100%}
            .yshortcuts a{border-bottom:none!important}
            .full{width:100%}
            .pad{width:92%}
            @media only screen and (max-width: 650px) {
                .res-pad{width:92%;max-width:92%}
                .res-full{width:100%;max-width:100%}
                .res-left{text-align:left!important}
                .res-right{text-align:right!important}
                .res-center{text-align:center!important}
            }@media only screen and (max-width: 750px) {
                .margin-full{width:100%;max-width:100%}
                .margin-pad{width:92%;max-width:92%;max-width:600px}
            }
        </style>
    </head>
    <body><repeater><layout label="Module 1 - Header">
                <!-- ====== Module : Header ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- column x2 -->
                                            <tr >
                                                <td>
                                                    <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">GRAVADOR PUB</singleline></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- column x2 end -->
                                            <tr><td height="30" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                </table></layout><layout label="Module 2 - Intro">
                <!-- ====== Module : Intro ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="#304050" align="center" width="750" class="margin-full" style="background-size:cover; background-position:center;" border="0" cellpadding="0" cellspacing="0" background="img/module02-bg01.png">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 2px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle">STATUS DA TRANSAÇÃO:</singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="12" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">' . $status1 . '</singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="20" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- dash -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table bgcolor="white" align="center" style="border-radius: 10px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td width="60" height="3" style="font-size:0px" >&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- dash end -->
                                            <tr><td height="21" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: justify; text-indent: 5%; color: white; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                    Olá, ' . $nome_pri[0] . '! Este e-mail é referente à compra do produto ' . $nomeprod . '. Sua compra foi reembolsada com sucesso.
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="24" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- button -->
                                            <tr >
                                                <td>
                                                    <table align="center" class="res-full" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <table align="center" bgcolor="#006D89" style="border: 1.5px solid white; border-radius: 4px;" border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td height="43" style="padding: 0 23px; text-align: center;" >
                                                                             <a href="https://gravadorpub.com.br/home.php" style="color: white; letter-spacing: 1px; font-size: 17px; font-family: ' . $nunito . ', Arial, Sans-serif; text-decoration: none; text-align: center; line-height: 24px; word-break: break-word;" ><singleline label="Button">VOLTAR AO SITE</singleline></a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- button end -->
                                            <tr><td height="80" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout><layout label="Module 3 - Trending Events summary">
                    
                <!-- ====== Module : Trending Events summary ====== -->
                <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table bgcolor="white" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- subtitle -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 0.7px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle"></singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="7" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #505050; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 22px; letter-spacing: 0.7px; word-break: break-word" ><singleline label="Title"></singleline></td>
                                            </tr>
                                            <!-- title end -->
                                            <tr><td height="13" style="font-size:0px" >&nbsp;</td></tr>
                                            
                                            <tr><td height="25" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- paragraph -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word" ><multiline label="Paragraph">
                                                       
                                                    </multiline></td>
                                            </tr>
                                            <!-- paragraph end -->
                                            <tr><td height="15" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- link -->
                                            <tr >
                                                <td class="res-center" style="text-align: center;" >
                                                    <a href="https://example.com" style="color: #707070; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.7px; text-decoration: none; word-break: break-word;" ><singleline label="Link"></singleline></a>
                                                </td>
                                            </tr>
                                            <!-- link end -->
                                            <tr><td height="70" style="font-size:0px" >&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table></layout></repeater>

        <table bgcolor="#F5F5F5" align="center" class="full" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table bgcolor="#F5F5F5" width="750" align="center" class="margin-full" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <table width="600" align="center" class="margin-pad" border="0" cellpadding="0" cellspacing="0">
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                    <tr>
                                        <td>
                                            <table align="center" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                            
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #909090; font-family: ' . $nunito . ', Arial, Sans-serif; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; font-size: 15px;" ><multiline label="Paragraph">Veja mais produtos do Gravador Pub!</multiline></td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <table class="full" align="center" border="0" cellpadding="0" cellspacing="0">
                                                           
                                                            <tr >
                                                                <td class="res-center" style="text-align: center; color: #304050; font-family: ' . $nunito . ', Arial, Sans-serif; font-size: 17px; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; padding-left: 7px; font-weight: 600;" >
                                                                    <a href="https://gravadorpub.com.br/loja/produtos.php">Clique Aqui</a>
                                                                </td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr><td height="50" style="font-size:0px" >&nbsp;</td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </body>
</html>';
                }
                if ($con->query($sql_insert) === true) {
                    try {
                        $mail->SMTPDebug = 0;
                        $mail->isSMTP();
                        $mail->Host = 'smtp.titan.email';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'compras@gravadorpub.com.br';
                        $mail->Password = 'gravador12!';
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                        $mail->Port = 465;
                        $mail->CharSet = 'UTF-8';
                        $mail->setFrom('compras@gravadorpub.com.br', 'Gravador Pub');
                        $mail->addAddress($email);
                        $mail->isHTML(true);
                        $mail->Subject = 'Atualização na Transação - Gravador Pub - ' . $status1 . '';
                        $mail->Body = $msg;
                        $mail->AltBody = $altbody1;

                        $mail->send();
                        $mail->ClearAllRecipients();
                    } catch (Exception $e) {
                        echo "O e-mail não pôde ser enviado: {$mail->ErrorInfo}";
                    }
                }

                $con->close();
                break;
        }
    } catch (PagSeguroServiceException $e) {
        die($e->getMessage());
    }
}