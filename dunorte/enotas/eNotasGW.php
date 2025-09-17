<?php
	require_once('helper.php');	
	require_once('exceptions/requestException.php');
	require_once('exceptions/apiException.php');
	require_once('exceptions/invalidApiKeyException.php');
	require_once('exceptions/unauthorizedException.php');
	require_once('apiBase.php');
	require_once('nfeApi.php');
	require_once('nfeApiBase.php');	
	require_once('empresaApi.php');
	require_once('nfeServicoApi.php');
	require_once('nfeProdutoApi.php');
	require_once('nfeConsumidorApi.php');
	require_once('prefeituraApi.php');
	require_once('servicosMunicipaisApi.php');
	require_once('fileParameter.php');
	require_once('request.php');
	require_once('response.php');
	require_once('proxy/proxyBase.php');
	require_once('proxy/curlProxy.php');
	require_once('media/formatters/formatterBase.php');
	require_once('media/formatters/jsonFormatter.php');
	require_once('media/formatters/formDataFormatter.php');

	use eNotasGW\Api as api;
	use eNotasGW\Api\Proxy as proxy;
	use eNotasGW\Api\Media\Formatters as formatters;  

	class eNotasGW {
		private static $_apiKey;
		private static $_defaultContentType = 'application/json';
		private static $_baseUrl = 'https://api.enotasgw.com.br';
		private static $_version = '2';
		private static $_versionedBaseUrl;
		private static $_proxy;
		private static $_formmaters;
		private static $_trustedCAListPath;

		public static $EmpresaApi;
		public static $NFeApi;
		public static $NFeServicoApi;
		public static $NFeProdutoApi;
		public static $NFeConsumidorApi;
		public static $PrefeituraApi;
		public static $ServicosMunicipaisApi;

		public static function configure($config) {
			$config = (object)$config;

			self::$_formmaters = array(
				'application/json' => new formatters\jsonFormatter(),
				'multipart/form-data' => new formatters\formDataFormatter()
			);

			if(!isset($config->apiKey)) {
				throw new Exception('A api key deve ser definida no método configure.');
			}

			self::$_apiKey = $config->apiKey;

			if(isset($config->baseUrl)) {
				self::$_baseUrl = $config->baseUrl;
			}

			if(isset($config->version)) {
				self::$_version = $config->version;
			}

			if(isset($config->defaultContentType)) {
				self::$_defaultContentType = $config->defaultContentType;
			}
			
			if(isset($config->_trustedCAListPath)) {
				self::$_trustedCAListPath = $config->_trustedCAListPath;
			}
			else {
				self::$_trustedCAListPath = dirname(__FILE__) . '/files/ca-bundle.crt';
			}

			self::$_versionedBaseUrl = self::$_baseUrl . '/v' . self::$_version;

			self::init();
		}

		public static function getMediaFormatter($contentType) {
			$contentType = explode(';', $contentType);
			
			return self::$_formmaters[$contentType[0]];
		}

		private static function init() {
			self::$_proxy = self::createProxy();
			self::$NFeApi = new api\nfeApi(self::$_proxy);
			self::$EmpresaApi = new api\empresaApi(self::$_proxy);
			self::$NFeServicoApi = new api\nfeServicoApi(self::$_proxy);
			self::$NFeProdutoApi = new api\nfeProdutoApi(self::$_proxy);
			self::$NFeConsumidorApi = new api\nfeConsumidorApi(self::$_proxy);
			self::$PrefeituraApi = new api\prefeituraApi(self::$_proxy);
			self::$ServicosMunicipaisApi = new api\servicosMunicipaisApi(self::$_proxy);
		}

		private static function createProxy() {
			return new proxy\curlProxy(array(
			  'baseUrl' => self::$_versionedBaseUrl,
			  'apiKey' => self::$_apiKey,
			  'defaultContentType' => self::$_defaultContentType,
			  'trustedCAListPath' => self::$_trustedCAListPath
			));
		}
	}
?>
