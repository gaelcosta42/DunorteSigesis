<?php
 /**
   * TESTE - Emitir QRCode para Pagamento de PIX
   *
   */

   define('_VALID_PHP', true);
	
	require_once('init.php');

    require_once "vendor/autoload.php";
    require_once "PSP/sicoob/admin/config.php";

    use Endroid\QrCode\Builder\Builder;
    use Endroid\QrCode\Writer\PngWriter;
    
    use \PSP\sicoob\app\Pix\Payload as PP;
    use \PSP\sicoob\app\Pix\Sicoob as SP;
    use Mpdf\QrCode\QrCode;
    use Mpdf\QrCode\Output\Png;

    //Instancia um objeto ApiSicoob com os dados iniciais configurados no construtor da classe
    $objPix = new SP();

    //Cria uma cobrança para ser enviada ao banco
    $cobranca = [
        'calendario' => [
            'expiracao' => 3600                             //Tempo em segundos para expiração do qrCode
        ],
        'devedor' => [
            'cpf' => '01442976632',                         //CPF ou CNPJ do devedor
            'nome' => 'Filipe Costa Fernandes'                 //Nome do devedor ou razão social
        ],
        'valor' => [
            'original' => '2.00'                           //Valor da transação
        ],
        'chave' => SICOOBPIX_CHAVE,                         //Chave pix do beneficiário
        'solicitacaoPagador' => 'Cliente: nome do cliente da compra'   //Mensagem que pode ser enviada ao pagador para ser visualizada no momento de scanear o QR Code
    ];

    //A função criaCob faz uma chamada à API do Sicoob enviando os dados da cobrança e retorna um json com dados da cobrança imediata criada
    $resposta = $objPix->criarCob($cobranca);

    /** 
     * Verificação simples
     * O campo location é a URL da cobrança imediata que foi criada
     * Caso exista esse campo no retorno da chamada a API do Sicoob sabe-se que a criação da cobrança funcionou corretamente
     */
if (isset($resposta['location'])) {
    // Instância principal do payload Pix
    /*
    Nao vou precisar do payload pix por enquanto

    $objPayload = (new PP)
    ->__set('titularConta', SICOOBPIX_TITULAR)         //nome do titular da conta (beneficiário)
    ->__set('cidTitular', SICOOBPIX_CID_TITULAR)       //cidade do titular da conta (evitar caracteres especiais)
    ->__set('valor', $resposta['valor']['original'])   //valor da transação conforme criação da cobrança imediata
    ->__set('txid', $resposta['txid'])                 //txid gerado automaticamente ao criar cobrança imediata
    ->__set('url', $resposta['location'])              //url do payload dinâmico
    ->__set('pagamentoUnico', true);                   //valor padrão "false" definido na classe Payload, só precisa ser informado caso queira alterar

    // Código de pagamento PIX
    $payloadQrCode = $objPayload->getPayload();
    */

    // Gerando imagem do QR Code
    $result = Builder::create()
        ->writer(new PngWriter())
        ->data($resposta['brcode'])
        ->size(350)
        ->build();

    // Mostra imagem direto no navegador
    //header('Content-Type: ' . $result->getMimeType());
    //echo $result->getString();

    // Converte para base64 para embutir no HTML
    $qrCodeBase64 = base64_encode($result->getString());

} else {
    echo 'Problema ao gerar PIX';
    echo '<pre>';
    print_r($resposta);
    echo '</pre>';
    exit;
}

?>

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>QrCode Pix Sicoob</title>
    </head>
    <body style="text-align: center">
        <h1>CASA DE CARNE PEDRA BRANCA - PAGAMENTO VENDA: xxx</h1>
        <br>

        <div class="qr-code">
            <p>Escaneie o QR Code abaixo para pagar via PIX:</p>
            <img src="data:image/png;base64,<?= $qrCodeBase64 ?>" alt="QR Code PIX">
        </div>

        <br>

        Código pix: <br>
        <strong> <?= $resposta['brcode'] ?> </strong>

        <br><br>
        Valor do PIX: <?php echo $resposta['valor']['original']; ?>
        <br>
        TXID do PIX.: <?php echo $resposta['txid']; ?>
        <br>
        LOCATION....: <?php echo $resposta['location']; ?>

    </body>
</html>