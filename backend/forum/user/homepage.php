<?php
header("Content-type:text/html;charset=utf-8");
include '../config.php';
include '../com_fun.php';
?>

<?php
	$username = $_POST['username'];
	
	$conn = create_();
	$sql = "SELECT nickname, birthday, gender, email, score, registerDate FROM ".USR_TABLE." WHERE username='$username' ";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
		$info = $result->fetch_assoc();
		$tip['statusCode'] = '0';
		$tip['nickname'] = $info['nickname'];
		$tip['birthday'] = $info['birthday'];
		$tip['gender'] = $info['gender'];
		$tip['email'] = $info['email'];
		$tip['score'] = $info['score'];
		$tip['signdate'] = $info['registerDate'];
	} 
	else {
		 $tip["statusCode"] = '1';
	} 
	
	echo json_encode($tip);
	
	$conn->close();
?>
