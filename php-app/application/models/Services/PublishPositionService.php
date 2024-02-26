<?php

class Services_PublishPositionServiceModel extends Services_BaseServiceModel {

   
    /**
     * @desc check input, if check fail will throw Exception()
     */
    protected function checkParam(){
        // sign check
        if(!Utils::signCheck($this->_request['post'], $this->_request['user_info']['access_token'])){
            throw new Exception('sign check fail, you are not allowed to request this api', ErrorCode::CODE_USER_CHECK_ERROR);
        }

        
    }
    
    /**
     * @desc Implement execute, and set $_ret.
     */
    protected function doExecute(){
        $this->_ret = array();

        echo 'test';
    }

} 