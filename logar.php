<?php
include('verifica_se_logado.php');
include('conexao.php');

// LOGIN FACE
/*
include('lib/Facebook/autoload.php');

$fb = new Facebook\Facebook([
  'app_id' => '{1015307052458565}',
  'app_secret' => '{37e9527ad2b18f19224416eb0cf89b32}',
  'default_graph_version' => 'v2.10',
]);

$helper = $fb->getRedirectLoginHelper();

$_SESSION['FBRLH_state']=$_GET['state']; //definindo o valor de state na session
$_SESSION['fb_access_token'] = (string) $accessToken; //definindo o access token na session

try {
    $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    echo 'Deu erro no Graph: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    echo 'Deu erro no SDK: ' . $e->getMessage();
    exit;
}
if (!isset($accessToken)) {
*/

    if (empty($_POST['email']) || empty($_POST['senha'])) {
        header('Location: login.php');
        exit();
    }
    
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $senha = mysqli_real_escape_string($con, $_POST['senha']);
    $senha1 = hash('sha256', $senha);
    
    $query = "select id, email from usuario where email = '{$email}' and senha = '{$senha1}'";
    
    $result = mysqli_query($con, $query);
    
    $row = mysqli_num_rows($result);
    
    $sql_nome = "SELECT nome FROM usuario where email = '{$email}' and senha = '{$senha1}'";
    
    $r1 = mysqli_query($con, $sql_nome);
    
    $nome = mysqli_fetch_row($r1);
    
    $nome1 = explode(' ',trim($nome[0]));
    
    $sql_cel = "SELECT celular FROM usuario where email = '{$email}' and senha = '{$senha1}'";
    
    $r2 = mysqli_query($con, $sql_cel);
    
    $cel = mysqli_fetch_row($r2);
    
    $sql_val = "SELECT validado FROM usuario where email = '{$email}' and senha = '{$senha1}'";
    
    $r3 = mysqli_query($con, $sql_val);
    
    $val = mysqli_fetch_row($r3);
    
    $sql_tok = "SELECT token FROM usuario where email = '{$email}' and senha = '{$senha1}'";
    
    $r4 = mysqli_query($con, $sql_tok);
    
    $tok = mysqli_fetch_row($r4);
    
    if ($row == 1) {
        $_SESSION['email'] = (string)$email;
        $_SESSION['cel'] = $cel[0];
        $_SESSION['nome'] = $nome1[0];
        $_SESSION['nome_completo'] = $nome[0];
        $_SESSION['validado'] = $val[0];
        $_SESSION['token'] = $tok[0];
        if(!isset($_SESSION['pg_atual'])){$_SESSION['pg_atual'] = 'home.php';}
        header('Location: '. $_SESSION['pg_atual']);
        exit();
        } else {
        $_SESSION['erro_login'] = true;
        header('Location: login.php');
        exit();
    }
    /*
}

echo '<h3>Access Token</h3>';
var_dump($accessToken->getValue());

try {
    $response = $fb->get('/me', $accessToken->getValue());
} catch(\Facebook\Exceptions\FacebookResponseException $e) {
    echo 'Deu erro no Graph: ' . $e->getMessage();
    exit;
} catch(\Facebook\Exceptions\FacebookSDKException $e) {
    echo 'Deu erro no SDK: ' . $e->getMessage();
    exit;
}

$me = $response->getGraphUser();

$cel = 999999999;
$email = $me->getEmail();
$nome = $me->getName();
$sql1 = "select count(*) as total from usuario where email = '$email'";
$r1 = mysqli_query($con, $sql1);
$row1 = mysqli_fetch_assoc($r1);


if ($row1['total'] >= 1) {
    
    $sql_val = "SELECT validado FROM usuario where email = '{$email}'";

    $r3 = mysqli_query($con, $sql_val);
    
    $val = mysqli_fetch_row($r3);
    
    $sql_tok = "SELECT token FROM usuario where email = '{$email}'";
    
    $r4 = mysqli_query($con, $sql_tok);
    
    $tok = mysqli_fetch_row($r4);
    
    $sql_nome = "SELECT nome FROM usuario where email = '{$email}'";

    $r1 = mysqli_query($con, $sql_nome);
    
    $nome0 = mysqli_fetch_row($r1);
    
    $nome1 = explode(' ',trim($nome0[0]));
    
    $_SESSION['email'] = $email;
    $_SESSION['cel'] = $cel;
    $_SESSION['nome'] = $nome1[0];
    $_SESSION['nome_completo'] = $nome;
    $_SESSION['validado'] = $val[0];
    $_SESSION['token'] = $tok[0];
    if(!isset($_SESSION['pg_atual'])){$_SESSION['pg_atual'] = 'home.php';}
    header('Location: '. $_SESSION['pg_atual']);
    exit();
    
    
}else{
    $nome2 = explode(' ',trim($nome));
    $token = md5(uniqid(rand(), true));
    $sql_insert = "INSERT INTO usuario (nome, celular, email, token, validado, data_cadastro) VALUES ('$nome', '$cel', '$email', '$token', '1', NOW())";
    $con->query($sql_insert);
    $_SESSION['email'] = $email;
    $_SESSION['cel'] = $cel;
    $_SESSION['nome'] = $nome2[0];
    $_SESSION['nome_completo'] = $nome;
    $_SESSION['validado'] = 1;
    $_SESSION['token'] = $token;
    if(!isset($_SESSION['pg_atual'])){$_SESSION['pg_atual'] = 'home.php';}
    header('Location: '. $_SESSION['pg_atual']);
    exit();
}
