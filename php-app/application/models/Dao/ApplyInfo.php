<?php

/**
 * @desc For employer Info logic
 */
class Dao_ApplyInfoModel extends Dao_BaseModel {


    private static $_columnFileds = array(
        'candidate_email',
        'position_id',
        'applied_times',
        'status',
        'has_mailed',
        'created_time',
        'updated_time',
    );

    private static $_columnFiledsType = array(
        'candidate_email' => PDO::PARAM_STR,
        'position_id'=> PDO::PARAM_INT,
        'applied_times' => PDO::PARAM_INT,
        'status' => PDO::PARAM_INT,
        'has_mailed' => PDO::PARAM_INT,
        'created_time' => PDO::PARAM_STR,
        'updated_time'=> PDO::PARAM_STR,
    );

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


    /**
     * @desc Insert positions
     * @param $infos array(
     *                      array(
     *                          'column_name'=>'column_value',
     *                          ....
     *                      ),
     *                      ....
     *                     )
     * @return int 
     */
    public static function addApplyInfos($infos){
        $ret = 0;
        $instance = self::getInstance();
        if(is_array($infos) && !empty($infos)){
            $recordNum = count($infos);
            $eachValuePlaceHolder = implode(',', array_fill(0, count(self::$_columnFileds), '?'));
            $placeHolder = implode(',', array_fill(0, $recordNum, "($eachValuePlaceHolder)"));
            $fileds = '';
            foreach(self::$_columnFileds as $column){
                $fileds .= "`$column`,";
            }
            $fileds = substr($fileds, 0, -1);
            $insertSql = "insert into %s(%s) values %s on duplicate key update `applied_times`=applied_times+1";
            $insertSql = sprintf($insertSql, self::$_table, $fileds, $placeHolder);
            $stateMent = $instance->prepare($insertSql);
            $i = 1;
            foreach($infos as $eachRecord){
                if (count($eachRecord) == count(self::$_columnFileds)){
                    foreach(self::$_columnFileds as $column){
                        if(isset($eachRecord[$column])){
                            addslashes($eachRecord[$column]);
                            htmlspecialchars($eachRecord[$column]);
                            $stateMent->bindParam($i, $eachRecord[$column], self::$_columnFiledsType[$column]);
                        }else{
                            // if not insert use empty value based on it's datatype to fulfill
                            switch (self::$_columnFiledsType[$column]) {
                                case PDO::PARAM_STR:
                                    $tmp = Constant::DEFAULT_STR;
                                    $stateMent->bindParam($i, $tmp, PDO::PARAM_STR);
                                    break;
                                case PDO::PARAM_INT:
                                    $tmp = Constant::DEFAULT_INT;
                                    $stateMent->bindParam($i, $tmp, PDO::PARAM_INT);
                                    break;
                            }
                        }
                        $i++;
                    }
                }else{
                    throw new Exception('record missided some colums, please check', ErrorCode::CODE_DB_ERROR);
                    break;
                }   
            }

            try{
                $stateMent->execute();
                $ret = $stateMent->rowCount();
            }catch(PDOException $e){
                throw new Exception($e->getMessage(), ErrorCode::CODE_DB_ERROR);
            }
        }
        return $ret;
    }

     /**
    * @desc get getAppliedInfoList
    * @param viod
    * @return array
    */
    public static function getAppliedInfoList($positionId){

        $ret = array();
        try{
            $sql = sprintf("select id as applied_id, candidate_email, applied_times, 
            status, has_mailed, created_time, updated_time  from %s where position_id = %d", 
            self::$_table, $positionId);
            $ret = self::getAll($sql);
        }catch(PDOException $e){
            throw new Exception($e->getMessage(), ErrorCode::CODE_DB_ERROR);
        }
        return $ret;
    }


    /**
     * @desc Update applied's info by id
     * @param $id int
     * @param $updateInfos array(culumn_name=>update_value,...)
     * @return int
     */
    public static function updateAppliedInfos($id, $updateInfos){
        $ret = 0;
        $instance = self::getInstance();
        $updatePlaceHolder = '';
        $updateSql = '';
        if ($id > 0 && count($updateInfos) > 0){
            foreach($updateInfos as $column=>$value){
                if (in_array($column, self::$_columnFileds)) {
                    switch (self::$_columnFiledsType[$column]) {
                        case PDO::PARAM_STR:
                            $updatePlaceHolder .= " `$column`= '$value' and";
                            break;
                        case PDO::PARAM_INT:
                            $updatePlaceHolder .= " `$column`= $value and";
                            break;
                    }
                }
            }
            $updatePlaceHolder = substr($updatePlaceHolder, 0, -4);
            if(strlen($updatePlaceHolder) > 0) {
                $updateSql = sprintf("update %s set %s where id=%d", self::$_table, $updatePlaceHolder, intval($id));
            }else{
                throw new Exception('update column fail, please check!', ErrorCode::CODE_DB_ERROR);
            }

            try{
                $stateMent = $instance->prepare($updateSql);
                $stateMent->execute();
                $ret = $stateMent->rowCount();
            }catch(PDOException $e){
                throw new Exception($e->getMessage(), ErrorCode::CODE_DB_ERROR);
            }
        }

        return $ret;
    }
}