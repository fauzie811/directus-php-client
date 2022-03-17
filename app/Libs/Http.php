<?php

namespace App\Libs;

use Exception;

class Http
{
    protected static function call(string $method, string $url, ?array $data = null, array $headers = []): HttpResponse
    {
        $method = strtoupper($method);

        if (!in_array($method, ['GET', 'POST', 'PATCH'])) {
            throw new Exception('Invalid method.');
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if ($method != 'GET') {
            $headers = array_merge($headers, [
                'Content-Type: application/json',
            ]);

            if ($data) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            }

            if ($method != 'POST') {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            } else {
                curl_setopt($ch, CURLOPT_POST, 1);
            }
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $output = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return new HttpResponse($output, $status);
    }

    public static function get(string $url, array $headers = []): HttpResponse
    {
        return static::call('GET', $url, null, $headers);
    }

    public static function post(string $url, ?array $data = null, array $headers = []): HttpResponse
    {
        return static::call('POST', $url, $data, $headers);
    }

    public static function patch(string $url, ?array $data = null, array $headers = []): HttpResponse
    {
        return static::call('PATCH', $url, $data, $headers);
    }
}

class HttpResponse
{
    protected $body;
    protected $statusCode;

    public function __construct($body, $statusCode)
    {
        $this->body = $body;
        $this->statusCode = $statusCode;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getJson()
    {
        return json_decode($this->body, true);
    }
}
