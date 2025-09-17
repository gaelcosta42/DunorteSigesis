<?php
/** URL de autenticação para API PIX do SICOOB */
define("URL_AUTENTICACAO", "https://auth.sicoob.com.br/auth/realms/cooperado/protocol/openid-connect/token");

/** URL de produção API PIX do SICOOB */
define("URL_PIX", "https://api.sicoob.com.br/pix/api/v2");

/** Aqui deve ser informado o valor da chave CLIENT_ID que precisa ser criada no portal (https://developers.sicoob.com.br/portal/) conforme documentação do SICOOB 
 *  Chave fictícia, meramente para exemplificar o formato da mesma */
define("SICOOBPIX_CLIENT_ID", "ce6e408f-e449-4709-af2a-7c689804ca1f");

/** Caminho do certificado público (A1) - Emitido no CPF ou CNPJ do Cooperado */
define("SICOOBPIX_CAMINHO_CERT_PUBLICO", "certificado.crt");

/** Caminho do certificado privado (A1) - Emitido no CPF ou CNPJ do Cooperado */
define("SICOOBPIX_CAMINHO_CERT_PRIVADO", "chave.key");

/** Senha do certificado (Caso os arquivos publico e privado tenham senhas diferentes é necessário criar uma constante para cada um) */
define("SICOOBPIX_SENHA_CERT", "38484220");

// Definindo chave pix recebedor
define("SICOOBPIX_CHAVE", "38484220000100");

// Definindo titular da conta
define("SICOOBPIX_TITULAR", "YKARO JANUARIO SOUZA DE SILVA");

// Definindo cidade do Titular da conta
define("SICOOBPIX_CID_TITULAR", "IPATINGA");

?>