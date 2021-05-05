<?php
include 'enanddec.php';
session_start();
$mailid=encryption($_SESSION['mail']);
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
	<link rel="stylesheet" href= "https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<script type="text/javascript">

	function send_message1(email){
		// alert(email);
		var message=document.getElementById('send_message').value;
		$.ajax({
			type: "POST",
			url: "insertNewMessage.php",
			data: ({a:email,b:message}),
			dataType: "html",
			success: function(responseText){
				// alert(responseText);
				get_data(email);
			}
		});
		return false;
	}
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
                var response=responseText.split(',,');
                // alert(response);
                var string=``;
                string+=`<div style="max-height: 500px; overflow-x: hidden;" id='overall_chat'>`;
                for(var i=0;i<response.length;i++){

                	var dup;
                	if(i==0 && i==response.length-1){
                		dup=response[i].trim();
                		dup=dup.slice(1,-1);
                	}
                	else if(i==0){
                		dup=response[i].trim();
                		dup=dup.slice(1);
                	}
                	else if(i==response.length-1)
                		dup=response[i].slice(0,-1);
                	else
                		dup=response[i];
                	// alert(dup);
                	if(dup[0]=='@'){
                		string+=`<div class='row' >
                					<div class='col-6 col-md-6'></div>
                					<div class='col-6 col-md-6'>
                						<div class='float-right' style='margin-right:20px;'>
                					`+dup.slice(1)+`</div></div></div>`;
                	}
                	else if(dup[0]=='!'){
                		string+=`<div class='row'>
                					<div class='col-6 col-md-6' style='margin-left:20px;'>`+dup.slice(1)+`</div>
                					<div class='col-5 col-md-5'></div></div>`;
                	}
                	string+=`<hr>`;
                	// string+=response[i].slice(1,-1)+`<hr>`;
                	
                }
                string+=`</div>`;

                // alert(string);
                string+=`<div class='row'>
            				<div class='col-9 col-md-11'>
            					<input type='text' name='send_message' id='send_message' class='form-control'  style='border-radius:15px;' placeholder='Send New Message'>
            				</div>
            				<div class='col-3 col-md-1'>
            					<button class='btn btn-info btn-md'  
            					onclick='send_message1("`+emailid+`");'>Send</button>
            				</div>
            			</div>
            				`
                document.getElementById('taken_data').innerHTML=string;
                var objDiv = document.getElementById("overall_chat");
				objDiv.scrollTop = objDiv.scrollHeight;
                getAllContacts();
                
            }
        });
        return false;
	}
	function message(){
		var mailid=document.getElementById('receiver_mail').value;
		var message=document.getElementById('message_sent').value;
		var modal_dialog=document.getElementById('myModal');
		// var encrypted_emailid= document.getElementById('encrypted_emailid').value;
		// alert(encrypted_emailid);
		// alert(mailid);
		$.ajax({
                type: "POST",
                url: "insertNewMessage.php",
                data: ({a:mailid,b:message}),
                dataType: "json",
                success: function(responseText) {
                // alret(responseText.slice(1,-1));
        		document.getElementById('myModal').style.display="none";
                get_data(mailid);
        		// document.getElementById('body').style.background-color="#fff";
        		$('.modal-backdrop').remove();
                // location.reload();
            }
        });
        return false;
	}
	function logout(){
		window.location='logout.php';
	}
	function getAllContacts(){

		$.ajax({
			type: "POST",
			url: "getAllContacts.php",
			dataType: "json",
			success: function(responseText){
				// alert(responseText);
				// get_data(email);
				string1=``;
				for( var prop in responseText ){
				    // alert( responseText[prop]+ " "+ prop );
				    string1+=`<tr><td>
								<span><img src="profile_default.png" style="border-radius: 50%" width="30" height="30"></span>
								<a href="#" onclick="get_data('`+prop+`')">`+prop+`</a>`;
					if(responseText[prop]>0){
						string1+=`<span class="float-right" style="border: 1px solid red; background-color: yellow; border-radius: 50%;padding: 5px 10px 7px 10px;">`+responseText[prop]+`</span>
							</td></tr>`;
					}

				}
				document.getElementById('get_All_Contacts').innerHTML=string1;
			}
		});
		return false;

	}
	getAllContacts();

</script>
<body style="overflow-x: hidden;" id="body">
	<input type="hidden" name="encrypted_emailid" id="encrypted_emailid" value="<?php echo $mailid; ?>">
	<div  style="margin-top: 50px;">
		<div class="row">
			<div class=" col-md-6"></div>
			<div class="col-4 col-md-2" style="text-align: center; align-items: center;align-content: center;"><?php echo decryption($mailid); ?></div>
			<div class="col-4 col-md-2">
				<button type="button" class="btn btn-info btn-lg right" data-toggle="modal" data-target="#myModal">New Message</button>
			</div>
			<div class="col-4 col-md-2">
				<button type="button" class="btn btn-danger btn-lg right" onclick="logout();">Logout</button>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-6 col-md-3" style="max-height: 600px;">
				<div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="bg-primary text-white float-center">
                            <th class="subtitle text-white" style="text-align: center;">Chats</th>
                        </thead>
                        <tbody id="get_All_Contacts">
						</tbody>
					</table>
					
				</div>

			</div>
			<div class="col-6 col-md-8" >
				<div class="table-responsive" style="overflow-x: hidden;">
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="bg-primary text-white float-center">
                            <th class="subtitle text-white" style="text-align: center;">Messages</th>
                        </thead>
                        <tbody>
                        	<tr>
								<td id="taken_data"></td>
							</tr>
						</tbody>
					</table>
			</div>
		</div>
	</div>


  <!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      	<div class="modal-content">
	        <div class="modal-header">

	          	<h3 class="modal-title" style="text-align: center;">Start New Chat</h3>
	          	<button type="button" class="close" data-dismiss="modal">&times;</button>
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
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>


</body> 