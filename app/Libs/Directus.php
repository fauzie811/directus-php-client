<?php

namespace App\Libs;

use Exception;

class Directus
{
    protected $baseUrl = 'http://localhost:8055';

    private static $_instance = null;

    private function __construct() { }

    public static function getInstance(): static
    {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    protected function headers(): array
    {
        $token = $_COOKIE['access_token'];

        return [
            "Authorization: Bearer $token",
        ];
    }

    public function login($email, $password)
    {
        $res = Http::post($this->baseUrl . '/auth/login', compact('email', 'password'));

        $json = $res->getJson();
        if ($res->getStatusCode() == 200) {
            $ttl = time() + (86400 * 30); // 30 days
            setcookie('access_token', $json['data']['access_token'], $ttl, '/');
            setcookie('refresh_token', $json['data']['refresh_token'], $ttl, '/');
            setcookie('token_expires', time() + ($json['data']['expires'] / 1000), $ttl, '/');
        } else {
            throw new Exception($json['errors'][0]['message']);
        }
    }

    public function refresh()
    {
        if (!$this->isLoggedIn()) return;

        $isAboutToExpire = $_COOKIE['token_expires'] < (time() + 120);

        if (!$isAboutToExpire) return;

        $res = Http::post($this->baseUrl . '/auth/refresh', [
            'refresh_token' => $_COOKIE['refresh_token'],
        ]);

        $json = $res->getJson();
        if ($res->getStatusCode() == 200) {
            $ttl = time() + (86400 * 30); // 30 days
            setcookie('access_token', $json['data']['access_token'], $ttl, '/');
            setcookie('refresh_token', $json['data']['refresh_token'], $ttl, '/');
            setcookie('token_expires', time() + ($json['data']['expires'] / 1000), $ttl, '/');

            header('Location: ' . $_SERVER['REQUEST_URI']);
        } else {
            throw new Exception($json['errors'][0]['message']);
        }
    }

    public function logout()
    {
        if (!$this->isLoggedIn()) return;

        Http::post('http://localhost:8055/auth/logout', [
            'refresh_token' => $_COOKIE['refresh_token'],
        ]);

        setcookie('access_token', null, -1, '/');
        setcookie('refresh_token', null, -1, '/');
        setcookie('token_expires', null, -1, '/');
    }

    public function isLoggedIn(): bool
    {
        return !empty($_COOKIE['access_token'])
            && !empty($_COOKIE['refresh_token'])
            && !empty($_COOKIE['token_expires']);
    }

    public function getItems(string $collection): array
    {
        $res = Http::get($this->baseUrl . "/items/$collection", $this->headers());

        $json = $res->getJson();
        if ($res->getStatusCode() == 200) {
            return $json['data'];
        } else {
            throw new Exception($json['errors'][0]['message']);
        }
    }

    public function getItem(string $collection, $id): array
    {
        $res = Http::get($this->baseUrl . "/items/$collection/$id", $this->headers());

        $json = $res->getJson();
        if ($res->getStatusCode() == 200) {
            return $json['data'];
        } else {
            throw new Exception($json['errors'][0]['message']);
        }
    }

    public function updateItem(string $collection, $id, array $data = []): array
    {
        $res = Http::patch(
            $this->baseUrl . "/items/$collection/$id", $data, $this->headers()
        );

        $json = $res->getJson();
        if ($res->getStatusCode() == 200) {
            return $json['data'];
        } else {
            throw new Exception($json['errors'][0]['message']);
        }
    }
}
