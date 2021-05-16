<?php

namespace Core\View;

class View {
    private $view, $data;

    public function __construct($view, $data=[])
    {
        $this->view = $view;
        $data['server'] = $_SERVER;
        $data['app'] = APP_CONFIG['app'];
        $this->data = $data;
    }

    public function render()
    {
        $loader = new \Twig\Loader\FilesystemLoader(APP_DIR . '/views/');
        $cache = false;
        if(APP_CONFIG['twig']['cache'])
            $cache = APP_DIR . '/cache';
        $twig = new \Twig\Environment($loader, [ 'cache' => $cache ]);
        return $twig->render($this->view, $this->data);
    }
}