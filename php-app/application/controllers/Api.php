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
        "publish" => "actions/Publish.php",
    );
}