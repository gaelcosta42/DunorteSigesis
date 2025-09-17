<?php
   
   $pdf = "https://fiscal.sigesis.com.br/api/v1/public/empresa/01K0EY4EX71ES6GWAQZJ6CNKY0/nfce/01K0PHZ6N537NEFX6HKTMC7R0K/pdf";
				header('Content-Type: application/pdf');
				header('Content-Disposition: inline; filename="'.rawurlencode($data_impressao.'-NFCe-'.$id.'.pdf').'"');
				header('Cache-Control: private, max-age=0, must-revalidate');
				header('Pragma: public');
				echo $pdf;
?>