 <?php
header("Content-type:text/html;charset=utf-8");
include '../config.php';
include '../com_fun.php';
?>

<?php
	$postID = $_POST['postID'];
	$floor = $_POST['floor'];

	$conn = create_();
	$sql = "SELECT likeNum FROM ".RESPONSE_TABLE." WHERE postID='$postID' AND floor='$floor' ";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($info = $result->fetch_assoc())
		{
			$like = $info['likeNum'] + 1;
			$tip['likeNum'] = $like;
		}
	}
	$sql = "UPDATE ".RESPONSE_TABLE." SET likeNum = '$like' WHERE postID='$postID' AND floor='$floor' ";
	if ($conn->query($sql) === TRUE) {
		
		 $tip["statusCode"] = '0';
	} 
	else {
		
		 $tip["statusCode"] = '1';
	}
	echo json_encode($tip);
	$conn->close();
?>
