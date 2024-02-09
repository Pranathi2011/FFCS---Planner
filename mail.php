<?php
if(isset($_POST['smail'])){
$name=$_POST['name'];
$email=$_POST['email'];
$message=$_POST['message'];
$to = $email;
$subject = "Mail from ".$name;
$txt = $message;
$header = "From:abc@somedomain.com \r\n";
$header .= "Cc:afgh@somedomain.com \r\n";
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-type: text/html\r\n";

$m=mail($to,$subject,$txt,$header);

if($m==true){
	echo "Mail sent sucessfully";
}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Mail</title>
</head>
<body>
	<center>
	<form method="post">
		<input type="text" name="name" placeholder="name"><br><br>
		<input type="text" name="email" placeholder="email"><br><br>
		<input type="text" name="message" placeholder="message"><br><br>
		<button type="submit" name="smail">Send Mail</button>
	</form>
	</center>
</body>
</html>