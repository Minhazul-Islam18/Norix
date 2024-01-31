<?php
include_once("database.php");

$_CLIENT_ID = 'e1052bc53b05fcaa5aa07d8c10f63a1f';
$_CLIENT_SECRET = '8428166ce43162315602c8b90e249ac6';
$parameters = $_GET;
$shop_url = $parameters['shop'];
$hmac = $parameters['hmac'];

$parameters = array_diff_key($parameters, array('hmac' => ''));
ksort($parameters);
$new_hmac = hash_hmac('sha256', http_build_query($parameters), $_CLIENT_SECRET);

if (hash_equals($hmac, $new_hmac)) {
    // echo "Hello Shopify";
    $access_token_endpoint = 'https://' . $shop_url . '/admin/oauth/access_token';
    $data = array(
        'client_id' => $_CLIENT_ID,
        'client_secret' => $_CLIENT_SECRET,
        'code' => $parameters['code']
    );

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $access_token_endpoint);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, count($data));
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    $response = curl_exec($curl);
    curl_close($curl);

    $response = json_decode($response, true);
    // echo ($response['access_token']);
    // exit();
    // $query = "INSERT INTO shops (shop_url,access_token,install_date) VALUES ('" . $shop_url . "','" . $response['access_token'] . "',NOW())";
    // Assuming you have a PDO connection object named $pdo
    $query = "INSERT INTO shops (shop_url, access_token, install_date) 
          VALUES ('" . $shop_url . "','" . $response['access_token'] . "',NOW()) 
          ON DUPLICATE KEY UPDATE access_token = VALUES(access_token)";


    if ($mysql->query($query)) {
        header("Location: https://" . $shop_url . '/admin/apps');
        exit();
    } else {
        echo "dhuke nai";
        die();
    }
} else {
    echo "Something went wrong";
}
