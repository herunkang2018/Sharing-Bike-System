<?php 
header("Content-Type:text/html;charset=utf-8");
session_start();

//insert into bike(passwd, flag, typeid, xpos, ypos) values("112233",'1','09',23,34);

mysql_connect("localhost","root","12345678");
mysql_select_db("bike");
mysql_query("set names 'gbk'");
$bikeid = 2;
$sql = "select flag from bike where id = '$bikeid' ";
// $sql = "insert into bike(passwd, flag, typeid, xpos, ypos) values('112233','1','09',67,34)";
echo "test";
$result = mysql_query($sql);
echo "test";
$num = mysql_num_rows($result);
var_dump($num);

echo "<br>";
for($i = 0; $i < $num; $i++){
	$row = mysql_fetch_array($result);
	if($row[0] == '0'){
		echo " use it ";
	}
}


?>