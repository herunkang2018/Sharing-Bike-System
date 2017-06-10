

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>欢迎使用共享单车</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/normalize.css">
    <style>
        .container-small{
            max-width: 400px;
            margin-top: 80px;
        }
        #p1{
            background: green;
        }
        #p2{
            font-size: 20px;
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
header("Content-Type:text/html;charset=utf-8");
session_start();

if(isset($_SESSION["username"])){
    mysql_connect("localhost","root","12345678");
    mysql_select_db("bike");
    mysql_query("set names 'gbk'");

    $username = $_SESSION["username"];
    $bikeid = $_POST["bikeid"];

    //get the current bike's position
    $sql = "select xpos,ypos from bike where id='$bikeid' ";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    $xpos = $row[0];
    $ypos = $row[1];

    //get the bike lid
    $sql = "select lid from bike where id='$bikeid' ";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    $lid = $row[0];

    //begin a transaction, use the begin lid as the trans's lid
    $sql = "insert into trans(username,bikeid,stime,sxpos,sypos,lid,transfee) values('$username', '$bikeid', now(), '$xpos', '$ypos', '$lid', 0)";
    mysql_query($sql);

    //change flag
    $sql = "update bike set flag='1' where id='$bikeid' ";
    mysql_query($sql);

    //tell the user bike_password
    $sql = "select passwd from bike where id='$bikeid' ";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    echo "<p class='text-success' id='p2'> The passwd: ".$row[0]."</p>";
}else{
    header("Location: ./login.html");
}
?>
<form class="container container-small" action="transend.php" method="POST">
    <div class="well">
        <div class="form-group">
            <label>请输入你的当前位置：</label>
            <div class="input-group">
                <div class="input-group-addon">结束时X的坐标</div>
                <input type="text" name="endxpos" class="form-control" placeholder="X坐标">
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon">结束时Y的坐标</div>
                <input type="text" name="endypos" class="form-control" placeholder="Y坐标">
            </div>
        </div>
        <div class="form-group">
            <select class="form-control" name="select">
                <option value="1">长安区</option>
                <option value="2">未央区</option>
                <option value="3">灞桥区</option>
                <option value="4">雁塔区</option>
            </select>
        </div>
    </div>
    <button class="btn btn-primary btn-block" value="enduse" name="enduse" type="submit">
        结束使用
    </button>
</form>

</body>
</html>
