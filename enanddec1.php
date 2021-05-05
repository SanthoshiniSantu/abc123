<?php
function encryption($string1,$string2){

	$n3=intval((strlen($string1)/strlen($string2)));
	$n4=intval((strlen($string1)%strlen($string2)));
	echo $n3." ".$n4."<br>";
	$i=0;
	$j=0;
	$encrypted_string='';
	while($i<strlen($string1)){
		if($j==strlen($string2)){
			$j=0;
		}
		$encrypted_string.=strval($string1[$i]).strval($string2[$j]);
		$i++;
		$j++;

	}
	if($i==strlen($string1)){
		if($j!=strlen($string2)){
			$encrypted_string.=substr($string2,$j);
		}
	}

	// echo $encrypted_string;

	$encrypted_decimal='';
	$as=0;
	while($as<strlen($encrypted_string)){
		$dup=strval(decbin(ord($encrypted_string[$as])));
		while(strlen($dup)<8)
			$dup='0'.$dup;
		$encrypted_decimal.=$dup;
		$as++;
	}
	// $encrypted_decimal.=strval(decbin(ord($encrypted_string[$as])));

	// echo "<br>".$encrypted_decimal;
	return $encrypted_decimal;

}

function decryption($string1,$string2,$n3,$n4){
	$array_obtained=array();
	$i=0;
	while($i<strlen($string1)){
		echo $i." ".($i+8);
		$dup=substr($string1, $i,8);
		array_push($array_obtained,$dup);
		// echo $i." ".$dup."<br>";
		$i=$i+8	;
	}
	// $array_obtained=explode(",",$string1);
	
	$decrypted_string='';
	for($i=0;$i<sizeof($array_obtained);$i++){
		$decrypted_string.=chr(bindec($array_obtained[$i]));
	}

	// echo "<br>".$decrypted_string;
	$original_string='';
	for($i=0;$i<2*$n3*strlen($string2);){
		$original_string.=$decrypted_string[$i];
		$i=$i+2;
	}
	for($i=2*$n3*strlen($string2);$i<2*$n3*strlen($string2)+2*$n4;){
		$original_string.=$decrypted_string[$i];
		$i=$i+2;
	}
	// echo "<br>".$original_string;
	return $original_string;
}


// echo "encrypted string is ".encryption("hello world","key@123!-")."<br>";

// echo "decrypted string is ".decryption(encryption("hello world","key@123!-"),"key@123!-",1,2);


?>
