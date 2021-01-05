<?php

namespace Core\View;

class View {
    private $view, $data;

    public function __construct($view, $data=[])
    {
        $this->view = $view;
        $this->data = $data;
    }

    public function render()
    {
        $loader = new \Twig\Loader\FilesystemLoader(APP_DIR . '/views/');
        $twig = new \Twig\Environment($loader, [
            'cache' => false
        ]);
        return $twig->render($this->view, $this->data);
    }
}