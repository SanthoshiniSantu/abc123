<?php

	include 'enanddec.php';
 	$mail=encryption($_POST['a']);
 	
 	include 'conn.php';
 	$result=$conn->query("select * from users where email='$mail'");
	if($result->num_rows>0){
    echo json_encode("0");
	}
	else{
	    echo json_encode("1");
	}
exit();
?>