<?php
header("Content-Type:text/html;charset=utf-8");
session_start();

if(isset($_SESSION["username"])){
	mysql_connect("localhost","root","12345678");
	mysql_select_db("bike");
	mysql_query("set names 'gbk'");

	$bikeid=$_GET["bikeid"];

	$sql = "select flag from bike where id = '$bikeid' ";
	// $sql = "insert into bike(passwd, flag, typeid, xpos, ypos) values('112233','1','09',67,34)";
	$result = mysql_query($sql);
	$num = mysql_num_rows($result);

	if($num){
		for($i = 0; $i < $num; $i++){
			$row = mysql_fetch_array($result);
			if($row[0] == '0'){
				$response= "Available NOW!";
			}else{
				$response="The bike has been tooken already!";
			}
		}
	}else{
		$response = "Bikeid is invalid!";
	}

	//输出返回值
	echo $response;
}else{
	header("Location: ./login.html");
}
?>