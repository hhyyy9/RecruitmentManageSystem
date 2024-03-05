<?php

class Services_PublishPositionServiceModel extends Services_BaseServiceModel {

   
    /**
     * @desc check input, if check fail will throw Exception()
     */
    protected function checkParam(){
        // check param by ruler
        $checkRet = Utils::checkParamsByRulers($this->_request['post'], 'post', 'publishposition');
        if(!$checkRet['pass']){
            throw new Exception($checkRet['error_info'], ErrorCode::CODE_ERROR_PARAMS);
        }


        
    }
    
    /**
     * @desc Implement execute, and set $_ret.
     */
    protected function doExecute(){
        $this->_ret = array();

        Dao_PositionInfoModel::setConfig();
        Dao_PositionInfoModel::setTable('position_info');


        $newPostionInfo = array(
            'published_employer_id' => $this->_request['post']['employer_id'],
            'planed_hired_num' => $this->_request['post']['planed_hired_num'],
            'applied_num' => 0,
            'salary_range' => $this->_request['post']['salary_range'],
            'location' => $this->_request['post']['location'],
            'status' => 1,
            'position_name' => $this->_request['post']['position_name'],
            'postion_desc'=> $this->_request['post']['desc'],
            'start_time' => $this->_request['post']['start_time'],
            'end_time' => $this->_request['post']['end_stime'],
            'created_time' => date("Y-m-d H:i:s"),
            'updated_time' => date("Y-m-d H:i:s"),
        );
        $insertData[] = $newPostionInfo;
        
        // insert data
        $effectedRow = Dao_PositionInfoModel::addPositionInfos($insertData);
        
        // set value to $_ret
        $this->_ret['add_cnt'] = $effectedRow;

        return;
    }

} 