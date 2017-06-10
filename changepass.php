<?php 
header("Content-Type:text/html;charset=utf-8");
session_start();

if(isset($_SESSION["username"])){
	mysql_connect("localhost","root","12345678");
	mysql_select_db("bike");
	mysql_query("set names 'gbk'");
	$username = $_SESSION["username"];
	$oldpasswd = $_POST["oldpass"];
	$newpasswd = $_POST["newpass"];

	//compare the passwd
	$sql = "select passwd from user where username='$username' ";
	$result = mysql_query($sql);
	$num = mysql_num_rows($result);
	$row = mysql_fetch_array($result);
	if($row[0] === $oldpasswd){
		$sql = "update user set passwd='$newpasswd' where username='$username' ";
		mysql_query($sql);
		header("Location: ./index.html");
	}else{
		echo "<script> history.go(-1); </script>";
	}
}else{
	header("Location: ./login.html");
}
?>