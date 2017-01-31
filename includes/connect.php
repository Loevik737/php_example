<?php

$host = "localhost";
$username = "root";
$password = "root";
$dbname = "users";

//the conn variable can be used later to query the datbase
$conn = new mysqli($host, $username, $password, $dbname);
//if we have passed on wrong information in the connect query we fail to connect
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
 $conn->set_charset('utf8');

?>
