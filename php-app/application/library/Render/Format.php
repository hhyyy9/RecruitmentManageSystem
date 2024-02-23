<?php

final class Render_Format {

    /**
     * @desc util function for json output render
     * @author richard
     * @date 2024/02/24
     * @param $code int
     * @param $data array()
     * @param $extraMessage string
     * @return json string
     */
    public static function JsonOutput($code, $data, $extraMessage=''){
        
        $data = is_array($data) ? $data : array();
        $message = (isset(ErrorCode::$errorMessage[$code]) && strlen(ErrorCode::$errorMessage[$code]) > 0) 
                ? ErrorCode::$errorMessage[$code] 
                : ErrorCode::$errorMessage[ErrorCode::CODE_UNKNOW];
        $code = isset(ErrorCode::$errorMessage[$code]) ? $code : ErrorCode::CODE_UNKNOW;
        
        $outPut = array(
            'error_no' => $code,
            'error_message' => $message . " " . $extraMessage,
            "data" => $data,
        );
        $outPutJson = json_encode($outPut);
        echo $outPutJson;
    }

}