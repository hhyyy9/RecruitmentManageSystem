<?php
/**
 * @desc Abstract base service class, just with params check, 
 * exec funcs and get ret in real product there could be more 
 * funcs define.
 * @author richard
 * @date 2024/02/15
 */
abstract class Services_BaseServiceModel {

    /**
     * @desc request data and user info reg in this var
     */
    protected $_request=array();

    /**
     * @desc final ret, will be setted at the end of doExecute() 
     * func.
     */
    protected $_ret=null;

    /**
     * @desc reg the request and set user info here
     */
    public function __construct() {
        $request = Yaf_Dispatcher::getInstance()->getRequest();
        $userInfo = array();
        // Dao_UserInfoModel::setConfig();
        // Dao_UserInfoModel::setTable('user_info');
        // $userInfo = Dao_UserInfoModel::getUserInfo();

        $this->_request = array(
            'post' => $request->getPost(),
            'get' => $request->getQuery(),
            'files' => $request->getFiles(),
            //'user_info' => $userInfo,
        );

    }

    /**
     * @desc Input params check, Implement in child class in specific
     * senarioas.
     * @param void
     * @return void
     */
    abstract protected function checkParam();

    /**
     * @desc Main logic fuction, Write core process logic in this func 
     * at child service class and set final rest in $_ret.
     * @param void
     * @return void
     */
    abstract protected function doExecute();

    /**
     * @desc Expose execute for caller at action layer.
     * @param void
     * @return void
     */
    public function execute(){
        $this->checkParam();
        $this->doExecute();
    }

    /**
     * @desc get final ret which be setted at doExecute() function.
     * @param void
     * @return array.
     */
    public function getRet(){
        return $this->_ret;
    }
}
        