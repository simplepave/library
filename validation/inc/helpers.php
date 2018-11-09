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

            switch ($name) {
                case 'get_errors':    $class = 'text-danger'; break;
                case 'get_fields':    $class = 'text-success'; break;
                case 'get_auto_test': $class = 'text-warning'; break;
                default: $class = 'text-white'; break;
            }

            echo '<hr>';
            echo '<div class="border border-secondary d-inline-block bg-dark py-1 px-2 rounded ' . $class . '">' . $name . '</div>';
            echo '<br><br>';

            if ($print == 'var_dump')
                var_dump($res);
            else print_r($res);
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