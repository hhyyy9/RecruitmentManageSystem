<?php

class Services_EditAppliedInfoServiceModel extends Services_BaseServiceModel {

   
    /**
     * @desc check input, if check fail will throw Exception()
     */
    protected function checkParam(){
        // check param by ruler
        $checkRet = Utils::checkParamsByRulers($this->_request['post'], 'post', 'editappliedinfo');
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


        // pack update data
        $updateData = array(
            'status' => $this->_request['post']['status'],
            'has_mailed' => $this->_request['post']['has_mailed'] ? 1 : 0,
            'updated_time' => date("Y-m-d H:i:s"),
        );
        $id = $this->_request['post']['applied_id'];

        // update data
        $effectedRow = Dao_ApplyInfoModel::updateAppliedInfos($id, $updateData);

        // set value to $_ret;
        $this->_ret['updated_cnt'] = $effectedRow;
    }

} 