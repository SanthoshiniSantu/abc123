<?php

session_start();
$mailid=$_SESSION['mail'];
// echo $mailid;
if(!array_key_exists('mail',$_SESSION)){ 
    header('Location:login.php');
    exit();
}


include 'conn.php';
$row=$conn->query("select * from users where mail='$mailid'")->fetch_array(MYSQLI_NUM);
// echo $row[1];



?>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  	<!-- <link rel="stylesheet" href="./style.css"> -->
</head>
<script type="text/javascript">
	function get_data(emailid){
		// alert(emailid);
		$.ajax({
                type: "POST",
                url: "getChats1.php",
                data: ({a:emailid}),
                dataType: "html",
                success: function(responseText) {
                // alert(responseText);
                var response1=responseText.slice(1,-1);
                var response=response1.split(",");
                // alert(response);
                var string=``;
                for(var i=0;i<response.length;i++){

                	var dup=response[i].slice(1,-1);
                	if(dup[0]=='@'){
                		string+=`<div class='row'>
                					<div class='col-6 col-md-6'></div>
                					<div class='col-6 col-md-6'>`+dup.slice(1)+`</div></div>`;
                	}
                	else if(dup[0]=='!'){
                		string+=`<div class='row'>
                					<div class='col-1 col-md-1'></div>
                					<div class='col-6 col-md-6'>`+dup.slice(1)+`</div>
                					<div class='col-5 col-md-5'></div></div>`;
                	}
                	string+=`<hr>`;
                	// string+=response[i].slice(1,-1)+`<hr>`;
                }
                // alert(string);
                document.getElementById('taken_data').innerHTML=string;
                
                
            }
        });
        return false;
	}
	function message(){
		var mailid=document.getElementById('receiver_mail').value;
		var message=document.getElementById('message_sent').value;
		// alert(mailid);
		$.ajax({
                type: "POST",
                url: "insertNewMessage.php",
                data: ({a:mailid,b:message}),
                dataType: "html",
                success: function(responseText) {
                // alret(responseText);
                location.reload();
            }
        });
        return false;
	}
	function logout(){
		window.location='logout.php';
	}
</script>
<body>
	<div  style="margin-top: 50px;">
		<div class="row">
			<div class=" col-md-6"></div>
			<div class="col-4 col-md-2" style="text-align: center; align-items: center;align-content: center;"><?php echo $mailid; ?></div>
			<div class="col-4 col-md-2">
				<button type="button" class="btn btn-info btn-lg right" data-toggle="modal" data-target="#myModal">New Message</button>
			</div>
			<div class="col-4 col-md-2">
				<button type="button" class="btn btn-danger btn-lg right" onclick="logout();">Logout</button>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-6 col-md-3">
				<div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="bg-primary text-white float-center">
                            <th class="subtitle text-white" style="text-align: center;">Chats</th>
                        </thead>
                        <tbody>
								
						<?php
							$total_chats=array();
							$total_messages_sent=$conn->query("select * from messages where sendmail='$mailid'");
							for($i=0;$i<$total_messages_sent->num_rows;$i++){
								$rows=$total_messages_sent->fetch_array(MYSQLI_NUM);
								array_push($total_chats, $rows[2]);
								// echo $rows[1]." ".$rows[2]." ".$rows[3]."</br>";
								}
							$total_messages_received=$conn->query("select * from messages where recievedmail='$mailid'");
							for($i=0;$i<$total_messages_received->num_rows;$i++){
								$rows=$total_messages_received->fetch_array(MYSQLI_NUM);
								array_push($total_chats, $rows[1]);
								// echo $rows[1]." ".$rows[2]." ".$rows[3]."</br>";
							}
							$final_total_chats=array_unique($total_chats);

							// print_r($final_total_chats);
							foreach($final_total_chats as $j){
								// $user_details=$conn->query("select * from users where mail='$final_total_chats[$j]'")->fetch_array(MYSQLI_NUM);
							?>
							<tr><td>
								<a href="#" onclick="get_data(`<?php echo $j; ?>`)"><?php echo $j; ?></a>
							</td></tr>
								<?php
									}
								?>
							</tbody></table>
					
				</div>

			</div>
			<div class="col-6 col-md-3">
				<div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="bg-primary text-white float-center">
                            <th class="subtitle text-white" style="text-align: center;">Messages</th>
                        </thead>
                        <tbody>
                        	<tr>
				<td id="taken_data"></td></tr></tbody></table>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>


  <!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      	<div class="modal-content">
	        <div class="modal-header">
	          	<button type="button" class="close" data-dismiss="modal">&times;</button>
	          	<h4 class="modal-title" style="text-align: center">Start New Chat</h4>
	        </div>
	        <div class="modal-body">
	        	<form name="message_form" method="post">
		        	<input class="form-control" type="email" name="receiver_mail" id="receiver_mail" placeholder="Enter Receiver Mail Id"><br>
		        	<textarea class="form-control" name="message_sent" id="message_sent" placeholder="Enter Message Here"></textarea><br>
		        	<center><button class="btn btn-success btn-lg" onclick="return message();">Send</button></center>
		        </form>
	        </div>
      	</div>
      
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


</body> 