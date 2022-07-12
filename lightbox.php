<?php include_once("PagSeguroLibrary/PagSeguroLibrary.php"); ?>
<?php if (PagSeguroConfig::getEnvironment() == "sandbox") : ?>
    <script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
<?php else : ?>
    <script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
<?php endif; ?>

<?php
$paymentRequest = new PagSeguroPaymentRequest();
$paymentRequest->addItem('0001', 'Notebook', 1, 2430.00);
$paymentRequest->addItem('0002', 'Mochila', 1, 150.99);

$paymentRequest->setCurrency("BRL");

// Referenciando a transação do PagSeguro em seu sistema  
$paymentRequest->setReference("REF123");

// URL para onde o comprador será redirecionado (GET) após o fluxo de pagamento  
$paymentRequest->setRedirectUrl("https://gravadorpub.com.br/home.php");

// URL para onde serão enviadas notificações (POST) indicando alterações no status da transação  
$paymentRequest->addParameter('notificationURL', 'https://gravadorpub.com.br/response.php');

$paymentRequest->addParameter('senderBornDate', '07/05/1981');

try {
    $onlyCheckoutCode = true;
    $credentials = PagSeguroConfig::getAccountCredentials(); // getApplicationCredentials()  
    $checkoutUrl = $paymentRequest->register($credentials, $onlyCheckoutCode);
    
    echo "<script>PagSeguroLightbox('" . $checkoutUrl . "');</script>";
    
} catch (PagSeguroServiceException $e) {
    die($e->getMessage());
}  



