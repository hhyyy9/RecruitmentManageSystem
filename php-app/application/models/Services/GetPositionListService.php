<?php

class Services_GetPositionListServiceModel extends Services_BaseServiceModel {

   
    /**
     * @desc check input, if check fail will throw Exception()
     */
    protected function checkParam(){
        // check param by ruler
        $checkRet = Utils::checkParamsByRulers($this->_request['get'], 'get', 'getpositionlist');
        if(!$checkRet['pass']){
            throw new Exception($checkRet['error_info'], ErrorCode::CODE_ERROR_PARAMS);
        }


        
    }
    
    /**
     * @desc Implement execute, and set $_ret.
     */
    protected function doExecute(){

        $this->_ret = array(

            "list" => array(
                array(
                    "position_id" => 1,
                    "employer_id" => 2,
                    "desc" => "Job DescJob DescJob DescJob DescJob Desc\nJob DescJob DescJob Desc\n",
                    "employer_name" => "Google",
                    "start_time" => "02/02/2024",
                    "end_time" => "02/03/2024",
                    "updated_time" => "02/03/2024",
                    "salary_range" => "$90000-$100000",
                ),
                array(
                    "position_id" => 2,
                    "employer_id" => 2,
                    "desc" => "Job DescJob DescJob DescJob DescJob Desc\nJob DescJob DescJob Desc\n",
                    "employer_name" => "Google",
                    "start_time" => "02/02/2024",
                    "end_time" => "02/03/2024",
                    "updated_time" => "02/03/2024",
                    "salary_range" => "$90000-$120000",
                ),
            ),

            "has_more"=> false,

        );

    }

} 