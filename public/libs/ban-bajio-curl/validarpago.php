<?php
	$original_string = $_POST['cl_folio']."|".$_POST['t_concepto']."|".$_POST['cl_referencia']."|".$_POST['dl_monto']."|".$_POST['dt_fechaPago']."|".$_POST['nl_tipoPago']."|". $_POST['nl_status']."|";	
	$public_key_pem = "test-pubk-bajio.pem";
	$public_key = openssl_pkey_get_public(file_get_contents($public_key_pem));	
	$sign = str_replace('-','+', $_POST['hash']);
	$sign = str_replace('_','/', $sign);
	$sign = str_replace(',','=', $sign);	
	$result = openssl_verify($original_string, base64_decode($sign), $public_key, OPENSSL_ALGO_SHA512);
	if ($result === 1){
		echo 'estatus_validacion=0';
	}else{
		echo 'estatus_validacion=1';
	};
?>