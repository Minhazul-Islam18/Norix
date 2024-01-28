<?php

$_API_KEY = "0d630bdb77e576fff2d93d5018ede8e0";
$_NGROK_URL = "https://3f87-103-203-95-212.ngrok-free.app";

$shop = $_GET['shop'];
$scopes = 'write_products,read_shipping';

$redirect_uri = $_NGROK_URL . '/Shopify/token.php';
$nonce = bin2hex(random_bytes(12));
$access_mode = 'per-user';

// https://{shop}.myshopify.com/admin/oauth/authorize?client_id={client_id}&scope={scopes}&redirect_uri={redirect_uri}&state={nonce}&grant_options[]={access_mode}

$oauth_url = 'https://' . $shop . '/admin/oauth/authorize?client_id=' . $_API_KEY . '&scope=' . $scopes . '&redirect_uri=' . $redirect_uri . '&state=' . $nonce . '&grant_options[]=' . $access_mode;

header("Location: " . $oauth_url);

exit();
