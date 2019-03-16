 <?php
header("Content-type:text/html;charset=utf-8");
include '../config.php';
include '../com_fun.php';
?>

<?php
	$conn = create_();
	$sql = "SELECT blockname, blockID, info FROM ".BLK_TABLE;
	$result = $conn->query($sql);
	$arr = array();
	
	if ($result->num_rows > 0) {
		while($info = $result->fetch_assoc())
		{
			$item['name'] = $info['blockname'];
			$item['blockID'] = $info['blockID'];
			$item['info'] = $info['info'];
			$arr[] = $item;
		}
	} 
	$tip['statusCode'] = '0';
	$tip['result'] = $arr;
	echo json_encode($tip);
	$conn->close();
?>
