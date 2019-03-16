 <?php
header("Content-type:text/html;charset=utf-8");
include '../config.php';
include '../com_fun.php';
?>

<?php

	$conn = create_();
	$sql = "SELECT postID, blockID, responseNum, title FROM ".POST_TABLE." ORDER BY responseNum DESC LIMIT 10";
	$result = $conn->query($sql);
	$arr = array();
	if ($result->num_rows > 0) {
		while($info = $result->fetch_assoc())
		{
			
			$item['title'] = $info['title'];
			$item['postID'] = $info['postID'];
			$item['blockID'] = $info['blockID'];
			$item['responseNum'] = $info['responseNum'];
			$arr[] = $item;
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
