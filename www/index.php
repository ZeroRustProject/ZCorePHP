<?php

define('APP_DIR', __DIR__ . '/../app/');
define('PUBLIC_DIR', __DIR__);
define('ROOT_DIR', __DIR__ . '/../');
define('APP_CONFIG', json_decode(file_get_contents(APP_DIR . '/app.config.json'), true));

require('../vendor/autoload.php');

use \Core\View\View as View;
use \Core\Database\Database as Database;

$app = new \Core\Framework();

$app->get('/', function() {
    return new View('pages/index.html');
});

$app->run();