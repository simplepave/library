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
                $count = count($res['all']);

                foreach ($res as $key => $value) {
                    if ($key == 'all')
                        $badge .= '<span class="badge bg-success ml-2 text-white">' . $key . '</span>';
                    else
                        $badge .= '<span class="badge bg-white ml-2 text-info">' . $key . '<span class="ml-1 text-dark">' . count($value) . '</span></span>';
                }
            }

            echo '<hr>';
            echo '<div class="block-striped border border-secondary d-inline-block bg-dark py-1 px-2 rounded ' . $d_class . '">' . $name . '<span class="badge bg-white ml-2 ' . $s_class . '">' . $count . '</span>' . (isset($badge)? $badge: '') . '</div>';
            echo '<br><br>';
            echo '<div class="container px-0 ml-0">';

            if ($name === 'get_fields' || $name == 'get_errors')
                sp_fields($res, $name);
            else {
                echo '<table class="table table-hover table-sm"><tbody>';

                foreach ($res as $key => $item) {
                    if ($name == 'get_auto_test') {
                        echo '<tr><td>[' . $key . '] => </td>';
                        echo '<td>"' . $item . '"</td></tr>';
                    }
                    else echo '<tr><td>[' . $item . ']</td></tr>';
                }
                echo '</tbody></table>';
            }
            echo '</div>';
        }
    }
}
    function sp_fields($items, $name, $i = 0)
    {
        $i++;

        foreach ($items as $key => $item) {

            if ($i == 1)
                echo '<table class="table table-hover table-sm"><thead class="thead-light"><tr><th colspan="2">[' . $key . '] => </th></tr></thead>';

            if ($i == 2) {
                echo '<tbody><tr><td>[' . $key . '] => </td><td>';

                if ($name == 'get_fields') {
                    $type_value = gettype($item['value']);

                    $value = '"' . $item['value'] . '"';

                    if (is_bool($item['value']))
                        $value = $item['value']? 'true': 'false';

                    if (is_array($item['value']))
                        $value = '[[' . implode('][', $item['value']) . ']]';

                    echo '[[value] => (<span class="badge bg-white px-0">' . gettype($item['value']) . '</span>)' . (string)$value;
                    echo isset($item['title'])? ', [title] => "' . $item['title'] . '"]': ']';
                }

                if ($name == 'get_errors')
                    echo '"' . $item . '"';

                echo '</td></tr></tbody>';
            }

            if ($i < 2) sp_fields($item, $name, $i);
            if ($i == 1) echo '</table>';
        }
    }

/**
 * Test template
 */

if (!function_exists('sp_test')) {
    function sp_test($name)
    {
        global $sp_valid;
        return !@include(ABSPATH . $name . '.php');
    }
}

/**
 * Test form
 */

if (!function_exists('sp_form')) {
    function sp_form()
    {
        global $sp_valid;
        global $auto_test;
        $form = [];

        if ($fields = $sp_valid->get_fields('all')) {
            $form_auto_test = $auto_test && $sp_valid->get_auto_test()? $sp_valid->get_auto_test(): false;

            foreach ($fields as $key => $field) {
                $form[$key] = isset($form_auto_test[$key])? $form_auto_test[$key]: (isset($_POST[$key])? $_POST[$key]: '');
            };
        }

        return $form;
    }
}