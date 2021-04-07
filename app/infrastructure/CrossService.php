<?php
/**
 * User: olijenius@gmail.com
 * Date: 11.02.20
 * Time: 19:34
 */

namespace app\infrastructure;

use Exception;
use Yii;

/**
 * Class CrossService - отвечает за запросы на внешнее API
 * Использование: CrossService::requestGet('core', 'products', ['marketplace'=>$m]);
 *
 * @package app\components
 */
class CrossService
{
    protected $service;
    protected $action;
    protected $params;
    protected $method;
    protected $headers;
    protected $version = 1;
    protected $json = true;
    protected $isInnerRequest = true;

    public $userAgent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.79 Safari/537.3627777';

    /**
     * @var bool
     */
    public $connectError = false;

    /**
     * @var null
     */
    public $status = null;

    /**
     * @var null
     */
    public $data = null;

    /**
     * @var null
     */
    public $response = null;

    /**
     * @var array
     */
    public $responseHeaders = [];

    /**
     * @var array
     */
    private $services = null;

    /**
     * CrossService constructor.
     * @param string $service
     * @param string $action
     * @param array $params
     * @param string $method
     * @param array $headers
     * @param int $version
     */
    public function __construct(
        $service = '',
        $action = '',
        $params = [],
        $method = 'GET',
        $headers = [],
        $version = 1
    )
    {
        $this->service = $service;
        $this->action = $action;
        $this->params = $params;
        $this->method = $method;
        $this->headers = $headers;
        $this->version = $version;

        $this->services = Yii::$app->params['servicesPath'];
    }

    /**
     * @param string $service
     * @param string $action
     * @param array $params
     * @param string $method
     * @param array $headers
     * @param int $version
     * @return CrossService
     */
    public static function requestGet(
        $service = '',
        $action = '',
        $params = [],
        $method = 'GET',
        $headers = [],
        $version = 1
    )
    {
        return (new self($service, $action, $params, $method, $headers, $version));
    }

    /**
     * @param string $service
     * @param string $action
     * @param array $params
     * @param string $method
     * @param array $headers
     * @param int $version
     * @return CrossService
     */
    public static function requestGetGateway(
        $service = '',
        $action = '',
        $params = [],
        $method = 'GET',
        $headers = [],
        $version = null
    )
    {
        return (new self($service, $action, $params, $method, $headers, $version));
    }

    /**
     * @param string $service
     * @param string $action
     * @param array $params
     * @param string $method
     * @param array $headers
     * @param int $version
     * @return CrossService
     */
    public static function requestPost(
        $service = '',
        $action = '',
        $params = [],
        $method = 'POST',
        $headers = [],
        $version = 1
    )
    {
        return (new self($service, $action, $params, $method, $headers, $version));
    }

    /**
     * @param string $service
     * @param string $action
     * @param array $params
     * @param string $method
     * @param array $headers
     * @param int $version
     * @return CrossService
     */
    public static function requestPostGateway(
        $service = '',
        $action = '',
        $params = [],
        $method = 'POST',
        $headers = [],
        $version = null
    )
    {
        return (new self($service, $action, $params, $method, $headers, $version));
    }

    /**
     * @param string $service
     * @param string $action
     * @param array $params
     * @param string $method
     * @param array $headers
     * @param int $version
     * @return CrossService
     */
    public static function requestPut(
        $service = '',
        $action = '',
        $params = [],
        $method = 'PUT',
        $headers = [],
        $version = 1
    )
    {
        return (new self($service, $action, $params, $method, $headers, $version));
    }

    /**
     * @param string $service
     * @param string $action
     * @param array $params
     * @param string $method
     * @param array $headers
     * @param int $version
     * @return CrossService
     */
    public static function requestDelete(
        $service = '',
        $action = '',
        $params = [],
        $method = 'DELETE',
        $headers = [],
        $version = 1
    )
    {
        return (new self($service, $action, $params, $method, $headers, $version));
    }

