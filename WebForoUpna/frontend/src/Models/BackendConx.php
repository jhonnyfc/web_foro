<?php

namespace Foroupna\Models;

use Exception;
use mysqli_sql_exception;
use PHPMD\Utility\Strings;
use PhpParser\Node\Expr\Cast\Array_;
use GuzzleHttp\Client;
use Guzzle\Http\Exception\BadResponseException;
use GuzzleHttp\Exception\BadResponseException as ExceptionBadResponseException;
use GuzzleHttp\Cookie\SessionCookieJar;

error_reporting(0);

class BackendConx
{
    private static $instance;
    private $client;

    public function __construct()
    {
        if (($jar = Session::get('cookie')) == null){
            $jar = new SessionCookieJar('PHPSESSID', true);
            Session::put('cookie', $jar);
        }

        require_once __DIR__ . "/../config/config.php";

        $this->client = new Client(array(
            'cookies' => $jar,
            'headers' => [
                'Origin' => ORIGIN_NAME,
            ]
        ));
    }

    public static function getInstance(): BackendConx
    {
        if (!self::$instance instanceof self) {
            self::$instance = new BackendConx();
        }
        return self::$instance;
    }

    public function postCall($url, $data):array {
        try {
            $response = $this->client->post("http://localhost:1234/router.php/".$url,[
                'json' => $data
            ]);
            $resultado = json_decode($response->getBody(), true);
        } catch (ExceptionBadResponseException  $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            // echo "noBAd".$responseBodyAsString;
            throw new Exception($responseBodyAsString);
        }
        return $resultado;
    }

    public function getCall($url): array{
        try {
            $response = $this->client->get("http://localhost:1234/router.php/".$url);
            $resultado = json_decode($response->getBody(), true);
        } catch (ExceptionBadResponseException  $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            // echo "noBAd".$responseBodyAsString;
            throw new Exception($responseBodyAsString);
        }
        return $resultado;
    }
}
