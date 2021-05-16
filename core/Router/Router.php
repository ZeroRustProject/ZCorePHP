<?php

namespace Core\Router;

class Router {
    private $errorCallback;
    private $routes = [];

    public function get($route, $callback) { $this->routes['GET'][$route] = $callback; }
    public function post($route, $callback) { $this->routes['POST'][$route] = $callback; }
    public function set404($callback) { $this->errorCallback = $callback; }

    private function invoke($callback, $params=[])
    {
        if(is_callable($callback))
        {
            $result = call_user_func_array($callback, $params);
            if(is_string($result)) {
                if(substr($result, 0, 3) == "loc")
                    if(!headers_sent())
                        header('Location: '.explode(":", $result)[1]);
                else echo $result;
            }
            if(is_array($result)) { echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK); }
            if(is_bool($result)) { echo json_encode(['response'=>$result], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK); }
            if(is_null($result)) { echo json_encode(['response'=>false], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK); }
            if(is_object($result) && get_class($result) == "Core\View\View") { echo $result->render(); }
        }
    }

    public function run()
    {
        $uri = '/' . trim(explode('?', $_SERVER['REQUEST_URI'])[0], '/');
        $invoked = 0;
        if(isset($this->routes[$_SERVER['REQUEST_METHOD'])) {
            foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route=>$callback) {
                $route = preg_replace('/\/{(.*?)}/', '/(.*?)', $route);
                if (preg_match_all('#^' . $route . '$#', $uri, $matches, PREG_OFFSET_CAPTURE)) {
                    $matches = array_slice($matches, 1);
                    $params = array_map(function ($match, $index) use ($matches) {
                        if (isset($matches[$index + 1]) && isset($matches[$index + 1][0]) && is_array($matches[$index + 1][0])) {
                            if ($matches[$index + 1][0][1] > -1) {
                                return trim(substr($match[0][0], 0, $matches[$index + 1][0][1] - $match[0][1]), '/');
                            }
                        }
                        return isset($match[0][0]) && $match[0][1] != -1 ? trim($match[0][0], '/') : null;
                    }, $matches, array_keys($matches));
                    $this->invoke($callback, $params);
                    $invoked++;
                    break;
                }
            }
        }
        if($invoked < 1) { $this->invoke($this->errorCallback); }
    }
}