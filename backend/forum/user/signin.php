<?php
header("Content-type:text/html;charset=utf-8");
include '../config.php';
include '../com_fun.php';
?>

<?php
	$username = $_POST['username'];
	$pwd = $_POST['password'];
	
	$conn = create_();
	$sql = "SELECT username, password, identity, nickname FROM ".USR_TABLE." WHERE username='$username' ";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
		$info = $result->fetch_assoc();
		if($info['password'] == $pwd)
		{	
			$tip["statusCode"] = '0';
			$tip['nickname'] = $info['nickname'];
			$tip['identity'] = $info['identity'];
			
		}
		else
			$tip['statusCode'] = '2';
	} 
	else {
		 $tip["statusCode"] = '1';
	} 
	
	echo json_encode($tip);
	
	$conn->close();
?>
