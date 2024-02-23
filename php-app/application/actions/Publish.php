<?php

/**
 * @desc action for publish
 * @athor Yuqi Wang
 * @date 2024/02/24
 */
class PublishAction extends Yaf_Action_Abstract {
    public function execute(){

        
        $servicePublish = new Services_PublishPositionModel();
    
        $servicePublish->execute();
        $ret = $servicePublish->getRet();
        
        // render rest
        if(is_array($ret)){
            Render_Format::JsonOutput(ErrorCode::CODE_SUCESS, $ret, '');
        }else{
            throw new Exception(ErrorCode::errorMessage[ErrorCode::CODE_ERROR_SERVICE_FAIL], ErrorCode::CODE_ERROR_SERVICE_FAIL);
        }
    }
}