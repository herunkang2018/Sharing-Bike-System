<?php 
header("Content-Type:text/html;charset=utf-8");
session_start();

if(isset($_SESSION["username"])){
	mysql_connect("localhost","root","12345678");
	mysql_select_db("bike");
	mysql_query("set names 'gbk'");
	$username = $_SESSION["username"];
	$money = $_POST["money"];

	//log the billing
	$sql = "insert into billing(username,money,btime) values('$username', '$money', now())";
	mysql_query($sql);


	//change the user money
	$sql = "update user set money=money+'$money' where username='$username'";
	mysql_query($sql);

	header("Location: ./billinfo.html");


//transaction
}else{
	header("Location: ./login.html");
}

?>