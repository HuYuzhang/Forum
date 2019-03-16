 <?php
header("Content-type:text/html;charset=utf-8");
include '../config.php';
include '../com_fun.php';
?>

<?php
	$tip;
	$username = $_POST['username'];
	$blockID = $_POST['blockID'];
	$title = $_POST['title'];
	$content = $_POST['content'];
	$conn = create_();
	
	
	$sql = "INSERT INTO ".POST_TABLE." (postername,blockID,title,content) 
	VALUES ('$username', '$blockID', '$title', '$content')";
	
	if ($conn->query($sql) === TRUE) {
		 $tip["statusCode"] = '0';
		 $sql = "SELECT postID FROM ".POST_TABLE." WHERE postername = '$username' AND title = '$title' ";
		 $post = $conn->query($sql);
		if ($post->num_rows > 0) { //帖子信息
			while($info = $post->fetch_assoc())
			{
				$tip['postID'] = $info['postID'];
			}
		}
	} 
	else {
		
		 $tip["statusCode"] = '1';
	} 
	echo json_encode($tip);
	
	$conn->close();
?>
