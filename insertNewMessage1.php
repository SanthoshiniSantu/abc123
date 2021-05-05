<?php
    include 'conn.php';
    include 'enanddec.php';
    session_start();
    $sender_mail=encryption($_SESSION['mail']);
    $receiver_mail=($_POST['a']);
    $message=encryption($_POST['b']);

    $now=date("Y/m/d H:i:s", strtotime("+330 minutes"));

    $insert=$conn->query("insert into messages (sendmail,recievedmail,message,date,seen) values ('$sender_mail','$receiver_mail','$message','$now','1')");
    if($insert){
        echo json_encode(1);
    }
    else
        echo json_encode(0);


?>