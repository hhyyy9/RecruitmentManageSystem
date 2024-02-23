<?php

class Services_GetAvarageSalaryServiceModel extends Services_BaseServiceModel {

    protected function checkParam(){

        // sign check
        if(!Utils::signCheck($this->_request['get'], $this->_request['user_info']['access_token'])){
            throw new Exception('sign check fail, you are not allowed to request this api', ErrorCode::CODE_USER_CHECK_ERROR);
        }

        // check param by ruler
        $checkRet = Utils::checkParamsByRulers($this->_request['get'], 'get', 'getemployeelist');
        if(!$checkRet['pass']){
            throw new Exception($checkRet['error_info'], ErrorCode::CODE_ERROR_PARAMS);
        }


    }

    protected function doExecute(){
        $this->_ret = array();

        // get data
        Dao_EmployeeInfoModel::setConfig();
        Dao_EmployeeInfoModel::setTable('employee_info');
        $pdoaverageSalaryList = Dao_EmployeeInfoModel::getAvarageSalary();
    
        // convert and set value to $_ret
        $this->_ret = Utils::convertPdoRet($pdoaverageSalaryList);
    }

} 