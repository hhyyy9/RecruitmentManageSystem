<?php

class Utils {

    /**
     * @desc params check by rulers
     * @param $params array()
     * @param $method string
     * @return mixed
     */
    public static function checkParamsByRulers($params, $method, $page){
        $ret = array(
            'pass'=>true,
            'error_info'=>'',
        );
        $config = Yaf_Application::app()->getConfig()->toArray();
        $rulers = $config['param_ruler'][$page];
        if(is_array($rulers) && count($rulers) > 0 && in_array($method, array('post','get'))){
            foreach($rulers[$method] as $key=>$ruler){
                if($ruler['required'] && !isset($params[$key])){
                    $ret['pass'] = false;
                    $ret['error_info'] = "missing required param $key";
                    break;
                }
                if(isset($params[$key])) {
                    switch($ruler['type']){
                        case 'int':
                            $ret = !is_numeric($params[$key]) 
                            ? array('pass'=>false, 'error_info'=>"$key type error must be int") 
                            : $ret;
                            break;
                        case 'str':
                            $ret = !is_string($params[$key]) 
                            ? array('pass'=>false, 'error_info'=>"$key type error must be str") 
                            : $ret;
                            break;
                        default:
                            $ret = $ret;
                    }
                }
            }
        }

        return $ret;
    }

    /**
     * @desc convert pdo ret to key=value map
     * @param $pdoArr array
     * @return array
     */
    public static function convertPdoRet($pdoArr){
        $ret = array();

        if(count($pdoArr) > 0 && is_array($pdoArr)){
            foreach($pdoArr as $value){
                $recordTmpArr = array();
                foreach($value as $key=>$columnValue){
                    if(is_string($key)){
                        $recordTmpArr[strtolower($key)] = $columnValue;
                    }
                    if($key == "postion_desc"){
                        $recordTmpArr['desc'] = $columnValue;
                    }

                    if($key == "employer_icon"){
                        $recordTmpArr['employer_icon'] = 'https://sourceonetech.com/wp-content/uploads/2015/03/mobile-icon-png-mobile-icon-free-flat-multimedia-iconset-designbolts-18.png';
                    }

                    if(in_array($key, array('employer_id', 'planed_hired_num'))){
                        $recordTmpArr[strtolower($key)] = intval($columnValue);
                    }
                }
                $ret[] = $recordTmpArr;
            }
        }

        return $ret;
    }

}