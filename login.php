<?php
session_start();
$cook = $_SESSION['username'];

// echo "<script> alert('$cook'); </script>";

echo "the zone: " . $_POST["select"];

header("Content-Type:text/html;charset=utf-8");
	if(isset($_POST["Submit"]) && $_POST["Submit"] == "登陆")
	{
		$user = $_POST["username"];
		$psw = $_POST["password"];
		if($user == "" || $psw == "")
		{
			echo "<script>alert('请输入用户名或密码！'); history.go(-1);</script>";
		}
		else
		{
			mysql_connect("localhost","root","12345678");
			mysql_select_db("bike");
			mysql_query("set names 'gbk'");
			$sql = "select username,passwd from user where username = '$_POST[username]' and passwd = '$_POST[password]'";
			$result = mysql_query($sql);
			$num = mysql_num_rows($result);
			if($num)
			{
				$row = mysql_fetch_array($result);	//将数据以索引方式储存在数组中
				echo $row[0];

				$_SESSION['username'] = $user;		//set session
				// $cook = $_SESSION['username'];

				// echo "<script> alert('$cook'); </script>";
				header("Location: ./index.html");

			}
			else
			{
				echo "<script>alert('用户名或密码不正确！');history.go(-1);</script>";
			}
		}
	}
	else
	{
		echo "<script>alert('提交未成功！'); history.go(-1);</script>";
	}

?>