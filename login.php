<?php

session_start();
if(array_key_exists('mail',$_SESSION)){ 
    header('Location:index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>SignIn | SignUp Page</title>
  <link rel="stylesheet" href="./style.css">

</head>
<body>
<!-- partial:index.partial.html -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
    integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf"
    crossorigin="anonymous">
<script type="text/javascript">
    function validate(signup_form){
        var name=document.getElementById('name').value;
        var email=document.getElementById('email').value;
        var pass=document.getElementById('password').value;
        var cpass=document.getElementById('cpassword').value;
        var string="Password must contain";
        var k=0,r=0;
        name=name.trim(); 

        var check1=new RegExp("[a-zA-Z ]","g");
        var check=new RegExp("[a-zA-Z0-9]@[a-z]{3,}\.[a-z]{2,}","g");
        if(name.length==0){
             document.getElementById("uname1").innerHTML="Enter Your Name";
             k=1;
        }
        else if(!name.match(check1)){
            document.getElementById("uname1").innerHTML="Enter Characters Name";
             k=1;
        }
        else
        document.getElementById("uname1").innerHTML="";
        
       
        if(email.length==0){
             document.getElementById("emailid1").innerHTML="Enter EmailID";
             k=1;
         }
        else if(!email.match(check))
        {
            document.getElementById("emailid1").innerHTML="Enter a Correct Mail";
            k=1;
        }
        else{
            document.getElementById("emailid1").innerHTML="";
        }
        if(pass.length==0){
             document.getElementById("pass1").innerHTML="Enter Password";
             k=1;
             r=1;
        }
        else
            document.getElementById("pass1").innerHTML="";
        if(cpass.length==0){
            document.getElementById("cpass1").innerHTML="Enter Confirm Password";
            k=1;
        }
        else
            document.getElementById("cpass1").innerHTML="";
        var c=0,s=0,n=0,sym=0,i;
        for(i=0;i<pass.length;i++)
        {
            var ass = pass.charCodeAt(i);
            if(ass>=58 && ass<=64)
            sym=1;
            if(ass<=47)
            {
                sym=1;
            }
            else if(ass>=48 && ass<=57)
            {
                n=1;
            }
            else if(ass>=65 && ass<=90)
            {
                c=1;
            }
            else if(ass>=97 && ass<=122)
            {
                s=1;
            }

        }
        if(c==0){
            string=string+" 1 Capital letter";
        // document.getElementById("pass1").innerHTML="Password must contain atleast one Capital letter";
        k=1;
        }
        if(s==0){
            string=string+" 1 Small letter";
        // document.getElementById("pass1").innerHTML="Password must contain atleast one Small letter";
        k=1;
        }
        if(n==0){
            string = string+" 1 number";
        // document.getElementById("pass1").innerHTML="Password must contain atleast one Number";
        k=1;
        }
        if(sym==0){
            string = string+" 1 symbol";
        // document.getElementById("pass1").innerHTML="Password must contain atleast one Symbol letter";
        k=1;
        }
        if(string.length>21 && r==0){
            document.getElementById("pass1").innerHTML=string;
        }
        else if(r==0)
        document.getElementById("pass1").innerHTML="";
        
        if(pass!=cpass){
            document.getElementById("cpass1").innerHTML="Password and Confrom Password should be same";
            k=1;
        }
        else if(pass.length>0)
            document.getElementById("cpass1").innerHTML="";
        if(k==1){
            return false;
        }
        return true;
    }
</script>


<script type="text/javascript">
    function auth(form1){
        var mail=document.getElementById('sign_in_mail').value;
        var pass=document.getElementById('sign_in_pass').value;
        $.ajax({
                type: "POST",
                url: "loginauth.php",
                data: ({a:mail,b:pass}),
                dataType: "html",
                success: function(responseText){
                // alert(responseText);
                if(responseText==0)
                    document.getElementById('incorrect').innerHTML="Incorrect Details";
                else{
                    document.getElementById('incorrect').innerHTML="";
                    window.location="index.php";
                }
                
            }
        });
        return false;
    }
</script>

<div class="container" id="container">
        <div class="form-container sign-up-container">
            <form name="signup_form" action="InsertUserDetails.php"  method="post">
                <h1>Create Account</h1>
                <!-- <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                    <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                </div> -->
                <!-- <span>or use your email for registration</span> -->
                <input type="text" placeholder="Name" name="name" id="name" />
                <span id="uname1"></span>
                <input type="email" placeholder="Email" name="email" id="email" />
                <span id="emailid1"></span>
                <input type="password" placeholder="Password" name="password" id="password" />
                <span id="pass1"></span>
                <input type="password" placeholder="Conform Password" name="cpassword" id="cpassword" />
                <span id="cpass1"></span>
                <button onclick="return validate(this)">Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form name="form1" method="post">
                <h1>Sign in</h1>
                <!-- <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                    <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <span>or use your account</span> -->
                <input type="email" placeholder="Email" name="sign_in_mail" id="sign_in_mail" />
                <input type="password" placeholder="Password" name="sign_in_pass" id="sign_in_pass" />
                <!-- <a href="#">Forgot your password?</a> -->
                <span id="incorrect"></span>
                <button onclick="return auth(this);">Sign In</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

<!-- <div class="footer">
<b>	Follow me on </b>
	<div class="icons">
		<a href="https://github.com/kvaibhav01" target="_blank" class="social"><i class="fab fa-github"></i></a>
		<a href="https://www.instagram.com/vaibhavkhulbe143/" target="_blank" class="social"><i class="fab fa-instagram"></i></a>
		<a href="https://medium.com/@vaibhavkhulbe" target="_blank" class="social"><i class="fab fa-medium"></i></a>
		<a href="https://twitter.com/vaibhav_khulbe" target="_blank" class="social"><i class="fab fa-twitter-square"></i></a>
		<a href="https://linkedin.com/in/vaibhav-khulbe/" target="_blank" class="social"><i class="fab fa-linkedin"></i></a>
		</div>
	</div> 
</div>-->
<!-- partial -->
  <script  src="./script.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</body>
</html>
