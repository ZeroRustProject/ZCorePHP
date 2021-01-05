<?php

namespace Core\Router\HTTP;

class Request {
    public $domain, $uri, $method, $ip, $useragent, $query, $params;

    public function __construct($params=[])
    {
        $this->domain = $_SERVER['HTTP_HOST'];
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->useragent = $_SERVER['HTTP_USER_AGENT'];
        if($this->method == "GET") $this->query = $_GET;
        if($this->method == "POST") $this->query = $_POST;
        $this->params = $params;
    }
}