<?php

$_CLIENT_ID = '0d630bdb77e576fff2d93d5018ede8e0';
$_CLIENT_SECRET = 'd6e193f89cff97df2fbf7f0ea132921a';
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
    echo print_r($response);
} else {
    echo "Something went wrong";
}
