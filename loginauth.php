<?php

	include 'enanddec.php';
 	$mail=encryption(strtolower($_POST['a']));
 	$password=encryption(md5($_POST['b']));
 	include 'conn.php';
    
	if(strlen($password)==0 ){
        echo json_encode(0);
	}
    else{
	    $result=$conn->query("select * from users where mail='$mail' and password='$password'");
	    if($result->num_rows>0){
	    	session_start();
	    	$_SESSION['mail']=decryption($mail);
	        echo json_encode(1);
	    }
	    else
	        echo json_encode(0);
    }
exit();
?>