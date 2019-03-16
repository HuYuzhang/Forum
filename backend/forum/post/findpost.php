 <?php
header("Content-type:text/html;charset=utf-8");
include '../config.php';
include '../com_fun.php';
?>

<?php
	$postID = $_POST['postID'];
	$page = $_POST['page'];

	$conn = create_();
	$sql = "SELECT blockID, postername, title, content, postTime, clickNum, responseNum FROM ".POST_TABLE." WHERE postID='$postID' ";
	$post = $conn->query($sql);
	if ($post->num_rows > 0) { //帖子信息
		while($info = $post->fetch_assoc())
		{
			$tip['blockID'] = $info['blockID'];
			$tip['username'] = $info['postername'];
			$tip['title'] = $info['title'];
			$tip['content'] = $info['content'];
			$tip['time'] = $info['postTime'];
			$click = $info['clickNum'] + 1;
			$tip['clickNum'] = $click;
			$tip['responseNum'] = $info['responseNum'];
			$tip['lastResponse'] = $info['postTime'];
			$sql1 = "UPDATE ".POST_TABLE." SET clickNum = '$click' WHERE postID='$postID' ";
			$conn->query($sql1);
		}
	}
	else{ //帖子不存在
		$tip['statusCode'] = '1';
		echo json_encode($tip);
		$conn->close();
		exit();
	} 
	$sql = "SELECT floor, postername, content, responseTime, likeNum FROM ".RESPONSE_TABLE." WHERE postID='$postID' ";
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
				$item['floor'] = $info['floor'];
				$item['username'] = $info['postername'];
				$item['content'] = $info['content'];
				$item['time'] = $info['responseTime'];
				$item['likeNum'] = $info['likeNum'];
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
	$tip['statusCode'] = '0';
	$tip['responseList'] = $arr;
	echo json_encode($tip);
	$conn->close();
?>
