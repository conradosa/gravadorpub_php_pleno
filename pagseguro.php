<?php
    include('verifica_se_nao_logado.php');
    include_once("PagSeguroLibrary/PagSeguroLibrary.php");

    $paymentRequest = new PagSeguroPaymentRequest();  
    $paymentRequest->addItem('0001', 'Mochila',  1, 150.99); 
    $paymentRequest->setCurrency("BRL");  

    // Referenciando a transação do PagSeguro em seu sistema  
    $paymentRequest->setReference("REF123");  
    
    // URL para onde o comprador será redirecionado (GET) após o fluxo de pagamento  
    $paymentRequest->setRedirectUrl("https://gravadorpub.com.br/home.php");  
    
    // URL para onde serão enviadas notificações (POST) indicando alterações no status da transação  
    $paymentRequest->addParameter('notificationURL', 'http://www.lojamodelo.com.br/nas'); 
    
    try {  

        $credentials = PagSeguroConfig::getAccountCredentials(); // getApplicationCredentials()  
        $checkoutUrl = $paymentRequest->register($credentials); 
        
        echo "<a href='{$checkoutUrl}'>Pagar agora!</a>";
        
        } catch (PagSeguroServiceException $e) {  
            die($e->getMessage());  
        }  

?>