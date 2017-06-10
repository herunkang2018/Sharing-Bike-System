
<!DOCTYPE html>
<html>
<head>
    <title>欢迎使用共享单车</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/normalize.css">
    <style type="text/css">
        div.content{
            font-size: 15px;
        }
        #div1{
            text-align: center;
        }
        #p1{
            background: green;
        }
        #p2{
        	margin-top: 40px;
        }
    </style>
</head>
<body>
<p id="p1">power by Runking</p>
<?php
header("Content-Type:text/html;charset=utf-8");
session_start();

mysql_connect("localhost","root","12345678");
mysql_select_db("bike");
mysql_query("set names 'gbk'");
 // echo $_POST["enduse"];
if(isset($_POST["enduse"]) && $_POST["enduse"] == 'enduse' && isset($_SESSION["username"])){

	//get the end position
	$endxpos = $_POST["endxpos"];
	$endypos = $_POST["endypos"];
	$select = $_POST["select"];

	//find the current using bike from the user(one)
	$username = $_SESSION["username"];
	// $bikeid = $_POST["bikeid"];
	$sql = "select tid,bikeid from trans where username='$username' and etime IS NULL";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$tid = $row[0];	//get tid
	$bikeid = $row[1];

	//update the end use time
	$sql = "update trans set etime=now(), expos='$endxpos', eypos='$endypos'  where tid='$tid' ";
	mysql_query($sql);


	//get the use time
	$sql = "select unix_timestamp(etime)-unix_timestamp(stime) from trans where tid='$tid'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$usetime = $row[0];
	$hour = intval(floor($usetime/3600));
	$yushu = $usetime%3600;

	//get the price
	$sql="select price from bike,type where type.typeid=bike.typeid and id='$bikeid' ";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$price = $row[0];

	if($yushu !== 0){
		$hour = $hour + 1;
	}
	echo "<div id='div1' ><p id='p2' class='text-success'>"."总消费时间:".$hour."小时</p>";

$transpay = $hour*$price;
echo "<p  class='text-success'>"."单车单价:".$price."元/小时</p>";
echo "<p class='text-success'>"."总费用:".$transpay."元</p></div>";

//bank trans(user pay)
$sql = "update user set money=money-'$transpay' where username='$username' ";
mysql_query($sql);

//bank trans(trans record)
$sql = "update trans set transfee='$transpay'  where tid='$tid' ";
mysql_query($sql);

//set the bike location and position and flag
$sql = "update bike set flag='0', lid='$select', xpos='$endxpos', ypos='$endypos' where id='$bikeid' ";
mysql_query($sql);

//set the user location
$sql = "update user set lid='$select' where username='$username' ";
mysql_query($sql);

//to show if the user's money is not enough
$sql = "select money from user where username='$username'";
$result = mysql_query($sql);

$row = mysql_fetch_array($result);
if($row[0] < 0){
header("Location: ./bill.php");
}else{
// header("Location: ./success.html");

//print the trans info to user
$sql = "select * from trans where tid='$tid' ";
$result = mysql_query($sql);
$num = mysql_num_rows($result);
if($num){
$row = mysql_fetch_array($result);
// $count = count($row);
// echo "The transaction is list:";
// for($i=0;$i<$count;$i++){
// 	echo "<br> $row[$i]";
// }

}

}

}else{
header("Location: ./login.html");
}

?>

<div class="content">
    <table border="1" cellspacing="0" width="35%" align="center">
        <tr>
            <th>交易号</th>
            <th>用户名</th>
            <th>自行车号</th>
            <th>使用费用</th>
            <th>开始时间</th>
            <th>结束时间</th>
            <th>开始位置(X)</th>
            <th>开始位置(Y)</th>
            <th>结束位置(X)</th>
            <th>结束位置(Y)</th>
            <th>地区编号</th>
        </tr>
        <tr>
            <td><?php echo $row[0]; ?></td>
            <td><?php echo $row[1]; ?></td>
            <td><?php echo $row[2]; ?></td>
            <td><?php echo $row[3]; ?></td>
            <td><?php echo $row[4]; ?></td>
            <td><?php echo $row[5]; ?></td>
            <td><?php echo $row[6]; ?></td>
            <td><?php echo $row[7]; ?></td>
            <td><?php echo $row[8]; ?></td>
            <td><?php echo $row[9]; ?></td>
            <td><?php echo $row[10]; ?></td>
        </tr>
    </table>
</div>
</body>
</html>
