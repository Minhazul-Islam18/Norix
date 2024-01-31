<?php

$_API_KEY = "e1052bc53b05fcaa5aa07d8c10f63a1f";
$_NGROK_URL = "https://925c-103-203-95-212.ngrok-free.app";

$shop = $_GET['shop'];
$scopes = 'write_products,read_shipping';

$redirect_uri = $_NGROK_URL . '/Shopify/token.php';
$nonce = bin2hex(random_bytes(12));
$access_mode = 'per-user';

// https://{shop}.myshopify.com/admin/oauth/authorize?client_id={client_id}&scope={scopes}&redirect_uri={redirect_uri}&state={nonce}&grant_options[]={access_mode}

$oauth_url = 'https://' . $shop . '/admin/oauth/authorize?client_id=' . $_API_KEY . '&scope=' . $scopes . '&redirect_uri=' . urlencode($redirect_uri) . '&state=' . $nonce . '&grant_options[]=' . $access_mode;

header("Location: " . $oauth_url);

exit();
