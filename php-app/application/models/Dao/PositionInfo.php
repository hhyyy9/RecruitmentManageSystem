<?php

/**
 * @desc For position Info logic
 */
class Dao_PositionInfoModel extends Dao_BaseModel {

    private static $_columnFileds = array(
        'published_employer_id',
        'planed_hired_num',
        'applied_num',
        'status',
        'position_name',
        'salary_range',
        'postion_desc',
        'start_time',
        'end_time',
        'created_time',
        'updated_time',
        'location',
    );


    private static $_columnFiledsType = array(
        'published_employer_id' => PDO::PARAM_INT,
        'planed_hired_num' => PDO::PARAM_INT,
        'applied_num' => PDO::PARAM_INT,
        'status' => PDO::PARAM_INT,
        'salary_range' => PDO::PARAM_STR,
        'location' => PDO::PARAM_STR,
        'position_name' => PDO::PARAM_STR,
        'postion_desc'=> PDO::PARAM_STR,
        'start_time' => PDO::PARAM_STR,
        'end_time'=> PDO::PARAM_STR,
        'created_time' => PDO::PARAM_STR,
        'updated_time'=> PDO::PARAM_STR,
    );


    /**
     * @desc can set different DB config for different logic
     * @param void
     * @return void
     */
    public static function setConfig(){}

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
    public static function addPositionInfos($infos){
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
            $insertSql = "insert into %s(%s) values %s ";
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
    * @desc get getPositionList
    * @param viod
    * @return array
    */
    public static function getPositionList(){

        $ret = array();
        try{
            // $sql = sprintf("select id as position_id, published_employer_id as employer_id, planed_hired_num, 
            // applied_num, status, position_name, postion_desc as desc, start_time, end_time,
            // created_time, updated_time  from %s", self::$_table);
            $sql = "select p.salary_range as salary_range, p.id as position_id, p.published_employer_id as employer_id, p.planed_hired_num as planed_hired_num, 
            p.position_name as position_name, p.postion_desc as postion_desc, p.start_time as start_time, p.end_time as end_time,
            p.created_time as created_time, p.updated_time as updated_time, e.company_name as employer_name, e.employer_icon as employer_icon 
            from position_info as p left join employer_info as e on p.published_employer_id=e.id
            where p.status=1";
            $ret = self::getAll($sql);
        }catch(PDOException $e){
            throw new Exception($e->getMessage(), ErrorCode::CODE_DB_ERROR);
        }
        return $ret;
    }


    /**
     * @desc Update position's info by id
     * @param $id int
     * @param $updateInfos array(culumn_name=>update_value,...)
     * @return int
     */
    public static function updatePositionInfos($id, $updateInfos){
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