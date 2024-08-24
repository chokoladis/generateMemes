<?php

namespace Main\Base;

use PDO;

class Model {

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
    
    public function getTableName() : string{
        return 'm_'.strtolower(__CLASS__);
    }
    
    protected function findOne(array|int $filter, string $columns = '*', array $order = ['id' => 'DESC'])
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
            } elseif(is_integer($filter)) {
                if ($filter > 0){
                    $filter = ['id' => $filter];
                    $strWhere = "`id` = :id";
                } else {
                    throw new \Exception("Error query db");
                }
            }

            $strWhere = $strWhere ? "WHERE ".$strWhere : '';

            $params = ['table' => $this->getTableName(), 'col' => $columns];
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
            
            $query = self::$connect->prepare("SELECT :col FROM :table $strWhere LIMIT 1 ORDER BY $strOrder");
            if ($query->execute($params)){
                return $query->fetch(PDO::FETCH_ASSOC);
            } else {
                throw new \Exception("Error - ".$query->errorInfo());
            }

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
    protected function find(array $filter, string $columns = '*', int $limit = 10 ,$order = ['id' => 'DESC'])
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

            $params = ['table' => $this->getTableName(), 'col' => $columns];
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
            
            $query = self::$connect->prepare("SELECT :col FROM :table $strWhere LIMIT $limit ORDER BY $strOrder");
            if ($query->execute($params)){
                return $query->fetch(PDO::FETCH_ASSOC);
            } else {
                throw new \Exception("Error - ".$query->errorInfo());
            }

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
    protected function create(array $fileds) {

        $table = $this->getTableName();

        try {

            if (empty($fileds))
                throw new \Exception("Error fields empty");

            $strValues = "";

            foreach ($fileds as $key => $value) {
                $strValues .= "`$key` = :$key, ";
                $params[$key] = $value;
            }

            $query = self::$connect->prepare("INSERT INTO `$table` SET $strValues");
            if ($query->execute($params)){
                return intval(self::$connect->lastInsertId());
            } else {
                throw new \Exception("Error - ".$query->errorInfo());
            }
            
        } catch (\Throwable $th) {
            throw $th;
        }

    }

    protected function update(array $fileds, array $filter) {

        $table = $this->getTableName();

        try {

            if (empty($fileds))
                throw new \Exception("Error fields empty");

            $strValues = "";

            foreach ($fileds as $key => $value) {
                $strValues .= "`$key` = :$key, ";
                $params[$key] = $value;
            }
            // filter todo
            $strFilter = '';

            $query = self::$connect->prepare("UPDATE `$table` SET $strValues WHERE $strFilter");
            if ($query->execute($params)){
                return intval(self::$connect->lastInsertId());
            } else {
                throw new \Exception("Error - ".$query->errorInfo());
            }
            
        } catch (\Throwable $th) {
            throw $th;
        }

    }

    protected function delete(array $fileds) {

        $table = $this->getTableName();

        try {

            if (empty($fileds))
                throw new \Exception("Error fields empty");

            $strValues = "";

            foreach ($fileds as $key => $value) {
                $strValues .= "`$key` = :$key, ";
                $params[$key] = $value;
            }

            $query = self::$connect->prepare("INSERT INTO `$table` SET $strValues");
            if ($query->execute($params)){
                return intval(self::$connect->lastInsertId());
            } else {
                throw new \Exception("Error - ".$query->errorInfo());
            }
            
        } catch (\Throwable $th) {
            throw $th;
        }

    }
}