<?php
header("Content-Type:text/html;charset=utf-8");
session_start();

if(isset($_SESSION["username"]) && $_SESSION["username"] === "admin"){
	mysql_connect("localhost","root","12345678");
	mysql_select_db("bike");
	mysql_query("set names 'gbk'");

	$username = $_SESSION["username"];

	//head print
	echo "<h2>今日交易信息: </h2>";

	//get the current day transactions info
	$sql = "select tid,username,bikeid,transfee from trans where unix_timestamp(stime)>unix_timestamp(curdate()) ";
$result = mysql_query($sql);
$num = mysql_num_rows($result);

if($num){
$rows = array();
for($i=0;$i<$num;$i++){
$row = mysql_fetch_array($result);
array_push($rows, $row);
}
// for($i=0;$i<$num;$i++){
// 	$row = mysql_fetch_array($result);
// 	echo "<br>tid: $row[0]";
// 	echo "<br>username: $row[1]";
// 	echo "<br>bikeid: $row[2]";
// 	echo "<br>transfee: $row[3]";
// }
}else{
echo "no transaction today!";
}

//get the count info
$sql = "select SUM(transfee) from trans where unix_timestamp(stime)>unix_timestamp(curdate()) ";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
echo "<br>总营收: $row[0]元";

}else{
header("Location: ./login.html");
}
?>

<!DOCTYPE html>
<html>
<head>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/normalize.css">
    <title>欢迎使用共享单车</title>
</head>
<body>

<div class="content">
    <table border="1" cellspacing="0" width="35%" align="center">
        <tr>
            <th>tid</th>
            <th>username</th>
            <th>bikeid</th>
            <th>transfee</th>
        </tr>
        <?php foreach ($rows as $row): ?>
        <tr>
            <td><?php echo $row[0]; ?></td>
            <td><?php echo $row[1]; ?></td>
            <td><?php echo $row[2]; ?></td>
            <td><?php echo $row[3]; ?></td>
        </tr>
        <?php endforeach ?>
    </table>
</div>

<div>
    查看区域经营情况:
    <select class="form-control" name="select" id='selectzone' onclick="checkzone()">
        <option value="1" selected>长安区</option>
        <option value="2">未央区</option>
        <option value="3">灞桥区</option>
        <option value="4">雁塔区</option>
    </select>
    <p id="hintTxt"></p>
</div>
<a href="index.html">首页</a>
<script type="text/javascript">
    function checkzone(){
        var str = document.getElementById('selectzone').value;

        document.getElementById("hintTxt").innerHTML = ' ';
        if (window.XMLHttpRequest)
        {
            // IE7+, Firefox, Chrome, Opera, Safari 浏览器执行的代码
            xmlhttp=new XMLHttpRequest();
        }
        else
        {
            //IE6, IE5 浏览器执行的代码
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)//if ready receive
            {
                // document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
                var arr = JSON.parse(xmlhttp.responseText);
                //alert(arr);
                if(arr === null){
                    document.getElementById("hintTxt").innerHTML="there is no transaction today in this zone";

                }else{
                    for (var i = arr.length - 1; i >= 0; i--) {
                        document.getElementById("hintTxt").innerHTML+="<br>transid: "+arr[i][0]+" username: "+arr[i][1]+" bikeid: "+arr[i][2]+" fee: "+arr[i][3]+"<br>";
                    }
                }
                //document.getElementById("hintTxt").innerHTML=arr.length;
            }
        };
        xmlhttp.open("GET","getzinfo.php?zone="+str,true);
        xmlhttp.send();
    }
</script>
</body>
</html>