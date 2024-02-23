<?php

/**
 * @desc For employer Info logic
 */
class Dao_EmployerInfoModel extends Dao_BaseModel {


    /**
     * @desc can set different DB config for different logic
     * @param void
     * @return void
     */
    public static function setConfig(){
        /*$config = Yaf_Application::app()->getConfig()->toArray();
                self::$_config = (isset($config['mysql']) && !empty($config['mysql']))
                ? $config['mysql']
                : array();
        self::$_config = $config['mysql'];*/
    }

    /**
     * @desc set table name
     * @param $table string
     * @return void
     */
    public static function setTable($table){
        self::$_table = $table;
    }

}