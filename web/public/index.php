<?php
require(dirname(__FILE__) . '/../vendor/autoload.php');
date_default_timezone_set('Europe/Moscow');
// change the following paths if necessary
$yii=dirname(__FILE__).'/../vendor/yiisoft/yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
if (getenv('APP_ENV') === 'development') {
    defined('YII_DEBUG') or define('YII_DEBUG',true);
}
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
