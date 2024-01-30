<?php

$database = 'norix-shopify-app';
$db_host = 'localhost';
$db_user = 'root';
$db_pass = 'root';

$mysqli_connection = mysqli_connect('localhost', 'root', 'root', 'norix-shopify-app');

if (!$mysqli_connection) {
    die('MySQL connection error.' . mysqli_connect_error());
}
