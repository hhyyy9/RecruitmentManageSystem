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
                if($ruler['required'] == "1" && !isset($params[$key])){
                    $ret['pass'] = false;
                    $ret['error_info'] = "missing required param $key";
                    break;
                }
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

        return $ret;
    }
}