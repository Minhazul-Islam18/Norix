<?php

namespace App;

class Shopify
{
    public static $shop_url; // change to static
    public static $token; // change to static

    public static function set_shop_url($shop_url)
    {
        self::$shop_url = $shop_url;
    }

    public static function set_token($token)
    {
        self::$token = $token;
    }

    public static function get_shop_url() // change to static
    {
        return self::$shop_url;
    }

    public static function get_token() // change to static
    {
        return self::$token;
    }

    public static function api_response($endpoint, array $query = [], $method = 'GET')
    {
        $url = 'https://' . self::$shop_url . $endpoint;
        // echo $url;

        if (in_array($method, ['GET', 'DELETE']) && !is_null($query)) {
            $url = $url . '?' . http_build_query($query);
        }


        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);


        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);


        $headers[] = "";
        if (!is_null(self::$token)) {
            $headers[] = "X-Shopify-Access_Token: " . self::$token;
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }

        if ($method != 'GET' && in_array($method, ['POST', 'PUT'])) {
            if (is_array($query)) $query = http_build_query($query);

            curl_setopt($curl, CURLOPT_POSTFIELDS, $query);
        }


        $response = curl_exec($curl);
        $error = curl_errno($curl);
        $error_msg = curl_error($curl);
        curl_close($curl);

        if ($query) {
            return $error_msg;
        } else {
            $response = preg_split("/\r\n\r\n|\n\n\r\r/", $response, 2);
            // return $response;
            echo var_dump($response);
            exit();
        }
    }
}
