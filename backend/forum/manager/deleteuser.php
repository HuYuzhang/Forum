<?php
header("Content-type:text/html;charset=utf-8");
include '../config.php';
include '../com_fun.php';
?>

<?php
	$username = $_POST['username'];
	$targetname = $_POST['targetname'];
	
	$conn = create_();
	$sql = "SELECT identity FROM ".USR_TABLE." WHERE username = '$username' ";
	$result = $conn->query($sql);
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
	$sql = "DELETE FROM ".USR_TABLE." WHERE username = '$targetname' ";
	$result = $conn->query($sql);
	if ($conn->query($sql) === TRUE) {
		
		 $tip["statusCode"] = '0';
	} 
	else {
		 $tip["statusCode"] = '2';
	}
	
	echo json_encode($tip);
	
	$conn->close();
?>
