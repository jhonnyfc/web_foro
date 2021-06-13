<?php

namespace Foroupna\Models;

use Exception;
use mysqli_sql_exception;
use PHPMD\Utility\Strings;
use PhpParser\Node\Expr\Cast\Array_;

error_reporting(0);

class BackendConx
{
    public string $foto_url;
    public string $username;
    public string $email;

    public function __construct()
    {
    }

    public static function postCall($url, $data):string {
        // $url = 'http://server.com/path';
        // $data = array('key1' => 'value1', 'key2' => 'value2');

        // use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                // 'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
                'withCredentials' => 'true'
            )
        );

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        // if ($result === FALSE) { /* Handle error */ }

        // var_dump($result);
        return $result;
    }

    public static function getCall($url):array {
        $options = array(
            'http' => array(
                'header'  => array("Accept" => "application/json",
                                "Content-type" => "application/json"
                            ),
                'method'  => 'GET',
                'withCredentials' => 'true'
            )
        );

        $context  = stream_context_create($options);

        $result = file_get_contents($url, false, $context);

        if (!(gettype($result) === "string")) {
            throw new Exception("NO hay sesion iniciada");
            // return $result;
        }

        $result = json_decode($result,true);

        return $result;
    }
}
