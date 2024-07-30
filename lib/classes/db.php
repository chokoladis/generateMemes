<?

namespace Main\Classes;

use PDO;

class db {

    private $connect;

    function __construct(){

        $env = require_once $_SERVER['DOCUMENT_ROOT'].'/private/env.php';
        $env['db']['port'] = $env['db']['port'] ? ':'.$env['db']['port'] : '';

        try {
            
            $strConnect = 'mysql:host'.$env['db']['host'].$env['db']['port'].';dbname='.$env['db']['dbname'];
            $this->connect = new PDO($strConnect, $env['db']['user'], $env['db']['password']);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
   
}