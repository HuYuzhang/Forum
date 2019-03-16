 <?php
header("Content-type:text/html;charset=utf-8");
include '../config.php';
include '../com_fun.php';
?>

<?php
	$username = $_POST['username'];
	$page = $_POST['page'];
	$conn = create_();
	$sql = "SELECT identity FROM ".USR_TABLE." WHERE username = '$username' ";
	$result = $conn->query($sql);
	$tip['maxpage'] = '1';
	if ($result->num_rows > 0) {
		$info = $result->fetch_assoc();
		if($info['identity'] != "ADMIN")
		{	
			$tip["statusCode"] = '1';
			echo json_encode($tip);
			exit();
		}
	} 
	else {
		$tip["statusCode"] = '1';
		echo json_encode($tip);
		exit();
	} 
	$sql = "SELECT username, identity FROM ".USR_TABLE;
	$result = $conn->query($sql);
	$arr = array();
	
	if ($result->num_rows > 0) {
		while($info = $result->fetch_assoc())
		{
			$item['username'] = $info['username'];
			$item['identity'] = $info['identity'];
			$arr[] = $item;
		}
	} 
	$tip['statusCode'] = '0';
	$tip['userlist'] = $arr;
	echo json_encode($tip);
	$conn->close();
?>
