<?php if (!defined('ABSPATH')) exit('No direct script access allowed');

/**
 * Project: Validation
 */

/**
 * @SimplePAVE
 * https://t.me/SimplePAVE
 * info@simplepave.ru
 */

if (!function_exists('dump')) {

    /**
     * Test dump
     */

    function dump($name)
    {
        global $sp_valid;

        if ($res = $sp_valid->$name()) {

            switch ($name) {
                case 'get_errors':
                        $s_class = $d_class = 'text-danger';
                    break;
                case 'get_fields':
                        $s_class = $d_class = 'text-success';
                    break;
                case 'get_auto_test':
                        $s_class = $d_class = 'text-warning';
                    break;
                default:
                        $d_class = 'text-white';
                        $s_class = 'text-dark';
                    break;
            }

            $count = count($res);

            if ($name === 'get_fields') {
                foreach ($res as $key => $value) {
                    if ($key == 'all' || $key == 'title')
                        $first_banges .= '<span class="badge bg-' . ($key == 'title'? 'warning': 'success') . ' ml-2 text-white">' . $key . '<span class="ml-1 text-dark">' . count($value) . '</span></span>';
                    else
                        $badges .= '<span class="badge bg-white ml-2 text-info">' . $key . '<span class="ml-1 text-dark">' . count($value) . '</span></span>';
                }

                $badges = $first_banges . $badges;
            }

            $outer .= '<hr>';
            $outer .= '<div class="block-striped border border-secondary d-inline-block bg-dark py-1 px-2 rounded ' . $d_class . '">' . $name . (isset($badges)? $badges: '<span class="badge bg-white ml-2 ' . $s_class . '">' . $count . '</span>') . '</div>';
            $outer .= '<br><br>';
            $outer .= '<div class="container px-0 ml-0">';

            if ($name === 'get_fields' || $name == 'get_errors')
                $outer .= _fields($res, $name);
            else {
                $outer .= '<table class="sp-table table table-hover table-sm"><tbody>';

                foreach ($res as $key => $item) {
                    if ($name == 'get_auto_test') {
                        $outer .= '<tr><td>[' . $key . '] => </td>';
                        $outer .= '<td>"' . $item . '"</td></tr>';
                    }
                    else $outer .= '<tr><td>[' . $item . ']</td></tr>';
                }
                $outer .= '</tbody></table>';
            }
            $outer .= '</div>';
        }

        echo $outer;
    }

    /**
     * Fields
     */

    function _fields($items, $name, $i = 0, $k = '')
    {
        $i++;

        if ($i == 1)
            $first_key = array_key_first($items);

        foreach ($items as $key => $item) {

            if ($i == 1) {
                $color = ' text-info';
                $active = '';

                if ($name == 'get_fields') {
                    if ($key == 'all') $color = ' text-success';
                    if ($key == 'title') $color = ' text-warning';
                }

                if ($key == $first_key)
                    $active = ' active';

                $outer .= '<div role="tabpanel" class="tab-pane' . $active . '" id="tab-' . $key . '">';
                $outer .= '<table class="sp-table table table-hover table-sm">';
                // $outer .= '<thead class="thead-light"><tr><th class="' . $color . '" colspan="2">[' . $key . '] => </th></tr></thead>';
            }

            if ($i == 2) {
                $outer .= '<tbody><tr><td>[' . $key . '] => </td><td>';

                if ($name == 'get_fields') {
                    $value = '"' . $item . '"';

                    if (is_bool($item))
                        $value = $item['value']? 'true': 'false';

                    if (is_array($item))
                        $value = '[' . implode('][', $item) . ']';

                    $outer .= ($k != 'title'? '(<span class="badge bg-white px-0">' . gettype($item) . '</span>)': '') . (string)$value;
                }

                if ($name == 'get_errors')
                    $outer .= '"' . $item . '"';

                $outer .= '</td></tr></tbody>';
            }

            if ($i == 1) {
                $outer .= _fields($item, $name, $i, $key);
                $outer .= '</table></div>';

                if ($name == 'get_fields' && in_array($key, ['all', 'title'])) {
                    $first_tablist .= '<li role="presentation" class="nav-item"><a class="nav-link' . $color . $active . '" href="#tab-' . $key . '" role="tab" data-toggle="tab">[' . $key . ']</a></li>';
                    $first_groups .= $outer;
                } else {
                    $tablist .= '<li role="presentation" class="nav-item"><a class="nav-link' . $color . $active . '" href="#tab-' . $key . '" role="tab" data-toggle="tab">[' . $key . ']</a></li>';
                    $groups .= $outer;
                }

                unset($outer);
            }
        }

        if ($i == 1)
            $outer = '<ul class="sp-nav-session' . ($name == 'get_errors'? ' sp-nav': '') . ' nav nav-' . ($name == 'get_fields'? 'tabs': 'pills') . '" role="tablist">' . $first_tablist . $tablist . '</ul><div class="sp-tab-session tab-content">' . $first_groups . $groups . '</div>';

        return $outer;
    }
}

/**
 * Test template
 */

if (!function_exists('sp_test')) {
    function sp_test($name)
    {
        global $sp_valid;
        return @include(ABSPATH . $name . '.php');
    }
}

/**
 * array_key_first
 */

if (!function_exists('array_key_first')) {
    function array_key_first(array $array)
    {
        if (count($array)) {
            reset($array);
            return key($array);
        }

        return null;
    }
}