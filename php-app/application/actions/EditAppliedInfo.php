<?php

/**
 * @desc action for update
 * @athor Yuqi Wang
 * @date 2024/02/27
 */
class EditAppliedInfoAction extends Yaf_Action_Abstract {
    public function execute(){

        
        $servicePublish = new Services_EditAppliedInfoServiceModel();
    
        $servicePublish->execute();
        $ret = $servicePublish->getRet();
        $ret = array();
        // render rest
        if(is_array($ret)){
            Render_Format::JsonOutput(ErrorCode::CODE_SUCESS, $ret, '');
        }else{
            throw new Exception(ErrorCode::errorMessage[ErrorCode::CODE_ERROR_SERVICE_FAIL], ErrorCode::CODE_ERROR_SERVICE_FAIL);
        }
    }
}