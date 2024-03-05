<?php

/**
 * @desc Api controller, all the actions map will be 
 * declared here.
 * @author Yuqi Wang
 * @date 2024/02/24
 */
class ApiController extends Yaf_Controller_Abstract {

    public function init() {
        Yaf_Dispatcher::getInstance()->disableView();
    }

    public $actions = array(
        "publishposition" => "actions/PublishPosition.php",
        "updateposition" => "actions/UpdatePosition.php",
        "getpositionlist" => "actions/GetPositionList.php",
        "apply" => "actions/Apply.php",
        "getappliedinfolist" => "actions/GetAppliedInfoList.php",
        "editappliedinfo" => "actions/EditAppliedInfo.php",
        "login" => "actions/Login.php",

    );
}