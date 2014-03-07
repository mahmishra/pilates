<?php

/**
 * This file contain error constant
 * 
 * @author M. Jumari <ari@ebizu.com>
 * @copyright (c) 2013, Ebizu Sdn. Bhd.
 * @version 1.0
 * @since 1.0
 */
$EBIZU_ERROR = array(
    array(
        'code' => 1,
        'description' => '?',
        'message' => 'General error'
    ),
    array(
        'code' => 20,
        'description' => 'Module [?] is not exists',
        'message' => 'Module not defined'
    ),
    array(
        'code' => 21,
        'description' => 'Action [?] is not exists',
        'message' => 'Action not defined'
    ),
    array(
        'code' => 500,
        'description' => '? with id [?] is not exists',
        'message' => 'Data not exists'
    ),
    array(
        'code' => 6,
        'description' => 'Error executing SQL query: ?',
        'message' => 'Error executing SQL query'
    ),
    array(
        'code' => 700,
        'description' => '? is required',
        'message' => 'Data required'
    ),
    array(
        'code' => 701,
        'description' => '? is required',
        'message' => 'Field required'
    ),
    array(
        'code' => 702,
        'description' => '? is invalid format ? ?',
        'message' => 'Invalid value'
    ),
    array(
        'code' => 703,
        'description' => '? is invalid format, ?',
        'message' => 'Invalid format'
    ),
    array(
        'code' => 704,
        'description' => '? is invalid value',
        'message' => 'Invalid value'
    ),
    array(
        'code' => 705,
        'description' => '? is invalid value, ?',
        'message' => 'Invalid value'
    ),
    array(
        'code' => 799,
        'description' => '? already registered',
        'message' => 'Already registered'
    ),
    array(
        'code' => 8,
        'description' => 'Invalid json request: ?',
        'message' => 'Invalid json request'
    ),
    array(
        'code' => 900,
        'description' => 'Invalid old password',
        'message' => 'Access denied, old password'
    ),
    array(
        'code' => 901,
        'description' => 'Invalid pin',
        'message' => 'Access denied, invalid pin'
    ),
    array(
        'code' => 995,
        'description' => 'Invalid username: ?',
        'message' => 'Access denied, invalid username'
    ),
    array(
        'code' => 996,
        'description' => 'Invalid password: ?',
        'message' => 'Access denied, invalid password'
    ),
    array(
        'code' => 997,
        'description' => 'Invalid username or password',
        'message' => 'Access denied, invalid username or password'
    ),
    array(
        'code' => 998,
        'description' => 'Invalid token: ?',
        'message' => 'Access denied, invalid token'
    ),
    array(
        'code' => 999,
        'description' => 'Unknown error: ?',
        'message' => 'Unknown error'
    )
);
?>
