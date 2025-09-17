<?php
	define('_VALID_PHP', true);
	header('Content-Type: text/html; charset=utf-8');
	
	require('enotas/eNotasGW.php');
	require('init.php');
	
	use eNotasGW\Api\Exceptions as Exceptions;

	eNotasGW::configure(array(
		'apiKey' => $enotas_apikey
	));
	
	$id = get('id');
	$row_notafiscal = Core::getRowById('nota_fiscal', $id);
	$row_empresa = Core::getRowById('empresa', $row_notafiscal->id_empresa);
	$id_enotas = $row_empresa->enotas;
	
	if ($core->emissor_producao) {
		$idExterno = ($row_empresa->versao_emissao==0) ? 'nfe-'.$id : 'nfe'.$row_empresa->versao_emissao.'-'.$id;
		$ambiente = 'Producao'; //'Producao' ou 'Homologacao'
	} else {	
		$idExterno = ($row_empresa->versao_emissao==0) ? 'Hnfe-'.$id : 'Hnfe'.$row_empresa->versao_emissao.'-'.$id;
		$ambiente = 'Homologacao'; //'Producao' ou 'Homologacao'
	}	
	
	try
	{
		$retorno =  eNotasGW::$NFeApi->cancelar($id_enotas, $idExterno);
		
		/*	descomentar caso não possua o id único e queira efetuar o cancelamento pelo id externo		
		$idExterno = '1';
		eNotasGW::$NFeApi->cancelarPorIdExterno($id_enotas, $idExterno);		
		*/
		
		$data = array(
			'inativo' => '1'
		);

		if (isset($retorno->nfeId)) {
			$db->update("despesa", $data, "id_nota=" . $id);
			$db->update("receita", $data, "id_nota=" . $id);
			$db->update("nota_fiscal", $data, "id=" . $id);
			echo "</br>NOTA FISCAL DE SERVIÇO CANCELADA COM SUCESSO.";
		} else {
			echo "</br>NÃO FOI POSSIVEL CANCELAR A NOTA FISCAL.";
		}		
		
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