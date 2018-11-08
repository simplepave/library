<?php if (!defined('ABSPATH')) exit('No direct script access allowed');

/**
 * Project: Validation
 */

/**
 * @SimplePAVE
 * https://t.me/SimplePAVE
 * info@simplepave.ru
 */

/**
 * Test var_dump()
 */

if (!function_exists('dump')) {
    function dump($name, $print = 'var_dump') {
        global $sp_valid;

        if ($res = $sp_valid->$name()) {
            echo '<hr><br>';
            echo $name;
            echo '<br><br>';
            if ($print == 'var_dump')
                var_dump($res);
            else print_r($res);
            echo '<br>';
        }
    }
}

/**
 * Test template
 */

if (!function_exists('sp_test')) {
    function sp_test($name) {
        global $sp_valid;
        return !@include(ABSPATH . $name . '.php');
    }
}