<?php

class Services_ModifyEmailServiceModel extends Services_BaseServiceModel {

    protected function checkParam(){
        // sign check
        if(!Utils::signCheck($this->_request['post'], $this->_request['user_info']['access_token'])){
            throw new Exception('sign check fail, you are not allowed to request this api', ErrorCode::CODE_USER_CHECK_ERROR);
        }
        
        // check param by ruler
        $checkRet = Utils::checkParamsByRulers($this->_request['post'], 'post', 'modifyemail');
        if(!$checkRet['pass']){
            throw new Exception($checkRet['error_info'], ErrorCode::CODE_ERROR_PARAMS);
        }

    }


    protected function doExecute(){
        $this->_ret = array(
            'updated_cnt'=>0,
        );

        
        Dao_EmployeeInfoModel::setConfig();
        Dao_EmployeeInfoModel::setTable('employee_info');

        // pack update data
        $updateData = array(
            'email' => $this->_request['post']['new_email'],
        );
        $id = $this->_request['post']['id'];

        // update data
        $effectedRow = Dao_EmployeeInfoModel::updateEmloyeeInfos($id, $updateData);

        // set value to $_ret;
        $this->_ret['updated_cnt'] = $effectedRow;
    }

} 