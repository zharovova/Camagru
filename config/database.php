<?php
$db_name = "camagru_db";
$db_hostname = "172.17.0.3";
$db_user = "root";
$db_password = "root";
$db_charset = "utf8";

#mysql container's ip 
$dsn = "mysql:host=172.17.0.3;dbname=" . $db_name;

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

?>

