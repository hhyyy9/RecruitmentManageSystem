<?php

class Services_LoginServiceModel extends Services_BaseServiceModel {

   
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

        if($this->_request['post']['username'] != Constant::TMP_USER_NAME || md5($this->_request['post']['pass']) != Constant::TMP_PASS){
            throw new Exception("login fail", ErrorCode::CODE_ERROR_PARAMS);
        }
        
    }

} 