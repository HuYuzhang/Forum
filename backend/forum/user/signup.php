 <?php
header("Content-type:text/html;charset=utf-8");
include '../config.php';
include '../com_fun.php';
?>

<?php
	$tip;
	$username = $_POST['username'];
	$pwd = $_POST['password'];
	$birthday = $_POST['birthday'];
	$nickname = $_POST['nickname'];
	$gender = $_POST['gender'];
	$email = $_POST['email'];

	$conn = create_();
	
	
	$sql = "INSERT INTO ".USR_TABLE." (username, nickname, birthday, password, gender, email, score) 
	VALUES ('$username', '$nickname', '$birthday', '$pwd', '$gender', '$email', 0)";
	
	if ($conn->query($sql) === TRUE) {
		
		 $tip["statusCode"] = '0';
	} 
	else {
		
		 $tip["statusCode"] = '1';
	} 
	
	echo json_encode($tip);
	
	$conn->close();
?>
