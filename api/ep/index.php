<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With');

/**
 * This file is used as end point of API
 * 
 * @author M. Jumari <ari@ebizu.com>
 * @copyright (c) 2013, Ebizu Sdn. Bhd.
 * @version 1.0
 * @since 1.0
 */
include_once '../core/ebizu.php';

// get params
$params = Ebizu::getParams();

// include class module if exists
if (file_exists('../' . strtolower($params[0]) . '/index.php')) {
    include_once '../' . strtolower($params[0]) . '/index.php';
}
// include class action if exists
if (file_exists('../' . strtolower($params[0]) . '/' . strtolower($params[1]) . '.php')) {
    include_once '../' . strtolower($params[0]) . '/' . strtolower($params[1]) . '.php';
}
// create module object if exists
if (count($params) > 0) {
    header('content-type: application/json; charset=utf-8');
    $result = null;
    if (defined('EBIZU_MODULE')) {
        try {
            // create reference class
            $class = new ReflectionClass(EBIZU_MODULE);
            // create module instance
            $module = $class->newInstanceArgs();
            // init module 
            $module->init($params);
            // process module
            $module->process();
            // getting result
            $result = $module->getResult();
            // destroy module
            $module->destroy();
        } catch (Exception $e) {
            $result = Ebizu::error(999, array($e->getMessage()));
        }
    } else {
        $result = Ebizu::error(20, array($params[0]));
    }
    echo json_encode($result);
} else {
    echo Ebizu::read('welcome.html');
}
?>