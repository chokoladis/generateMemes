<?php

namespace Main\Base;

use PDO;

class Controller {

    private static $connect;

    function __construct(){

        $env = require_once ROOT_DIR.'/../../private/gen_meme_env.php';
        $env['db']['port'] = $env['db']['port'] ? ':'.$env['db']['port'] : '';

        try {
            
            if (!self::$connect) {
                $strConnect = 'mysql:host'.$env['db']['host'].$env['db']['port'].';dbname='.$env['db']['dbname'].'charset=utf8mb4';

                self::$connect = new PDO($strConnect, $env['db']['user'], $env['db']['password']);
            }

            unset($env);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
}