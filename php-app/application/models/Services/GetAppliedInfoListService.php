<?php

class Services_GetAppliedInfoListServiceModel extends Services_BaseServiceModel {

   
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

    }

} 