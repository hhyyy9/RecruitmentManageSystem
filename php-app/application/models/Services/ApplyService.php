<?php

class Services_ApplyServiceModel extends Services_BaseServiceModel {

   
    /**
     * @desc check input, if check fail will throw Exception()
     */
    protected function checkParam(){
        // check param by ruler
        $checkRet = Utils::checkParamsByRulers($this->_request['post'], 'post', 'apply');
        if(!$checkRet['pass']){
            throw new Exception($checkRet['error_info'], ErrorCode::CODE_ERROR_PARAMS);
        }


        
    }
    
    /**
     * @desc Implement execute, and set $_ret.
     */
    protected function doExecute(){
        $this->_ret = array();
    }

} 