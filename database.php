<?php
$server = 'localhost';
$username = 'root';
$password = 'root';
$database = 'norix-shopify-app';

$mysql = mysqli_connect($server, $username, $password, $database);
if (!$mysql) {
    die("Error " . mysqli_connect_error());
}
