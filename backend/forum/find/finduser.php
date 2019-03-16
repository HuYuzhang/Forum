 <?php
header("Content-type:text/html;charset=utf-8");
include '../config.php';
include '../com_fun.php';
?>

<?php

	$blockID = $_POST['blockID'];
	$conn = create_();
	$sql = "SELECT postername FROM ".POST_TABLE." WHERE blockID = '$blockID' ";
	$result = $conn->query($sql);
	$arr = array();
	$user = array();
	$name = array();
	$index = 0;
	
	if ($result->num_rows > 0) {
		while($info = $result->fetch_assoc())
		{
			if(array_key_exists($info['postername'],$user))
				$user[$info['postername']] = $user[$info['postername']] + 1;
			else{
				$user[$info['postername']] = 1;
				$name[$index++] = $info['postername'];
			}
		}
	}
	rsort($user);
	foreach ($user as $key => $row) {
	 	$item['username'] = $name[$key];
	 	$item['posttime'] = $row;
	 	$arr[] = $item;
	}
	$tip['statusCode'] = '0';
	$tip['userlist'] = $arr;
	echo json_encode($tip);
	$conn->close();
?>
