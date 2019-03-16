 <?php
header("Content-type:text/html;charset=utf-8");
include '../config.php';
include '../com_fun.php';
?>

<?php
	$tip;
	$floor;
	$username = $_POST['username'];
	$postID = $_POST['postID'];
	$content = $_POST['content'];
	$conn = create_();

	$sql = "SELECT responseNum FROM ".POST_TABLE." WHERE postID = '$postID' ";
	$post = $conn->query($sql);
	if ($post->num_rows > 0) { //帖子信息
		while($info = $post->fetch_assoc())
		{
			$floor = $info['responseNum']+1;
			$tip['page'] = $floor;
			$sql1 = "UPDATE ".POST_TABLE." SET responseNum = '$floor' WHERE postID='$postID' ";
			$conn->query($sql1);
		}
		$sql = "INSERT INTO ".RESPONSE_TABLE." (postername,postID,content,floor) 
		VALUES ('$username', '$postID', '$content', '$floor')";
		
		if ($conn->query($sql) === TRUE) {
			$tip["statusCode"] = '0';
			
		} 
		else {
			$tip["statusCode"] = '1';
		} 
	}
	else{
		$tip['statusCode'] = '2';
	}
	
	
	
	echo json_encode($tip);
	
	$conn->close();
?>
