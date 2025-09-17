<?php

/**
 * PDF - Nota Fiscal de SERVICO - Emissao
 *
 */

define('_VALID_PHP', true);
header('Content-Type: text/html; charset=utf-8');

require_once('enotas/eNotasGW.php');
require_once('init.php');

if (!$usuario->is_Todos())
	redirect_to('login.php');

use eNotasGW\Api\Exceptions as Exceptions;

eNotasGW::configure(array(
	'apiKey' => $enotas_apikey,
	'version' => 1
));

$id = get('id');
$dg = get('debug');
$debug = ($dg == 1) ? true : false;

$row_notafiscal = Core::getRowById('nota_fiscal', $id);
$row_empresa = Core::getRowById('empresa', $row_notafiscal->id_empresa);
$row_cadastro = Core::getRowById('cadastro', $row_notafiscal->id_cadastro);

$id_enotas = $row_empresa->enotas;
$cnpj_contador = $row_empresa->cnpj_contador;

if ($core->emissor_producao) {
	$ambiente = 'Producao'; //'Producao' ou 'Homologacao'
	$idExterno = ($row_empresa->versao_emissao == 0) ? 'nfse-' . $id : 'nfse' . $row_empresa->versao_emissao . '-' . $id;
} else {
	$ambiente = 'Homologacao'; //'Producao' ou 'Homologacao'
	$idExterno = ($row_empresa->versao_emissao == 0) ? 'Hnfse-' . $id : 'Hnfse' . $row_empresa->versao_emissao . '-' . $id;
}

$razao_social = $row_cadastro->razao_social;
$cpf_cnpj = limparNumero($row_cadastro->cpf_cnpj);	
$tipoPessoa = ($row_cadastro->tipo == 1) ? 'J' : 'F';
$enviarPorEmail = ($row_cadastro->email) ? true : false;

if (strlen($cpf_cnpj) != 14 && $tipoPessoa == 'J')
	Filter::$msgs['cpf_cnpj'] = 'ERRO NO CNPJ DO CLIENTE (deve ter 14 digitos): ' . $cpf_cnpj;

if (strlen($cpf_cnpj) != 11 && $tipoPessoa == 'F')
	Filter::$msgs['cpf_cnpj'] = 'ERRO NO CPF DO CLIENTE (deve ter 11 digitos): ' . $cpf_cnpj;

$cep = limparNumero($row_cadastro->cep);
if (strlen($cep) != 8 && !$row_notafiscal->nota_exportacao)
	Filter::$msgs['cep'] = 'ERRO NO CEP DO ENDERECO DO CLIENTE (deve ter 8 digitos): ' . $cep;

$complemento = ($row_cadastro->complemento) ? $row_cadastro->complemento : null;

