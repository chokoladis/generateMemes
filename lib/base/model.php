<?php

namespace Main\Base;

use Exception;
use PDO;

class Model {

    protected $connect;
    
    // private $attributes = [];

    function __construct(){

        $env = require_once ROOT_DIR.'/../../private/gen_meme_env.php';
        $env['db']['port'] = $env['db']['port'] ? ':'.$env['db']['port'] : '';

        try {
            
            if (!$this->connect) {
                $strConnect = 'mysql:host='.$env['db']['host'].$env['db']['port'].';dbname='.$env['db']['dbname'].';charset=utf8mb4';

                $this->connect = new PDO($strConnect, $env['db']['user'], $env['db']['password']);
            }

            // $table = $this->getTable();
            // $this->attributes = $this->connect->query("DESCRIBE $table")->fetchAll(PDO::FETCH_COLUMN);

            unset($env);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
    public function getTable() : string{
        return 'm_'.strtolower(__CLASS__);
    }

    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    public function getAttribute(string $key){
        if (in_array($key, $this->attributes)){

            $query = $this->connect->prepare("SELECT $key FROM $this->getTable() WHERE `id` = $this->id LIMIT 1");
            if ($query->execute())
                return $query->fetch(PDO::FETCH_ASSOC);

        } else {
            throw new Exception("Error - in table not $key");
        }
    }

    public function findOne(array|int $filter, string $columns = '*', array $order = ['id' => 'DESC'], string $type = '')
    {

        try {

            $strWhere = $strOrder = "";

            if (is_array($filter) && !empty($filter)){
                unset($filter['table']);
                unset($filter['col']);

                // > < >= <= %% todo
                $last = $filter[array_key_last($filter)];
                foreach ($filter as $key => $value) {
                    $char = $last === $value ? '' : ',';

                    if ($type){
                        if ($type === 'LIKE'){
                            $operator = "LIKE CONCAT('%', :$key , '%')";
                        } else {
                            $operator = "$type :$key";
                        }
                    } else {
                        $operator = "= :$key";
                    }

                    var_dump($operator);

                    $strWhere .= "`$key` $operator $char";
                }
            } elseif(is_integer($filter)) {
                if ($filter > 0){
                    $filter = ['id' => $filter];
                    $strWhere = "`id` = :id";
                } else {
                    throw new \Exception("Error - select query db");
                }
            }

            $strWhere = $strWhere ? "WHERE $strWhere" : '';

            $params = ['t' => $this->getTable(), 'col' => $columns];
            if (!empty($filter)){
                $params = array_merge($params, $filter);
            }

            $order = [];
            if (!empty($order)){
                
                $last = $order[array_key_last($order)];

                foreach ($order as $key => $value) {
                    $char = $last === $value ? '' : ',';
                    $strOrder .= "`$key` = :order_$key $char";
                    $optsOrder['order_'.$key] = $value;
                }

                $params = array_merge($params, $optsOrder);
            }
            $strOrder = $strOrder ? "ORDER BY $strOrder" : '';
            
            var_dump($this->connect);
            $query = $this->connect->prepare("SELECT `:col` FROM `:t` $strWhere LIMIT 1 $strOrder");
            if ($query->execute($params)){
                return $query->fetch(PDO::FETCH_ASSOC);
            } else {
                throw new \Exception("Error - ".$query->errorInfo());
            }

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
    public function find(array $filter, string $columns = '*', int $limit = 10 ,$order = ['id' => 'DESC'])
    {
        try {

            $strWhere = $strOrder = "";

            if (is_array($filter) && !empty($filter)){
                unset($filter['table']);
                unset($filter['col']);

                // > < >= <= %% todo
                $last = $filter[array_key_last($filter)];
                foreach ($filter as $key => $value) {
                    $char = $last === $value ? '' : ',';
                    $strWhere .= "`$key` = :$key $char";
                }

                $strWhere = "WHERE ".$strWhere;
            }

            $params = ['table' => $this->getTable(), 'col' => $columns];
            if (!empty($filter)){
                $params = array_merge($params, $filter);
            }

            if (!empty($order)){
                
                $last = $order[array_key_last($order)];

                foreach ($order as $key => $value) {
                    $char = $last === $value ? '' : ',';
                    $strOrder .= "`$key` = :order_$key $char";
                    $optsOrder['order_'.$key] = $value;
                }

                $params = array_merge($params, $optsOrder);
            }

            $limit = $limit < 1 ? 1 : $limit;
            $limit = $limit > 100 ? 100 : $limit;
            
            $query = $this->connect->prepare("SELECT :col FROM :table $strWhere LIMIT $limit ORDER BY $strOrder");
            if ($query->execute($params)){
                return $query->fetch(PDO::FETCH_ASSOC);
            } else {
                throw new \Exception("Error - ".$query->errorInfo());
            }

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
    public function create(array $fileds) {

        $table = $this->getTable();

        try {

            if (empty($fileds))
                throw new \Exception("Error - array fields is empty");

            $strValues = "";

            foreach ($fileds as $key => $value) {
                $strValues .= "`$key` = :$key, ";
                $params[$key] = $value;
            }

            $query = $this->connect->prepare("INSERT INTO `$table` SET $strValues");
            if ($query->execute($params)){
                return intval($this->connect->lastInsertId());
            } else {
                throw new \Exception("Error - ".$query->errorInfo());
            }
            
        } catch (\Throwable $th) {
            throw $th;
        }

    }

    public function update(array $fileds, array $filter) {

        $table = $this->getTable();

        try {

            if (empty($fileds) || empty($filter))
                throw new \Exception("Error - important array fields or filter is empty");

            $strValues = $strFilter = "";

            foreach ($fileds as $key => $value) {
                $strValues .= "`$key` = :$key, ";
                $params[$key] = $value;
            }

            $last = $filter[array_key_last($filter)];

            foreach ($filter as $key => $value) {
                $char = $last === $value ? '' : ',';
                $strFilter .= "`$key` = :filter_$key";
                $params['filter_'.$key] = $value;
            }

            $query = $this->connect->prepare("UPDATE `$table` SET $strValues WHERE $strFilter LIMIT 1");
            if ($query->execute($params)){
                return intval($this->connect->lastInsertId());
            } else {
                throw new \Exception("Error - ".$query->errorInfo());
            }
            
        } catch (\Throwable $th) {
            throw $th;
        }

    }

    public function delete(int $id) {

        $table = $this->getTable();

        try {

            if ($id < 1)
                throw new \Exception("Error - param id is should be bigger 0");

            $query = $this->connect->prepare("DELETE FROM `$table` WHERE `id` = :id LIMIT 1");
            if ($query->execute(['id' => $id])){
                return true;
            } else {
                throw new \Exception("Error - ".$query->errorInfo());
            }
            
        } catch (\Throwable $th) {
            throw $th;
        }

    }
}