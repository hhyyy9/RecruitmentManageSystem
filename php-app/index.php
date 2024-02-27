<?php
header("Access-Control-Allow-Origin *");
define("APP_PATH",  dirname(__FILE__));
$app  = new Yaf_Application(APP_PATH . "/conf/application.ini");
try {
    $app->bootstrap()->run();
}catch(Exception $e){
    Render_Format::JsonOutput($e->getCode(), array(), $e->getMessage());
}


