<?php

class Services_UploadCsvServiceModel extends Services_BaseServiceModel {

    /**
     * File key name same as the FE's form key
     */
    const CSV_FILE_NAME = 'employee_infos_csv';

    /**
     * Accptable file types
     */
    private $_accptableTypes = array(
        'text/csv',
        'text/plain',
    );

    /**
     * map csv to db column
     */
    private $_csvColumnToDb = array(
        'company_name',
        'employee_name',
        'email',
        'salary',
    );

    /**
     * data type for type convert
     */
    private $_dataTypeMap = array(
        'company_name' => 'str',
        'employee_name'=> 'str',
        'email' => 'str',
        'salary' => 'int',
    );

    /**
     * @desc check input, if check fail will throw Exception()
     */
    protected function checkParam(){
        // sign check
        if(!Utils::signCheck($this->_request['post'], $this->_request['user_info']['access_token'])){
            throw new Exception('sign check fail, you are not allowed to request this api', ErrorCode::CODE_USER_CHECK_ERROR);
        }
        // file type check
        if(!$this->checkCsvFile()){
            throw new Exception('illegal file type, please check and reupload!', ErrorCode::CODE_ERROR_PARAMS);
        }
        
    }
    
    /**
     * @desc csv file check, Mainly to aviod security issues
     * @param void
     * @return bool
     */
    private function checkCsvFile(){
        $ret = true;
        
        if(isset($this->_request['files'][self::CSV_FILE_NAME]) && !empty($this->_request['files'][self::CSV_FILE_NAME]
        && file_exists($this->_request['files'][self::CSV_FILE_NAME]['tmp_name']))){
            // file extension check
            if(!in_array($this->_request['files'][self::CSV_FILE_NAME]['type'], $this->_accptableTypes)){
                $ret = false;
            }

            // read file to get real MIME, in case of fake file type extension
            $filename = $this->_request['files'][self::CSV_FILE_NAME]['tmp_name'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $filename);
            if(!in_array($mime, $this->_accptableTypes)){
                // if file still exist delete it
                if(file_exists($filename)){
                    unlink($filename);
                }
                $ret = false;
            }
            finfo_close($finfo);
        }

        return $ret;
    }

    /**
     * @desc Implement execute, and set $_ret.
     */
    protected function doExecute(){
        $this->_ret = array(
            'add_cnt'=>0,
        );

        Dao_EmployeeInfoModel::setConfig();
        Dao_EmployeeInfoModel::setTable('employee_info');

        // read csv content and pack insert data
        $content = null;
        $insertData = array();
        if(file_exists($this->_request['files'][self::CSV_FILE_NAME]['tmp_name'])){
            $content = file_get_contents($this->_request['files'][self::CSV_FILE_NAME]['tmp_name']);
        }
        
        if(!is_null($content) && !empty($content)){
            $eachLineArr = explode("\n", $content);
            foreach($eachLineArr as $lineNum => $eachLine){
                if($lineNum > 0){
                    $eachColumnArr = (count(explode(",", $eachLine)) == 0) ? explode("\t", $eachLine) : explode(",", $eachLine);
                    $eachInsertData = array();
                    if(count($eachColumnArr) == count($this->_csvColumnToDb)){
                        foreach($eachColumnArr as $key=>$eachValue){
                            addslashes($eachValue);
                            htmlspecialchars($eachValue);
                            switch($this->_dataTypeMap[$this->_csvColumnToDb[$key]]){
                                case 'str':
                                    $eachInsertData[$this->_csvColumnToDb[$key]] = strval($eachValue);
                                case 'int':
                                    $eachInsertData[$this->_csvColumnToDb[$key]] = intval($eachValue);
                                default:
                                    $eachInsertData[$this->_csvColumnToDb[$key]] = $eachValue;
                            }
                            
                        }
                        $eachInsertData['created_time'] = date("Y-m-d H:i:s");
                        $eachInsertData['updated_time'] = date("Y-m-d H:i:s");
                        $insertData[] = $eachInsertData;
                    }
                }
            }
        }
        
        // insert data
        $effectedRow = Dao_EmployeeInfoModel::addEmployeeInfos($insertData);
        
        // set value to $_ret
        $this->_ret['add_cnt'] = $effectedRow;
    }

} 