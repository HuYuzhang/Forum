<?php
function create_()
{
	$servername = HOST;
	$username = USR;
	$password = PWD;
	$dbname = M_DB;

	// 创建连接
	$conn = new mysqli($servername, $username, $password, $dbname);
	// 检测连接
	if ($conn->connect_error) {
		die("连接失败: " . $conn->connect_error);
	}
	
	return $conn;
}

function checklog()
{
	$sessid;
	$tip;
	
	if(isset($_POST['token']))
		$sessid = $_POST['token'];
	else
	{
		$tip['status'] = 3;
		echo json_encode($tip);
		exit();
	}
	
	session_id($sessid);
	session_start();
	if(!isset($_SESSION['login']))
	{
		$tip['status'] = 4;
		echo json_encode($tip);
		exit();
	}
}

function vcode($num)
{
    $arr=array_merge(range('a','b'),range('A','B'),range('0','9'));
    shuffle($arr);
    $arr=array_flip($arr);
    $arr=array_rand($arr, $num);
    $res='';
    foreach ($arr as $v){
        $res.=$v;
    }
	return $res;
}
?>
