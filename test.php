<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php 

echo $_GET['b'];
echo "<br>";
echo $_GET['a'];
echo "<br>";



foreach ($_SERVER as $key => $value) {
	# code...
	echo $key."=>".$value;
	echo "<br>";
}
print_r($GLOBALS);
	echo "<br>";

print_r($_SESSION);
	echo "<br>";


print_r($_GET);
$array = array('john' => 33, 'romaker' => 22);
foreach ($array as $key => $value) {
	# code...
	echo $key." is ".$value;
	echo "<br>";
}
$array2 = array("abb","bcc");
echo count($array);
sort($array2);
print_r($array2);
rsort($array2);
print_r($array2);


?>
</body>
</html>
