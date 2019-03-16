 <?php
header("Content-type:text/html;charset=utf-8");
include '../config.php';
include '../com_fun.php';
?>

<?php
	$blockID = $_POST['blockID'];
	$page = $_POST['page'];

	$conn = create_();
	$sql = "SELECT postID, blockID, title FROM ".POST_TABLE." WHERE blockID='$blockID' ";
	$result = $conn->query($sql);
	$arr = array();
	$max = ceil($result->num_rows / ITEM_NUM);
	$i = 0;
	$page_i = 0;
	$tip['maxpage'] = $max;
	if ($page > $max){
		$tip['statusCode'] = '3';
		echo json_encode($tip);
		$conn->close();
		exit();
	}
	if ($result->num_rows > 0) {
		while($info = $result->fetch_assoc())
		{
			if ($page_i == $page){
				$item['title'] = $info['title'];
				$item['postID'] = $info['postID'];
				$arr[] = $item;
			}
			if ($page_i > $page) {break;}
			$i = $i+1;
			if ($i == ITEM_NUM){
				$page_i = $page_i+1;
				$i = 0;
			}
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
