<?php 

$db_driver="mysql";
$db_host="127.0.0.1";
$databaseName="car_manage_project";
$username="root";
$password="root";
$dsn=$db_driver.':host='.$db_host.';dbname='.$databaseName;
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try{
	$connector=new PDO($dsn,$username,$password, $options);
}catch(Exception $ex){
	echo $ex->getMessage();
}
