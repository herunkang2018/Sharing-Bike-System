<?php
header("Content-Type:text/html;charset=utf-8");
session_start();
if(isset($_SESSION["username"])){
	mysql_connect("localhost","root","12345678");
	mysql_select_db("bike");
	mysql_query("set names 'gbk'");

	$range=$_GET["range"];
	$xpos=$_GET["xpos"];
	$ypos=$_GET["ypos"];

	// echo $range.$xpos.$ypos;

	$sql = "select id,xpos,ypos from bike where flag='0' ";
	// $sql = "insert into bike(passwd, flag, typeid, xpos, ypos) values('112233','1','09',67,34)";
	$result = mysql_query($sql);
	$num = mysql_num_rows($result);

	if($num){
		$response = array();

		for($i = 0; $i < $num; $i++){
			$row = mysql_fetch_array($result);
			// $response = $response . "bikeid:".$row[0]." xpos: ".$row[1]." ypos: ".$row[2];
			// $response = $response .$row[0].$row[1].$row[2];
			
			$count = ($xpos - $row[1])*($xpos - $row[1]) + ($ypos - $row[2])*($ypos - $row[2]);
			if($count < $range*$range){
				array_push($response, $row);
			}
		}
		$response = json_encode($response);
	}else{
		$response = "no bike avaliable!";
	}
}else{
	header("Location: ./login.html");

}
echo $response;
?>