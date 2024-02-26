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
        "publish_position" => "actions/PublishPosition.php",
        "update_position" => "actions/UpdatePosition.php",
        "getpositionlist" => "actions/GetPositionList.php",
        "apply" => "actions/Apply.php",
        "get_applied_info_list" => "actions/GetApppliedInfoList.php",
        "edit_applied_info" => "actions/EditAppliedInfo.php",
    );
}