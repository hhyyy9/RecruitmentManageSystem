<?php

/**
 * @desc Just A simple singleton dao base class based on pdo
 * @author Yuqi Wang
 * @date 2024/02/24
 */
class Dao_BaseModel {

    protected static $_table = "";

    private static $_config = array();

    private static $_instance;

    private function __constructor(){}

    private function __clone(){}

    protected static function getInstance(){
        if (!self::$_instance){
            if (empty(self::$_config) || !isset(self::$_config['host']) || !isset(self::$_config['user']) 
            || !isset(self::$_config['pass']) || !isset(self::$_config['database'])) {
                $config = Yaf_Application::app()->getConfig()->toArray();
                self::$_config = (isset($config['mysql']) && !empty($config['mysql']))
                ? $config['mysql']
                : array();
            }
            if (empty(self::$_config)) {
                throw new Exception("DB init config is missing, please check!", ErrorCode::CODE_DB_ERROR);
            }
            $dsn = "mysql:host=" . self::$_config["host"] . ";dbname=" . self::$_config["database"];
	        self::$_instance = new PDO($dsn, self::$_config["username"], self::$_config["pass"]);
	        // open pdo exception
            self::$_instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$_instance;
    }
    
    /**
     * @desc get data derictly use sql
     * @param $sql string
     * @return array()
     */
    public static function getAll($sql){
        $ret = array();
        try{
            $instance = self::getInstance();
            $stateMent = $instance->prepare($sql);
            $stateMent->execute();
            
            $ret = $stateMent->fetchAll();
        }catch(PDOException $e){
            throw new Exception($e->getMessage(), ErrorCode::CODE_DB_ERROR);
        }
        return $ret;
    }

    /**
     * @desc close connection
     */
    function __destruct(){
        self::$_instance = null;
    }

}
