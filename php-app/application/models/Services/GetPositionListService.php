<?php

class Services_GetPositionListServiceModel extends Services_BaseServiceModel {

   
    /**
     * @desc check input, if check fail will throw Exception()
     */
    protected function checkParam(){
        // check param by ruler
        $checkRet = Utils::checkParamsByRulers($this->_request['get'], 'get', 'getpositionlist');
        if(!$checkRet['pass']){
            throw new Exception($checkRet['error_info'], ErrorCode::CODE_ERROR_PARAMS);
        }


        
    }
    
    /**
     * @desc Implement execute, and set $_ret.
     */
    protected function doExecute(){



        $this->_ret = array();

        // get data
        Dao_PositionInfoModel::setConfig();
        Dao_PositionInfoModel::setTable('position_info');
        $pdoPositionList = Dao_PositionInfoModel::getPositionList();
    
        // convert and set value to $_ret
        $this->_ret = Utils::convertPdoRet($pdoPositionList);

    }

} 