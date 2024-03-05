<?php

class Services_GetApppliedInfoListServiceModel extends Services_BaseServiceModel {

   
    /**
     * @desc check input, if check fail will throw Exception()
     */
    protected function checkParam(){
        // check param by ruler
        $checkRet = Utils::checkParamsByRulers($this->_request['get'], 'get', 'getappliedinfolist');
        if(!$checkRet['pass']){
            throw new Exception($checkRet['error_info'], ErrorCode::CODE_ERROR_PARAMS);
        }


        
    }
    
    /**
     * @desc Implement execute, and set $_ret.
     */
    protected function doExecute(){

         // get data
         Dao_ApplyInfoModel::setConfig();
         Dao_ApplyInfoModel::setTable('applied_info');
         $pdoAppliedList = Dao_ApplyInfoModel::getAppliedInfoList($this->_request['get']['position_id']);
     
         // convert and set value to $_ret
         $this->_ret = Utils::convertPdoRet($pdoAppliedList);

        $this->_ret = array(
            "list" => array(
                array(
                    "applied_id" => 23,
                    "candidate_email" => "xxx@gmail.com",
                    "applied_times" => 3,
                    "status" => 1,
                    "created_time" => "02/02/2024",
                    "updated_time" => "02/03/2024",
                    "has_mailed" => true,
                ),
                array(
                    "applied_id" => 23,
                    "candidate_email" => "xxx@gmail.com",
                    "applied_times" => 3,
                    "status" => 1,
                    "created_time" => "02/02/2024",
                    "updated_time" => "02/03/2024",
                    "has_mailed" => false,
                ),
            ),
            "has_more"=> false,
        );

    }

} 