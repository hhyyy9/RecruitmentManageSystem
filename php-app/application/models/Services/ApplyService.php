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


        Dao_ApplyInfoModel::setConfig();
        Dao_ApplyInfoModel::setTable('applied_info');


        $newApply = array(
            'candidate_email' => $this->_request['post']['candidate_email'],
            'position_id' => $this->_request['post']['position_id'],
            'status' => 0,
            'created_time' => date("Y-m-d H:i:s"),
            'updated_time' => date("Y-m-d H:i:s"),
            'has_mailed' => 0,
            'applied_times' => 1,
        );
        $insertData[] = $newApply;
        
        // insert data
        $effectedRow = Dao_ApplyInfoModel::addApplyInfos($insertData);
        
        // set value to $_ret
        $this->_ret['add_cnt'] = $effectedRow;
    }

} 