<?php

	session_start();
	include 'enanddec.php';
	$mailid=encryption($_SESSION['mail']);
	include 'conn.php';
	$total_chats=array();
	$total_messages_received=$conn->query("select * from messages where recievedmail='$mailid' order by date desc");
	for($i=0;$i<$total_messages_received->num_rows;$i++){
		$rows=$total_messages_received->fetch_array(MYSQLI_NUM);
		array_push($total_chats, $rows[1]);
		// echo $rows[1]." ".$rows[2]." ".$rows[3]."</br>";
	}
	$total_messages_sent=$conn->query("select * from messages where sendmail='$mailid' order by date desc");
	for($i=0;$i<$total_messages_sent->num_rows;$i++){
		$rows=$total_messages_sent->fetch_array(MYSQLI_NUM);
		array_push($total_chats, $rows[2]);
		// echo $rows[1]." ".$rows[2]." ".$rows[3]."</br>";
		}
	
	$final_total_chats=array_unique($total_chats);
	$all_contacts=array();
	// print_r($final_total_chats);
	foreach($final_total_chats as $j){
		$notification_count=$conn->query("select * from messages where sendmail='$j' and recievedmail='$mailid' and seen='1'")->num_rows;
		// array_push($all_contacts, $notification_count);
		$all_contacts[decryption($j)]=$notification_count;
	}
	// print_r($all_contacts);
	echo json_encode($all_contacts);
?>
	