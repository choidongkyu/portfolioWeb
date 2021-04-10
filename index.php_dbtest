<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>MySql-PHP 연결 테스트</title>
</head>
<body>
 
<?php
echo "MySql 연결 테스트<br>";
 
$db = mysqli_connect("127.0.0.1", "root", "Ddr7979556!", "portfolio");
 
if($db){
    echo "connect : 성공<br>";
}
else{
  echo "Error: Unable to connect to MySQL." . PHP_EOL;

	echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;

	echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;

	exit();
}
 
$result = mysqli_query($db, 'SELECT VERSION() as VERSION');
$data = mysqli_fetch_assoc($result);
echo $data['VERSION'];
?>
 
</body>
</html>
