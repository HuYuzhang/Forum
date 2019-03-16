 <?php
header("Content-type:text/html;charset=utf-8");
include '../config.php';
include '../com_fun.php';
?>

<?php

	$blockID = $_POST['blockID'];
	$conn = create_();
	$sql = "SELECT postID,max(postTime) FROM ".POST_TABLE." WHERE blockID = '$blockID' ";
	$result = $conn->query($sql);
	$arr = array();
	$info = $result->fetch_assoc();
	$postID = $info['postID'];
	$tip['postID'] = $postID;
	$sql = "SELECT postername FROM ".RESPONSE_TABLE." WHERE postID='$postID' ";
	$post = $conn->query($sql);
	if ($post->num_rows > 0) { //帖子信息
		while($info = $post->fetch_assoc())
		{
			$arr[] = $info;
		}
	}
	else{
		$tip['statusCode'] = 1;
		echo json_encode($tip);
		$conn->close();
		exit();
	} 
	$tip['statusCode'] = '0';
	$tip['result'] = $arr;
	echo json_encode($tip);
	$conn->close();
?>