if (empty(Filter::$msgs)) {
	try {
		if ($row_notafiscal->fiscal == 1 && $row_notafiscal->status_enotas != "Negada") {
			if ($row_notafiscal->chaveacesso && $row_notafiscal->fiscal && $row_notafiscal->status_enotas == "Autorizada") {
				$pdf = eNotasGW::$NFeApi->downloadPdf($id_enotas, $idExterno);
				header('Content-Type: application/pdf');
				header('Content-Disposition: inline; filename="' . rawurlencode('nfse-' . $idExterno . '.pdf') . '"');
				header('Cache-Control: private, max-age=0, must-revalidate');
				header('Pragma: public');
				echo $pdf;
			} else {
				$retorno = eNotasGW::$NFeApi->consultarPorIdExterno($id_enotas, $idExterno);
				if ($retorno->status == 'Autorizada') {
					$dataRetornoAPI = new DateTime($retorno->dataAutorizacao);
					$dataRetornoAPI->sub(new DateInterval('PT03H00S'));
					$data_emissao = $dataRetornoAPI->format('Y-m-d H:i:s');
					if (intval($retorno->numero) > 0) {
						$data = array(
							'numero_nota' => $retorno->numero,
							'numero' => $retorno->numero,
							'chaveacesso' => $retorno->codigoVerificacao,
							'link_danfe' => $retorno->linkDownloadPDF,
							'link_download_xml' => $retorno->linkDownloadXML,
							'status_enotas' => $retorno->status,
							'motivo_status' => $retorno->motivoStatus,
							//'contingencia' => ($retorno->forcarEmissaoContingencia && empty($retorno->dataAutorizacao)) ? 1 : 0,
							'data_emissao' => $data_emissao,
							'data_entrada' => $data_emissao,
							'fiscal' => '1',
							'usuario' => session('nomeusuario'),
							'data' => "NOW()"
						);

						if ($retorno->linkDownloadXML) {
							$xml = simplexml_load_file($retorno->linkDownloadXML);
							if ($xml) {
								$namespaces_xml = $xml->getNamespaces(true);
								$nfse_xml = $xml->children($namespaces_xml['']);	
								if (isset($nfse_xml->InfNfse->LinkNota)) {
									$data['link_nota_emissor'] = (string)$nfse_xml->InfNfse->LinkNota;
								}
							}
							
						}

						$db->update("nota_fiscal", $data, "id=" . $id);
						$pdf = eNotasGW::$NFeApi->downloadPdf($id_enotas, $idExterno);
						header('Content-Type: application/pdf');
						header('Content-Disposition: inline; filename="' . rawurlencode('nfse-' . $idExterno . '.pdf') . '"');
						header('Cache-Control: private, max-age=0, must-revalidate');
						header('Pragma: public');
						echo $pdf;
					}
				} else {
					$numero_nota = (isset($retorno->numero)) ? $retorno->numero : "";
					if (isset($retorno->dataAutorizacao)) {
						$dataRetornoAPI = new DateTime($retorno->dataAutorizacao);
						$dataRetornoAPI->sub(new DateInterval('PT03H00S'));
						$data_emissao = $dataRetornoAPI->format('Y-m-d H:i:s');
					}
					$data = array(
						'numero_nota' => $numero_nota,
						'numero' => $numero_nota,
						'chaveacesso' => (isset($retorno->codigoVerificacao)) ? $retorno->codigoVerificacao : "",
						'link_danfe' => (isset($retorno->linkDownloadPDF)) ? $retorno->linkDownloadPDF : "",
						'link_download_xml' => (isset($retorno->linkDownloadXML)) ? $retorno->linkDownloadXML : "",
						'status_enotas' => (isset($retorno->status)) ? $retorno->status : "",
						'motivo_status' => (isset($retorno->motivoStatus)) ? $retorno->motivoStatus : "",
						//'contingencia' => (isset($retorno->forcarEmissaoContingencia) && $retorno->forcarEmissaoContingencia && empty($retorno->dataAutorizacao)) ? 1 : 0,
						'fiscal' => '1',
						'usuario' => session('nomeusuario'),
						'data' => "NOW()"
					);
					if (isset($data_emissao)) {
						$data['data_emissao'] = $data_emissao;
						$data['data_entrada'] = $data_emissao;
					}

					if ($retorno->linkDownloadXML) {
						$xml = simplexml_load_file($retorno->linkDownloadXML);
						if ($xml) {
							$namespaces_xml = $xml->getNamespaces(true);
							$nfse_xml = $xml->children($namespaces_xml['']);	
							if (isset($nfse_xml->InfNfse->LinkNota)) {
								$data['link_nota_emissor'] = (string)$nfse_xml->InfNfse->LinkNota;
							}
						}
						
					}

					$db->update("nota_fiscal", $data, "id=" . $id);

					echo "</br>--- status: " . $retorno->status . " ---</br>";
					$dataRetornoAPI = new DateTime($retorno->dataAutorizacao);
					$dataRetornoAPI->sub(new DateInterval('PT03H00S'));
					$data_emissao = $dataRetornoAPI->format('Y-m-d H:i:s');
					echo "</br>--- dataAutorizacao: " . exibedata($data_emissao) . " ---</br>";
					$dataCriacao = substr(sanitize($retorno->dataCriacao), 0, 10);
					echo "</br>--- dataCriacao: " . exibedata($dataCriacao) . " ---</br>";
					$dataUltimaAlteracao = substr(sanitize($retorno->dataUltimaAlteracao), 0, 10);
					echo "</br>--- dataUltimaAlteracao: " . exibedata($dataUltimaAlteracao) . " ---</br>";
				}
			}
		} else {
			$telefone = (validaTelefone($row_cadastro->telefone)) ? validaTelefone($row_cadastro->telefone) : "";
			$telefone = ($telefone == "" && validaTelefone($row_cadastro->telefone2)) ? validaTelefone($row_cadastro->telefone2) : $telefone;
			$telefone = ($telefone == "" && validaTelefone($row_cadastro->celular)) ? validaTelefone($row_cadastro->celular) : $telefone;

			$array_cliente = array(
				'tipoPessoa' => $tipoPessoa,
				'nome' => $row_cadastro->razao_social,
				'email' => ($row_cadastro->email) ? $row_cadastro->email : null,
				'telefone' => $telefone,
				'cpfCnpj' => $cpf_cnpj,
				'endereco' => array(
					'uf' => $row_cadastro->estado,
					'cidade' => obterCodigoIbgeCidade($row_cadastro->cidade, $row_cadastro->estado),
					'logradouro' => $row_cadastro->endereco,
					'numero' => limparNumero($row_cadastro->numero),
					'complemento' => $complemento,
					'bairro' => $row_cadastro->bairro,
					'cep' => $cep
				)
			);
			
			$ie = intval(limparNumero($row_cadastro->ie));
			if ($ie && $tipoPessoa == 'J') {
				$array_cliente['inscricaoEstadual'] = $row_cadastro->ie;
			} else if ($row_cadastro->ie == 'ISENTO' || $row_cadastro->ie == 'ISENTA') {
				$array_cliente['inscricaoEstadual'] = 'isento';
			} else {
				$array_cliente['inscricaoEstadual'] = null;
			}

			$issRetidoFonte = ($row_notafiscal->iss_retido) ? true : false;
			$nota_simples = array(
				'idExterno' => $idExterno,
				'ambienteEmissao' => $ambiente,  //'Producao' ou 'Homologacao'
				'tipo' => 'NFS-e',
				'enviarPorEmail'=> $enviarPorEmail,
				'cliente'=> $array_cliente,				
				'servico' => array(
					'ufPrestacaoServico' => $row_empresa->estado,
					'municipioPrestacaoServico' => obterCodigoIbgeCidade($row_empresa->cidade, $row_empresa->estado),
					'descricao' => $row_notafiscal->descriminacao,
					'aliquotaIss' => $row_notafiscal->iss_aliquota,
					'issRetidoFonte' => $issRetidoFonte,
					'codigoServicoMunicipio' => $row_empresa->codigomunicipal,
					'descricaoServicoMunicipio' => $row_empresa->descricaoservico,
					'itemListaServicoLC116' => $row_empresa->codigomunicipal,
					'cnae' => $row_empresa->cnae,
					'valorCofins' => $row_notafiscal->valor_cofins,
					'valorCsll' => $row_notafiscal->valor_csll,
					'valorInss' => $row_notafiscal->valor_inss,
					'valorIr' => $row_notafiscal->valor_ir,
					'valorPis' => $row_notafiscal->valor_pis
				),
				'deducoes' => 0,
				'descontos' => 0,
				'valorTotal' => $row_notafiscal->valor_nota,
				'observacoes' => $row_notafiscal->inf_adicionais					
			);

			/*
			if ($cnpj_contador) {
				$array_contador = array();
				$array_contador[] = array(
					'cpfCnpj' => $cnpj_contador
				);
				$nota_simples['autorizacaoDownloadXml'] = $array_contador;
			}
			*/
			
			if ($debug) {
				echo "ID EMPRESA: $id_enotas </br>";
				echo "</br>--- INICIO NOTA NORMAL ---</br>";
				$json_nota = json_encode($nota_simples);
				echo $json_nota;
				echo "</br>--- FIM NOTA NORMAL ---</br>";
			}

			//$enota = eNotasGW::$NFeServicoApi->emitir($id_enotas, $nota_simples);
			$enota = eNotasGW::$NFeApi->emitir($id_enotas, $nota_simples);
			sleep(15);
			$retorno = eNotasGW::$NFeApi->consultarPorIdExterno($id_enotas, $idExterno);

			if ($retorno->status == 'Autorizada') {
				$dataRetornoAPI = new DateTime($retorno->dataAutorizacao);
				$dataRetornoAPI->sub(new DateInterval('PT03H00S'));
				$data_emissao = $dataRetornoAPI->format('Y-m-d H:i:s');
				if (intval($retorno->numero) > 0) {
					$data = array(
						'numero_nota' => $retorno->numero,
						'numero' => $retorno->numero,
						'chaveacesso' => $retorno->codigoVerificacao,
						'link_danfe' => $retorno->linkDownloadPDF,
						'link_download_xml' => $retorno->linkDownloadXML,
						'status_enotas' => $retorno->status,
						'motivo_status' => $retorno->motivoStatus,
						//'contingencia' => ($retorno->forcarEmissaoContingencia && empty($retorno->dataAutorizacao)) ? 1 : 0,
						'data_emissao' => $data_emissao,
						'data_entrada' => $data_emissao,
						'fiscal' => '1',
						'usuario' => session('nomeusuario'),
						'data' => "NOW()"
					);

					if ($retorno->linkDownloadXML) {
						$xml = simplexml_load_file($retorno->linkDownloadXML);
						if ($xml) {
							$namespaces_xml = $xml->getNamespaces(true);
							$nfse_xml = $xml->children($namespaces_xml['']);	
							if (isset($nfse_xml->InfNfse->LinkNota)) {
								$data['link_nota_emissor'] = (string)$nfse_xml->InfNfse->LinkNota;
							}
						}
						
					}

					$db->update("nota_fiscal", $data, "id=" . $id);
					if (!$debug) {
						redirect_to("index.php?do=notafiscal&acao=visualizar&id=" . $id);
					}
				}
			} else {
				sleep(15);
				echo "<b/>Consulta para buscar retorno NFS-e NORMAL:</b></br>";
				$retorno = eNotasGW::$NFeApi->consultarPorIdExterno($id_enotas, $idExterno);
				echo "Envio da consulta para o ID: $id </br>";
				echo "ID da empresa: $id_enotas </br></br>";
				echo 'STATUS: ';
				echo $retorno->status;
				echo '</br>';
				echo 'MOTIVO STATUS: ';
				echo $retorno->motivoStatus;
				echo '</br>';
				if ($debug) {
					echo "</br>--- RETORNO COMPLETO ---</br>";
					echo json_encode($retorno);
					echo "</br>--- FIM RETORNO ---</br>";
				}
				if ($retorno->status == 'Autorizada') {
					$dataRetornoAPI = new DateTime($retorno->dataAutorizacao);
					$dataRetornoAPI->sub(new DateInterval('PT03H00S'));
					$data_emissao = $dataRetornoAPI->format('Y-m-d H:i:s');
					if (intval($retorno->numero) > 0) {
						$data = array(
							'numero_nota' => $retorno->numero,
							'numero' => $retorno->numero,
							'chaveacesso' => $retorno->codigoVerificacao,
							'link_danfe' => $retorno->linkDownloadPDF,
							'link_download_xml' => $retorno->linkDownloadXML,
							'status_enotas' => $retorno->status,
							'motivo_status' => $retorno->motivoStatus,
							//'contingencia' => ($retorno->forcarEmissaoContingencia && empty($retorno->dataAutorizacao)) ? 1 : 0,
							'data_emissao' => $data_emissao,
							'data_entrada' => $data_emissao,
							'fiscal' => '1',
							'usuario' => session('nomeusuario'),
							'data' => "NOW()"
						);

						if ($retorno->linkDownloadXML) {
							$xml = simplexml_load_file($retorno->linkDownloadXML);
							if ($xml) {
								$namespaces_xml = $xml->getNamespaces(true);
								$nfse_xml = $xml->children($namespaces_xml['']);	
								if (isset($nfse_xml->InfNfse->LinkNota)) {
									$data['link_nota_emissor'] = (string)$nfse_xml->InfNfse->LinkNota;
								}
							}
							
						}

						$db->update("nota_fiscal", $data, "id=" . $id);
						if (!$debug) {
							redirect_to("index.php?do=notafiscal&acao=visualizar&id=" . $id);
						}
					}
				} else {
					$numero_nota = (isset($retorno->numero)) ? $retorno->numero : "";
					if (isset($retorno->dataAutorizacao)) {
						$dataRetornoAPI = new DateTime($retorno->dataAutorizacao);
						$dataRetornoAPI->sub(new DateInterval('PT03H00S'));
						$data_emissao = $dataRetornoAPI->format('Y-m-d H:i:s');
					}
					$data = array(
						'numero_nota' => $numero_nota,
						'numero' => $numero_nota,
						'chaveacesso' => (isset($retorno->codigoVerificacao)) ? $retorno->codigoVerificacao : "",
						'link_danfe' => (isset($retorno->linkDownloadPDF)) ? $retorno->linkDownloadPDF : "",
						'link_download_xml' => (isset($retorno->linkDownloadXML)) ? $retorno->linkDownloadXML : "",
						'status_enotas' => (isset($retorno->status)) ? $retorno->status : "",
						'motivo_status' => (isset($retorno->motivoStatus)) ? $retorno->motivoStatus : "",
						//'contingencia' => (isset($retorno->forcarEmissaoContingencia) && $retorno->forcarEmissaoContingencia && empty($retorno->dataAutorizacao)) ? 1 : 0,
						'fiscal' => '1',
						'usuario' => session('nomeusuario'),
						'data' => "NOW()"
					);
					if (isset($data_emissao)) {
						$data['data_emissao'] = $data_emissao;
						$data['data_entrada'] = $data_emissao;
					}

					if (isset($retorno->linkDownloadXML) && $retorno->linkDownloadXML) {
						$xml = simplexml_load_file($retorno->linkDownloadXML);
						if ($xml) {
							$namespaces_xml = $xml->getNamespaces(true);
							$nfse_xml = $xml->children($namespaces_xml['']);	
							if (isset($nfse_xml->InfNfse->LinkNota)) {
								$data['link_nota_emissor'] = (string)$nfse_xml->InfNfse->LinkNota;
							}
						}
						
					}
					
					$db->update("nota_fiscal", $data, "id=" . $id);

					echo "</br>--- status: " . $retorno->status . " ---</br>";
					if (isset($retorno->dataAutorizacao)) {
						$dataRetornoAPI = new DateTime($retorno->dataAutorizacao);
						$dataRetornoAPI->sub(new DateInterval('PT03H00S'));
						$data_emissao = $dataRetornoAPI->format('Y-m-d H:i:s');
						echo "</br>--- dataAutorizacao: " . exibedata($data_emissao) . " ---</br>";
					}
					$dataCriacao = substr(sanitize($retorno->dataCriacao), 0, 10);
					echo "</br>--- dataCriacao: " . exibedata($dataCriacao) . " ---</br>";
					$dataUltimaAlteracao = substr(sanitize($retorno->dataUltimaAlteracao), 0, 10);
					echo "</br>--- dataUltimaAlteracao: " . exibedata($dataUltimaAlteracao) . " ---</br>";
				}
			}
		}
	} catch (Exceptions\invalidApiKeyException $ex) {
		echo 'Erro de autenticação: </br></br>';
		echo $ex->getMessage();
	} catch (Exceptions\unauthorizedException $ex) {
		echo 'Acesso negado: </br></br>';
		echo $ex->getMessage();
	} catch (Exceptions\apiException $ex) {
		echo '<b>Erro de validação:</b> </br></br>';
		$msg = $ex->getMessage();
		echo '<b>Mensagem:</b> </br></br>';
		if (validaTexto($msg, 'Autorizada')) {
			$retorno = eNotasGW::$NFeApi->consultarPorIdExterno($id_enotas, $idExterno);
			if ($retorno->status == 'Autorizada') {
				$dataRetornoAPI = new DateTime($retorno->dataAutorizacao);
				$dataRetornoAPI->sub(new DateInterval('PT03H00S'));
				$data_emissao = $dataRetornoAPI->format('Y-m-d H:i:s');
				if (intval($retorno->numero) > 0) {
					$data = array(
						'numero_nota' => $retorno->numero,
						'numero' => $retorno->numero,
						'chaveacesso' => $retorno->codigoVerificacao,
						'link_danfe' => $retorno->linkDownloadPDF,
						'link_download_xml' => $retorno->linkDownloadXML,
						'status_enotas' => $retorno->status,
						'motivo_status' => $retorno->motivoStatus,
						//'contingencia' => ($retorno->forcarEmissaoContingencia && empty($retorno->dataAutorizacao)) ? 1 : 0,
						'data_emissao' => $data_emissao,
						'data_entrada' => $data_emissao,
						'fiscal' => '1',
						'usuario' => session('nomeusuario'),
						'data' => "NOW()"
					);

					if ($retorno->linkDownloadXML) {
						$xml = simplexml_load_file($retorno->linkDownloadXML);
						if ($xml) {
							$namespaces_xml = $xml->getNamespaces(true);
							$nfse_xml = $xml->children($namespaces_xml['']);	
							if (isset($nfse_xml->InfNfse->LinkNota)) {
								$data['link_nota_emissor'] = (string)$nfse_xml->InfNfse->LinkNota;
							}
						}
						
					}

					$db->update("nota_fiscal", $data, "id=" . $id);
					if (!$debug) {
						redirect_to("index.php?do=notafiscal&acao=visualizar&id=" . $id);
					}
				}
			} else {
				echo "ID da empresa: $id_enotas </br></br>";
				echo "Retorno de dados da nota (consulta por id): $id</br></br>";
				echo 'STATUS: ';
				echo $retorno->status;
				echo '</br>';
				echo 'MOTIVO STATUS: ';
				echo $retorno->motivoStatus;
				echo '</br>';
				if ($debug) {
					echo "</br>--- RETORNO COMPLETO ---</br>";
					echo json_encode($retorno);
					echo "</br>--- FIM RETORNO ---</br>";
				}
			}
		} else {
			echo $msg;
		}
	} catch (Exceptions\requestException $ex) {
		echo 'Erro na requisição web: </br></br>';

		echo 'Requested url: ' . $ex->requestedUrl;
		echo '</br>';
		echo 'Response Code: ' . $ex->getCode();
		echo '</br>';
		echo 'Message: ' . $ex->getMessage();
		echo '</br>';
		echo 'Response Body: ' . $ex->responseBody;
	}
} else {
	echo 'CLIENTE: ' . $razao_social;
	echo '<br/>';
	echo '<a href="index.php?do=cadastro&acao=editar&id=' . $row_notafiscal->id_cadastro . '" title="EDITAR O CLIENTE" target="_blank">EDITAR O CLIENTE</a>';
	echo '<br/>';
	echo '<br/>';
	$retorno = Filter::msgStatus();
	$mensagem = explode('#', $retorno);
	print $mensagem[0];
}