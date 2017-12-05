<?php
//$dsn = 'mysql:dbname=courseraJavascript;host=localhost;port=3306';

//$dsn = 'mysql://bc0a4a6927ecc3:1227f14c@us-cdbr-iron-east-05.cleardb.net/heroku_a6f9050db49e4ab?reconnect=true';

//$host = 'us-cdbr-iron-east-05.cleardb.net';


$dsn = 'mysql:dbname=heroku_a6f9050db49e4ab;host=us-cdbr-iron-east-05.cleardb.net;port=3306';
$user = 'bc0a4a6927ecc3';
$pass = '1227f14c';

try {
    //$pdo = new PDO($dsn, $user, $pass);    
	$pdo = new PDO($dsn, $user, $pass);    
} catch (Exception $ex) {
   echo $ex->getMessage(); 
}



?>