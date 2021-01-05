<?php

namespace Core\Database;

class Database {
    static $db;

    public static function Init()
    {
        $config = json_decode(file_get_contents(APP_DIR . '/database.config.json'), true);
        self::$db = new \Medoo\Medoo([
            'database_type' => 'mysql',
            'database_name' => $config['database'],
            'server' => $config['hostname'],
            'username' => $config['username'],
            'password' => $config['password']
        ]);
    }

    public static function get() { return self::$db; }
}