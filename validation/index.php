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
 *   $sp_valid = new SP_Validation([bool $pullout = true][, bool $auto_test_on = false]);
 *
 *   $sp_valid->set_auto_test(array $seeds);
 *   $sp_valid->set_language(array $language);
 *
 *   $sp_valid->validation(array $request, array $validation[, string $bail = false]); $bail: 'all', 'rev'
 *
 *   $sp_valid->status = null | false | true
 *
 *   $sp_valid->get_empties();
 *   $sp_valid->get_errors();
 *   $sp_valid->get_fields([string $key = false]); $key: 'all', ['title'], [...]
 *   $sp_valid->get_form(string $name); return trim($request[$name]) or false
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
