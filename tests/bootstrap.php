<?php
/**
 * Created by PhpStorm.
 * User: laiconglin
 * Date: 26/11/2017
 * Time: 14:00
 */

// timezone init
date_default_timezone_set('Asia/Shanghai');
define('APP_ROOT', realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR));

define('CONFIG_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config_path' . DIRECTORY_SEPARATOR);
define('ENVIRONMENT', 'develop');

// autoload
require APP_ROOT . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';



