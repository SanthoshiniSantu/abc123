<?php
	include 'conn.php';
	session_start();
	$requested_mail=$_POST['a'];
	$mail=$_SESSION['mail'];
	$all_messages=array();
	$messages=$conn->query("select message from messages where (sendmail='$mail' and recievedmail='$requested_mail') or (sendmail='$requested_mail' and recievedmail='$mail') order by date");
	for($i=0;$i<$messages->num_rows;$i++){
		$row=$messages->fetch_array(MYSQLI_NUM);
		array_push($all_messages, $row[0]);
	}
	echo json_encode($all_messages);


?>