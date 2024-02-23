<?php

/**
 * @desc a final error util class, all the error code and messages should be defined here.
 * @author richard
 * @date 2024/02/24
 */
final class ErrorCode {

    // sucess
    const CODE_SUCESS = 0;

    // unknow error
    const CODE_UNKNOW = -1;

    // params error
    const CODE_ERROR_PARAMS = 100;

    // service fail
    const CODE_ERROR_SERVICE_FAIL = 200;

    // DB error
    const CODE_DB_ERROR = 300;

    // auth error
    const CODE_USER_CHECK_ERROR = 400;

    // error message map
    public static $errorMessage = array(
        self::CODE_SUCESS => "success",
        self::CODE_UNKNOW => "unknow error",
        self::CODE_ERROR_PARAMS => "params error",
        self::CODE_ERROR_SERVICE_FAIL => "call service failed",
        self::CODE_DB_ERROR => "db error",
        self::CODE_USER_CHECK_ERROR => "auth check fail",
    );

}