 <?php
header("Content-type:text/html;charset=utf-8");
include '../config.php';
include '../com_fun.php';
?>

<?php
	$tip;
	$blockID = $_POST['blockID'];
	$username = $_POST['username'];
	$information = $_POST['info'];
	$conn = create_();
	$sql = "SELECT identity FROM ".USR_TABLE." WHERE username = '$username' ";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$info = $result->fetch_assoc();
		if($info['identity'] != "ADMIN" && $info['identity'] != $blockID)
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
	
	$sql = "UPDATE ".BLK_TABLE." SET info = '$information' WHERE blockID = '$blockID' ";
	if ($conn->query($sql) === TRUE) {
		
		 $tip["statusCode"] = '0';
	} 
	else {
		
		 $tip["statusCode"] = '3';
	}
	
	echo json_encode($tip);
	
	$conn->close();
?>
