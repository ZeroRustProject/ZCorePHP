<?php

namespace Core;

class Framework extends Router\Router {
    public function __construct()
    {
        \Core\Database\Database::Init();
    }
}