<?php

use App\Shopify;
use Shopify\Clients\Rest;

require("vendor/autoload.php");
include_once("database.php");


$parameters = $_GET;
//Check if record already exists
$query = "SELECT * FROM shops WHERE shop_url = '" . $parameters['shop'] . "' LIMIT 1";

$record = $mysql->query($query);

if ($record->num_rows < 1) {
    header("Location: install.php?shop=" . $parameters['shop']);

    exit();
}
$data_record = $record->fetch_assoc();

Shopify::set_shop_url($parameters['shop']);
Shopify::set_token($data_record['access_token']);

// echo Shopify::get_shop_url();
// echo '</br>';
// echo Shopify::get_token();
$prs = Shopify::api_response('/admin/api/2024-01/products.json', [], 'GET');
echo var_dump($prs);
