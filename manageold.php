<?php 
header("Content-Type:text/html;charset=utf-8");
session_start();

if(isset($_SESSION["username"]) && $_SESSION["username"] === "admin"){
	mysql_connect("localhost","root","12345678");
	mysql_select_db("bike");
	mysql_query("set names 'gbk'");

	$username = $_SESSION["username"];

	//head print
	echo "today's transaction info: ";

	//get the current day transactions info
	$sql = "select tid,username,bikeid,transfee from trans where unix_timestamp(stime)>unix_timestamp(curdate()) ";
	$result = mysql_query($sql);
	$num = mysql_num_rows($result);

	if($num){
		for($i=0;$i<$num;$i++){
			$row = mysql_fetch_array($result);
			echo "<br>tid: $row[0]";
			echo "<br>username: $row[1]";
			echo "<br>bikeid: $row[2]";
			echo "<br>transfee: $row[3]";
		}
	}else{
		echo "no transaction today!";
	}

	//get the count info
	$sql = "select SUM(transfee) from trans where unix_timestamp(stime)>unix_timestamp(curdate()) ";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	echo "<br> total fee: $row[0]";

}else{
	header("Location: ./login.html");
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Bike is Rnnning Now!</title>
</head>
<body>
<div >
	check zone:
    <select class="form-control" name="select" id='selectzone' onclick="checkzone()">
        <option value="1" selected>chang an</option>
        <option value="2">wei yang</option>
        <option value="3">ba qiao</option>
        <option value="4">yan ta</option>
    </select>
    <p id="hintTxt"></p>
</div>
<a href="index.html">Index Page</a>
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
					document.getElementById("hintTxt").innerHTML+="transid:"+arr[i][0]+" username: "+arr[i][1]+" bikeid: "+arr[i][2]+" fee: "+arr[i][3]+"<br>";
				};
			}
			//document.getElementById("hintTxt").innerHTML=arr.length;
		}
	}
	xmlhttp.open("GET","getzinfo.php?zone="+str,true);
	xmlhttp.send();
	}
</script>
</body>
</html>