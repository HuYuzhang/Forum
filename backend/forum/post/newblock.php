 <?php
header("Content-type:text/html;charset=utf-8");
include '../config.php';
include '../com_fun.php';
?>

<?php
	$tip;
	$blockname = $_POST['blockname'];
	$info = $_POST['info'];
	$conn = create_();
	
	
	$sql = "INSERT INTO ".BLK_TABLE." (blockname,info) 
	VALUES ('$blockname', '$info')";
	
	if ($conn->query($sql) === TRUE) {
		
		 $tip["statusCode"] = '0';
	} 
	else {
		
		 $tip["statusCode"] = '1';
	} 
	
	echo json_encode($tip);
	
	$conn->close();
?>
