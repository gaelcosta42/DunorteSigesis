<?php
	define('_VALID_PHP', true);
	header('Content-Type: text/html; charset=utf-8');	
	
	require('enotas/eNotasGW.php');
	require('init.php');	
	
	use eNotasGW\Api\Exceptions as Exceptions;

	eNotasGW::configure(array(
		'apiKey' => $enotas_apikey
	));
	
	try
	{
		$id = get('id');
		$idExterno = 'nfc-'.$id;
		$row_venda = Core::getRowById("vendas", $id);
		$row_empresa = Core::getRowById("empresa", $row_venda->id_empresa);
		$id_enotas = $row_empresa->enotas;
		$retorno = eNotasGW::$NFeConsumidorApi->cancelar($id_enotas, $idExterno);
		$data = array(
			'inativo' => '1'
		);
        $db->update("receita", $data, "id_venda=" . $id);
        $db->update("produto_estoque", $data, "id_ref=" . $id);
        $db->update("cadastro_vendas", $data, "id_venda=" . $id);
        $db->update("cadastro_financeiro", $data, "id_venda=" . $id);
        $db->update("vendas", $data, "id=" . $id);
		echo "</br>NOTA FISCAL CANCELADA COM SUCESSO.";
		
		
	}
	catch(Exceptions\invalidApiKeyException $ex) {
		echo 'Erro de autenticação: </br></br>';
		echo $ex->getMessage();
	}
	catch(Exceptions\unauthorizedException $ex) {
		echo 'Acesso negado: </br></br>';
		echo $ex->getMessage();
	}
	catch(Exceptions\apiException $ex) {
		echo 'Erro de validação: </br></br>';
		echo $ex->getMessage();
	}
	catch(Exceptions\requestException $ex) {
		echo 'Erro na requisição web: </br></br>';
		
		echo 'Requested url: ' . $ex->requestedUrl;
		echo '</br>';
		echo 'Response Code: ' . $ex->getCode();
		echo '</br>';
		echo 'Message: ' . $ex->getMessage();
		echo '</br>';
		echo 'Response Body: ' . $ex->responseBody;
	}
?>