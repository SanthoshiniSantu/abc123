<?php
	include 'conn.php';
	include 'enanddec.php';
	session_start();
	$requested_mail=encryption($_POST['a']);
	$mail=encryption($_SESSION['mail']);

	// $requested_mail='harsha@gmail.com';

	$all_messages=array();

	$sent_messages_time=array();
	$received_messages_time=array();


	// update unread mesages to read messages
	$update_unread_messages=$conn->query("update messages set seen=0 where sendmail='$requested_mail' and recievedmail='$mail' and seen='1'");

	$messages_sent=$conn->query("select date from messages where sendmail='$mail' and recievedmail='$requested_mail' order by date");
	for($i=0;$i<$messages_sent->num_rows;$i++){
		$row=$messages_sent->fetch_array(MYSQLI_NUM);
		array_push($sent_messages_time, $row[0]);
	}

	$messages_received=$conn->query("select date from messages where recievedmail='$mail' and sendmail='$requested_mail' order by date");
	for($i=0;$i<$messages_received->num_rows;$i++){
		$row=$messages_received->fetch_array(MYSQLI_NUM);
		array_push($received_messages_time, $row[0]);
	}

	$count=0;


	$count1=$messages_sent->num_rows;
	$count2=$messages_received->num_rows;

	$total_rows=$count1+$count2;
	$i=0;
	$j=0;
	while($count<$total_rows){

		$n=0;
		$m=0;
		if($i<$count1 && $j<$count2){
			if($sent_messages_time[$i]<$received_messages_time[$j]){
				// echo $sent_messages_time[$i]." sended it<br>";
				$n=1;
				// $i++;
			}
			else{
				// echo $received_messages_time[$j]." received it<br>";
				$m=1;
				// $j++;
			}
		}
		elseif ($i<$count1) {
			// echo $sent_messages_time[$i]." sended it<br>";
			$n=1;
			// $i++;
		}
		elseif ($j<$count2) {
			// echo $received_messages_time[$j]." received it<br>";
			$m=1;
			// $j++;
		}
		if($n==1){
			$messages_sent_in_particular_date=$conn->query("select message from messages where sendmail='$mail' and recievedmail='$requested_mail' and date='$sent_messages_time[$i]'")->fetch_array(MYSQLI_NUM);

			array_push($all_messages, "@".decryption($messages_sent_in_particular_date[0]));
			$i++;
		}
		elseif ($m==1) {
			$messages_received_in_particular_date=$conn->query("select message from messages where recievedmail='$mail' and sendmail='$requested_mail' and date='$received_messages_time[$j]'")->fetch_array(MYSQLI_NUM);
			array_push($all_messages, "!".decryption($messages_received_in_particular_date[0]));
			$j++;
		}

		$count++;
	}

	// print_r($all_messages);
	// echo json_encode($all_messages);
	$all_messages = array_values($all_messages);
	$combine_all_messages=join(",,",$all_messages);
	echo json_encode($combine_all_messages);



?>