    /**
     * @param bool $dump
     * @return bool|mixed
     * @throws Exception
     */
    public function request($dump = false)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->getUrl());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true); // enable tracking

        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        //curl_setopt($ch, CURLOPT_STDERR, fopen(__DIR__.'/../curl.txt', 'w'));

        curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);

        if ($this->isInnerRequest) {
            //todo: микросервисный запрос (пока не актуально)
        } else {
            //$proxy = '127.0.0.1:8888';
            //curl_setopt($ch, CURLOPT_PROXY, $proxy);
            //Если внешний запрос
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                //"Content-Type: application/x-www-form-urlencoded;charset=UTF-8",
                //"Host: www.amazon.com",
                "Connection: keep-alive",
                //"Content-Length: 264",
                //"Accept: text/html,*/*",
                //"X-Requested-With: XMLHttpRequest",
                //"User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/531247.31246 (KHTML, like Gecko) Chrome/75.0.3770124.101240 Safari/537.1121314",
                //"Content-Type: application/x-www-form-urlencoded;charset=UTF-8",
                //"Referer: /
                "Accept-Encoding: text",
                //"Accept-Language: uk-UA,uk;q=0.9,en-IN;q=0.8,en;q=0.7,ru;q=0.6,en-US;q=0.5",
            ]);
        }

        if ($this->method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->params);
        }

        if ($this->method == 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        }

        if ($this->method == 'PUT') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->params);
        }

        $output = curl_exec($ch);

        if (isset($_GET['request_dump'])) {
            $info = curl_getinfo($ch);
            echo(str_replace(' ', '<br>', $info['request_header'])); exit;
        }
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $this->responseHeaders = substr($output, 0, $header_size);

        $this->responseHeaders = explode("\n", $this->responseHeaders);

        $output = substr($output, $header_size);
        $this->status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        Yii::info("Status: " . $this->status . " Headers " . json_encode($this->responseHeaders));

        if ($dump) {
            var_dump($output, $this->status);
            exit;
        }

        //todo: use for dump and debug or logs
        //$info = curl_getinfo($ch); var_dump($info); exit;

        if ($output === false) {

            $this->connectError = [
                "name" => "Cross service HTTP error",
                "message" => curl_error($ch),
                "code" => 0,
                "status" => 500,
            ];

            curl_close($ch);
            return false;
        }

        curl_close($ch);

        if ($this->json === true) {
            $output = json_decode($output, JSON_FORCE_OBJECT);
        }

        //todo: detect framework validation errors

        return $this->response = $output;
    }

    public function unsetJson()
    {
        $this->json = false;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getUrl()
    {
        $params = '';
        if (
            (
                $this->method == 'GET'
                ||
                $this->method == 'DELETE'
            )
            &&
            !empty($this->params
            )
        ) {
            $params = '?' . http_build_query($this->params);
        }

        return
            $this->getServiceDomain() . ($this->isInnerRequest?
                '/' .
                'v' . $this->version : '') .
            '/' .
            $this->action .
            $params;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function getServiceDomain()
    {
        if (empty($this->services[$this->service])) {
            throw new Exception('Add service "'.$this->service.'" to params.php[servicesPath]!');
        }

        $serviceDomain = $this->services[$this->service];
        //todo: detect domain for docker
        /*if (IS_LOCAL) {
            //$hostServiceDomain = exec('/sbin/ip route|awk \'/default/ { print $3 }\'');
            //$serviceDomain = str_replace('localhost', $hostServiceDomain, $serviceDomain);
        }*/
        return $serviceDomain;
    }

    /**
     * @return bool
     */
    public function isRequestSuccess()
    {
        if ($this->connectError !== false) {
            return false;
        }

        if (
            $this->status == 200 ||
            $this->status == 201 ||
            $this->status == 204
        ) {
            return true;
        }

        return false;
    }

    /**
     * @param string $message
     * @throws Exception
     */
    public function throwExceptionIfFail($message = 'Cross service error: ')
    {
        if (!$this->isRequestSuccess()) {
            if (is_array($this->response)) {
                $message .=
                    $this->response['message'] . ' '
                    . $this->response['file'] . ' '
                    . $this->response['line'];
            } elseif (!empty($this->response)) {
                $message = $this->response;
            }


            throw new \Exception(
                $message .
                json_encode([
                    $this->connectError,
                    $this->status,
                    $this,
                    'url: ' . $this->getUrl(),
                    'service: ' . $this->service,
                    'action: ' . $this->action,
                    'params: ' . json_encode($this->params),
                    'method: ' . $this->method,
                    'headers: ' . json_encode($this->headers),
                    'version: ' . $this->version,
                ])
            );
        }
    }

    public function unsetInnerRequest()
    {
        $this->isInnerRequest = false;
    }
}
