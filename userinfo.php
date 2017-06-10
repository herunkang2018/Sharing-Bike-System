<?php 
header("Content-Type:text/html;charset=utf-8");
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>欢迎使用共享单车</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/normalize.css">
    <style>
        .container-small{
            max-width: 300px;
        }
        #p1{
            background: green;
        }
        #p2{
            font-size: 24px;
        }
        h1{
            text-align: center;
            margin: 30px 0;
        }
    </style>
</head>
<body>
<p id='p1'>power by Runking</p>

<?php 
if(isset($_SESSION["username"])){
	mysql_connect("localhost","root","12345678");
	mysql_select_db("bike");
	mysql_query("set names 'gbk'");
	$username = $_SESSION["username"];
	$newpasswd = 'hacker';
	//my money left
	$sql = "select money from user where username='$username' ";
	$result = mysql_query($sql);
	$num = mysql_num_rows($result);
	$row = mysql_fetch_array($result);
    if($row[0] > 20){
	   echo "<p id='p2' class='text-success' >My money left is :" .$row[0]."</p>";
    }else if($row[0] > 0){
       echo "<p id='p2' class='text-warning' >My money left is :" .$row[0]."</p>";
    }else{
       echo "<p id='p2' class='text-danger' >My money left is :" .$row[0]."</p>";
    }

}else{
	header("Location: ./loginew.html");
}
?>

<form class="container container-small" action="changepass.php" method="POST">
    <h1>修改密码</h1>
    <div class="well">
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon">旧密码</div>
                <input type="password" name="oldpass" class="form-control" placeholder="old password">
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon">新密码</div>
                <input type="password" name="newpass" class="form-control" placeholder="new password">
            </div>
        </div>
    </div>
    <button id="btn" name="submit" class="btn btn-primary btn-block" type="submit" value="submit">确认修改</button>
</form>

</body>
</html>