<?php

/**
 * Project: Validation
 */

/**
 * @SimplePAVE
 * https://t.me/SimplePAVE
 * info@simplepave.ru
 */

/**
 *   $sp_valid = new SP_Validation(false) = get_fields => false
 *   $sp_valid = new SP_Validation((true || false), true) = auto_test => true
 *
 *   $sp_valid->set_bail_rev(); Revers Bail
 *   $sp_valid->set_bail_all(); ALL On Bail
 *
 *   $sp_valid->set_auto_test($seeds = array);
 *   $sp_valid->validation($request = array, $validation = array);
 *
 *   $sp_valid->get_form($name) === trim($request[$name]) || false
 *
 *   $sp_valid->get_errors()
 *   $sp_valid->get_empties()
 *   $sp_valid->get_fields([$key])
 *
 *   $sp_valid->get_auto_test() === $sp_valid->set_auto_test([])
 *
 *   * ************* *** ************* *
 *
 *   shield = ( | === \| )
 *
 *   |group:key[,key...]( not == |, all, title )| = group array key
 *   |title:title| = title parameter
 *   |bail|        = first error => break
 *   |required|    = required
 *
 *   |required|accepted|
 *   |string|min:3|max:255|confirmed:name[,title]|
 *   |numeric|between:0,99|
 *   |date|date_format:Y-m-d H:i:s|
 *   |regex:/^.+$/i ( \| === | )|float|email|
 *   |phone[:format]( return (mask)[+9 (999) 999-99-99] )|
 *   |parse_url[:( scheme | host | port | user | pass | path | query | fragment )]|
 *
 *    type = int | bool | float ( , or . ) | array
 *   |type:int|       = (int)$value
 *   |type:bool|      = (bool)$value
 *   |type:float|     = (float)str_replace(',', '.', $value)
 *   |type:array,|    === explode(' ', $value)
 *   |type:array,,|   === explode(',', $value)
 *   |type:array,\||  === explode('|', $value)
 *   |type:array,sep| === explode('sep', $value)
 *
 */

/**
 * include view
 */

$view = 'view-default';

/**
 * global path
 */

define('ABSPATH', dirname(__FILE__) . '/');

/**
 * Request
 */

$request_post = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST')
    $request_post = $_POST;

/**
 * test system
 */

require_once(ABSPATH . 'inc/system/engine.php');
