<?php 
header("Content-Type:text/html;charset=utf-8");
session_start();

if(isset($_SESSION["username"]) && $_SESSION["username"] ==="admin"){
    mysql_connect("localhost","root","12345678");
    mysql_select_db("bike");
    mysql_query("set names 'gbk'");

    $username = $_SESSION["username"];

    $bikeid = $_POST["bikeid"];
    $password = $_POST["password"];
    $typeid = $_POST["typeid"];
    $xpos = $_POST["xpos"];
    $ypos = $_POST["ypos"];
    $lid = $_POST["select"];


    //get the current bike's position
    $sql = "insert into bike(id,passwd,typeid,xpos,ypos,lid) values('$bikeid', '$password', '$typeid', '$xpos', '$ypos', '$lid') ";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);

    header("Location: ./showsucc.html");

}else{
    header("Location: ./login.html");
}
?>