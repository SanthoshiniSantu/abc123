<?php 

function encryption($simple_string){

	$ciphering = "AES-128-CTR"; 
	$iv_length = openssl_cipher_iv_length($ciphering); 
	$options = 0; 
	$encryption_iv = '2357111317192329'; 
	$encryption_key = "chattingsystem"; 
	$encryption = openssl_encrypt($simple_string, $ciphering, $encryption_key, $options, $encryption_iv);
	return $encryption; 
}


function decryption($encryption){
	$ciphering = "AES-128-CTR";
	$iv_length = openssl_cipher_iv_length($ciphering); 
	$options = 0;  
	$decryption_iv = '2357111317192329'; 
	$decryption_key = "chattingsystem"; 
	$decryption=openssl_decrypt ($encryption, $ciphering, $decryption_key, $options, $decryption_iv); 
	return $decryption;
}

// echo encryption("Hello World")."<br>";
// echo decryption(encryption("Hello World"));
 

?> 
