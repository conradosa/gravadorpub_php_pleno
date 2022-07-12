<?php
session_start();

include('conexao.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require('lib/vendor/autoload.php');

$mail = new PHPMailer(true);

$email = mysqli_real_escape_string($con, trim($_POST['email']));
$novasenha = substr(md5(time()), 0, 6);
$novasenha_cript = hash('sha256', $novasenha);

$sql = "select count(*) as total from usuario where email = '$email'";
$r = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($r);
if ($row['total'] == 0) {
    $_SESSION['email_nao_existe'] = true;
    header('Location: senha.php');
    exit();
}

$sql_insert = "UPDATE usuario SET senha = '$novasenha_cript' WHERE email = '$email'";
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
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 14px; letter-spacing: 2px; word-break: break-word; font-weight: 600;" ><singleline label="Subtitle">E-MAIL REFERENTE À:</singleline></td>
                                            </tr>
                                            <!-- subtitle end -->
                                            <tr><td height="12" style="font-size:0px" >&nbsp;</td></tr>
                                            <!-- title -->
                                            <tr >
                                                <td class="res-center" style="text-align: center; color: white; font-family: ' . $raleway . ', Arial, Sans-serif; font-size: 35px; letter-spacing: 0.7px; word-break: break-word; font-weight: 300;" ><singleline label="Title">RECUPERAÇÃO DE SENHA</singleline></td>
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
                                                    Olá! Esta é sua nova senha provisória: <b>'.$novasenha.'</b> para altera-la acesse a página <b>Minha Conta</b> no site.
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
                                                                <td class="res-center" style="text-align: center; color: #909090; font-family: ' . $nunito . ', Arial, Sans-serif; letter-spacing: 0.4px; line-height: 23px; word-break: break-word; font-size: 15px;" ><multiline label="Paragraph">Saiba mais sobre os eventos do Gravador Pub!</multiline></td>
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

if ($con->query($sql_insert) === true) {
    try {
        $_SESSION['email_update_senha'] = true;
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.titan.email';
        $mail->SMTPAuth = true;
        $mail->Username = 'usuarios@gravadorpub.com.br';
        $mail->Password = 'gravador12!';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        $mail->CharSet = 'UTF-8';
        $mail->setFrom('usuarios@gravadorpub.com.br', 'Gravador Pub');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Recuperação de Senha - Gravador Pub';
        $mail->Body = $msg;
        $mail->AltBody = 'Olá! Esta é sua nova senha provisória: '.$novasenha.' para altera-la acesse a página Minha Conta no site.';

        $mail->send();
        $mail->ClearAllRecipients();
    } catch (Exception $e) {
        echo "O e-mail não pôde ser enviado: {$mail->ErrorInfo}";
        $_SESSION['erro_enviar_email'] = true;
    }
}

$con->close();

echo "<script>window.location.assign('senha.php');</script>";
