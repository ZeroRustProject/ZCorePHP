<?php

namespace Core\Database;

class Database {
    static $db;

    public static function Init()
    {
        self::$db = new \Medoo\Medoo([
            'database_type' => 'mysql',
            'database_name' => APP_CONFIG['sql']['database'],
            'server' => APP_CONFIG['sql']['hostname'],
            'username' => APP_CONFIG['sql']['username'],
            'password' => APP_CONFIG['sql']['password']
        ]);
    }

    public static function get() { return self::$db; }
}