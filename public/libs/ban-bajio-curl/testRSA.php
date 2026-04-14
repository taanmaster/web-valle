<?php

function SignData($text, $privateKeyFile)
{

	$private_cert = $privateKeyFile;

 	$f = fopen($private_cert,"r+");

	if($f)
			$private_key = fread( $f, filesize($private_cert) );
	else
			return "";

	fclose($f);

	$private_key = openssl_get_privatekey($private_key);
	if(openssl_sign($text, $crypt_text, $privateKey, OPENSSL_ALGO_SHA512))
	{
		return base64_url_encode($crypt_text) . "\n";
	}	
 
	return "";
}

function VerifyData($crypt_text, $plaintext, $publicKeyFile)
{
        $public_cert = $publicKeyFile;

        $s = fopen($public_cert,"r+");

        if($s)
                $public_key = fread( $s, filesize($publicKeyFile));
        else
                return false;

        fclose($s);

        $res = openssl_get_publickey($public_key);
		
		if (openssl_verify($plaintext, base64_url_decode($crypt_text), $res, OPENSSL_ALGO_SHA512) === 1){
			return true;
		}
		return false;
}

function base64_url_encode($input) {
    return strtr(base64_encode($input), '+/=', '-_,');
}

function base64_url_decode($input) {
    return base64_decode(strtr($input, '-_,', '+/='));
}

//Genera cadena encriptada  que se manda
$cadenaEncriptada =   "123|456|485.22|01|03|";
    echo $cadenaEncriptada;

	$base64 = SignData($cadenaEncriptada ,"private_key_QA.pem");
	echo "\n Base64(RSA(Hash)) = " . $base64 . "\n";

// Valida Cadena que se recibe
$cadenaEncriptada =   "123|456|485.22|01|03|";
$base64= "CJ580qUKzlH3wxhgT9vy9T_VNCNg_c4BO8zxVrzhbqo4MjkG-h2-ClFyXlimxbVUiP3Kuw0YhlT0q8yOBcd3U84LYphA6-wcI0UtGjP6Es57HTu05_T5B2UtQs6Tb5QhGtvfkuEybd4TO8oJ5QODuu-36OWIA4fMYTTSG80kaVs,";
?>

<p>Verificando datos: </p>
<?php
echo  $cadenaEncriptada;
?>

<p> Base64(RSA(Hash)) </p>
<?php
echo  $base64;

//aluna 24sep2009
//**************************************************************************************************

	if( VerifyData($base64, $cadenaEncriptada , "public_key_bajio_QA.pem") )
		echo "\nDatos validos BANCO DEL BAJIO :)\n";
	else
		echo "\nDATOS INVALIDOS BB :( \n";
?>



