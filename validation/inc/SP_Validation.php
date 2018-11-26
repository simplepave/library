<?php // if (!defined('ABSPATH')) exit('No direct script access allowed');

/**
 * Project: Validation
 */

/**
 * @SimplePAVE
 * https://t.me/SimplePAVE
 * info@simplepave.ru
 */

if (!class_exists('SP_Validation')) :

class SP_Validation
{
    public $version = '2.0.0';

    private $pullout;
    private $auto_test_on;

    private $validate, $request;
    private $set_bail, $_bail;
    private $_name, $_value;
    private $_params, $_args;

    private $auto_test = [];
    private $language  = [];

    private $empties   = [];
    private $errors    = [];
    private $fields    = [];
    private $form      = [];

    public $status = true;

    /**
     * Construct
     */

    public function __construct($pullout = true, $auto_test_on = false)
    {
        $this->pullout      = is_bool($pullout)? $pullout: true;
        $this->auto_test_on = is_bool($auto_test_on)? $auto_test_on: false;

        $this->validate = [
            'required'    => [false, 'value' => 'Обязательное поле.'],
            'accepted'    => [null,  'value' => 'Подтвердить выбор.'],
            'max'         => [1,     'value' => 'Больше чем %s симв.', 'default' => 255],
            'min'         => [1,     'value' => 'Минимум %s симв.',    'default' => 3],
            'numeric'     => [null,  'value' => 'Не число.'],
            'float'       => [null,  'value' => 'Не float.',           'other' => '/^\d+(\.|\,)\d+$/'],
            'between'     => [2,     'value' => 'Не между %s и %s.',   'default' => [0,99]],
            'string'      => [null,  'value' => 'Не строка.'],
            'regex'       => [1,     'value' => 'Ошибочный формат.'],
            'date'        => [null,  'value' => 'Не является датой.'],
            'date_format' => [1,     'value' => 'Формат: %s',          'example' => 'Y-m-d H:i:s'],
            'confirmed'   => [[2,1], 'value' => 'Не совпадает с "%s".'],
            'email'       => [null,  'value' => 'Не e-mail.',  'other' => '/^.+@.+\..+$/i'],
            'phone'       => [1,     'value' => 'Не телефон.', 'default' => 'no_format', 'other' => '/^\+?\d[\s-_(]{0,3}?\d{3}[\s-_)]{0,3}?(?:\d[\s-_]{0,3}?){7}$/'],
            'type'        => [[2,1]],
            'title'       => [1],
            'parse_url'   => [1, 'default' => -1, 'other' => ['SCHEME', 'HOST', 'PORT', 'USER', 'PASS', 'PATH', 'QUERY', 'FRAGMENT']],
        ];
    }

    /**
     * Basic
     */

    public function validation($request = false, $data = false, $set_bail = false)
    {
        if (is_array($request) && is_array($data)) {
            $this->request = $request;
            $this->set_bail = $set_bail? (string)$set_bail: false;

            foreach ($data as $name => $items) {
                $this->_name = $name;
                $this->_value = $this->set_value();

                if ($variables = $this->variables($items)) {

                    foreach ($variables as $variable) {
                        if ($this->_bail && isset($this->errors[$this->_name])) break;

                        $validate = explode(':', $variable, 2);
                        $key = trim($validate[0]);

                        if (array_key_exists($key, $this->validate)) {
                            $args = $this->validate[$key][0];

                            if (is_bool($args)) continue;

                            if (is_null($args) || $args === 0) {

                                if (isset($this->validate[$key]['other']))
                                    $this->_params = (array)$this->validate[$key]['other'];

                                $this->validate($key);
                            }
                            else {
                                $this->_params = [];

                                if ($params = isset($validate[1])? $validate[1]: false) {
                                    $args = (array)$args;
                                    $limit = isset($args[1])? $args[1]: $args[0];
                                    $params = str_replace('\|', '|', $params);
                                    $params = explode(',', $params, $args[0]);

                                    if (count($params) >= $limit)
                                        $this->_params = array_map('trim', $params);
                                }

                                if (!$this->_params && isset($this->validate[$key]['default']))
                                    $this->_params = (array)$this->validate[$key]['default'];

                                if ($this->_params) $this->validate($key);
                            }
                        }
                    }

                    if ($this->pullout) $this->group($items);
                }
            }
        }
        else $this->status = null;
    }

    /**
     * Set Auto Test
     */

    public function set_auto_test($seeds = false)
    {
        if (is_array($seeds)) {
            if ($this->auto_test_on)
                $this->auto_test = $seeds;
            else
                $this->auto_test = true;
        }
    }

    /**
     * Set Language
     */

    public function set_language($language = false)
    {
        if (is_array($language))
            $this->language = $language;
    }

    /**
     * Get Empties
     */

    public function get_empties()
    {
        return $this->empties?: false;
    }

    /**
     * Get Errors
     */

    public function get_errors()
    {
        return $this->errors?: false;
    }

    /**
     * Get Fields
     */

    public function get_fields($key = false)
    {
        if ($this->status)
            if ($key && isset($this->fields[$key]))
                return $this->fields[$key];
            else
                return $this->fields;

        return false;
    }

    /**
     * Get Form
     */

    public function get_form($name = false)
    {
        return $name && isset($this->form[$name])? $this->form[$name]: '';
    }

    /**
     * Get Auto Test
     */

    public function get_auto_test()
    {
        return $this->auto_test?: false;
    }

    /**
     * Set Value
     */

    private function set_value($name = false, $write = true)
    {
        $name = $name?: $this->_name;
        $value = isset($this->request[$name])? trim($this->request[$name]): false;

        if ($this->auto_test_on && $this->auto_test && array_key_exists($name, $this->auto_test))
            $value = $this->auto_test[$name];

        if ($write) {
            $this->form[$name] = $value;

            if ($this->pullout)
                $this->fields['all'][$name] = $value;

            if (is_bool($value))
                $this->empties[] = $name;
        }

        return $value;
    }

    /**
     * Variables
     */

    private function variables($items)
    {
        $items = trim($items, '| ');
        $items = preg_split("/(?<=[^\\\])\|/", $items, -1, PREG_SPLIT_NO_EMPTY);

        if ($items) {
            $items = array_map('trim', $items);

            if ($this->empty_field(in_array('required', $items)))
                return false;

            $this->set_bail(in_array('bail', $items));

            return $items;
        }

        return false;
    }

    /**
     * Empty Field
     */

    private function empty_field($required)
    {
        if ($required)
            $this->validate('required');
        elseif (empty($this->_value) && !is_bool($this->_value) && $this->_value !== '0')
            return true;

        return false;
    }

    /**
     * Set Bail
     */

    private function set_bail($bail)
    {
        if ($this->set_bail)
            switch ($this->set_bail) {
                case 'all': $bail = true;   break;
                case 'rev': $bail = !$bail; break;
            }

        $this->_bail = $bail;
    }

    /**
     * Validate
     */

    private function validate($method)
    {
        if (method_exists($this, 'validate_' . $method)) {
            $this->_args && $this->_args = false;

            if ($this->{'validate_' . $method}())
                $this->errors($method);
        }
    }

    /**
     * Errors
     */

    private function errors($key)
    {
        if ($this->language && !empty($this->language[$key]))
            $value = $this->language[$key];
        else
            $value = $this->validate[$key]['value'];

        if ($this->_args)
            $value = vsprintf($value, (array)$this->_args);

        $this->errors[$this->_name][$key] = $value;
        $this->status && $this->status = false;
    }

    /**
     * Group
     */

    private function group($items)
    {
        if (preg_match('/group\s?:([^|]+)/', $items, $outer)) {
            $groups = explode(',', $outer[1]);
            $name = $this->_name;

            foreach ($groups as $group) {
                $group = str_replace(' ', '', $group);

                if (!in_array($group, ['all', 'title']))
                    $this->fields[$group][$name] = $this->fields['all'][$name];
            }
        }
    }

    /**
     * Type:(type)
     */

    private function validate_type()
    {
        if ($this->pullout) {
            $value = $this->_value;
            $type = $this->_params[0];

            switch ($type) {
                case 'int':   $value = (int)$value; break;
                case 'bool':  $value = (bool)$value; break;
                case 'float': $value = (float)str_replace(',', '.', $value); break;
                case 'array':
                    if (isset($this->_params[1])) {
                        $sep = $this->_params[1];
                        $sep = $sep || $sep === '0'? $sep: ' ';
                        $value = explode($sep, $value);
                    } else $value = (array)$value;
                break;
            }

            $this->fields['all'][$this->_name] = $value;
        }

        return false;
    }

    /**
     * Required
     */

    private function validate_required()
    {
        return empty($this->_value) && $this->_value !== '0';
    }

    /**
     * Numeric
     */

    private function validate_numeric()
    {
        return !is_numeric($this->_value);
    }

    /**
     * Float
     */

    private function validate_float()
    {
        return $this->validate_regex();
    }

    /**
     * Between:([int][, int])
     */

    private function validate_between()
    {
        if ($this->_value < $this->_params[0] || $this->_value > $this->_params[1]) {
            $this->_args = [$this->_params[0], $this->_params[1]];
            return true;
        }

        return false;
    }

    /**
     * String
     */

    private function validate_string()
    {
        return !is_string($this->_value);
    }

    /**
     * Regex:(regex)
     */

    private function validate_regex()
    {
        return !preg_match($this->_params[0], $this->_value);
    }

    /**
     * Phone:([format])
     */

    private function validate_phone()
    {
        if (preg_match($this->validate['phone']['other'], $this->_value)) {
            if ($this->_params[0] === 'format') {
                $phone = preg_replace('/[^0-9]/', '', $this->_value);
                $length = strlen($phone);

                if ($length == 11)
                    $phone = preg_replace('/(\d{1})(\d{3})(\d{3})(\d{2})(\d{2})/', '+$1 ($2) $3-$4-$5', $phone);
                elseif ($length == 10)
                    $phone = preg_replace('/(\d{3})(\d{3})(\d{2})(\d{2})/', "($1) $2-$3-$4", $phone);
                elseif ($length <= 7 && $length > 4)
                    $phone = preg_replace('/(\d+)?(\d{2})(\d{2})/', "$1-$2-$3", $phone);

                $this->fields['all'][$this->_name] = $phone;
            }
        }
        else return true;

        return false;
    }

    /**
     * E-mail
     */

    private function validate_email()
    {
        return $this->validate_regex();
    }

    /**
     * Max:([int])
     */

    private function validate_max()
    {
        if (mb_strlen($this->_value) > $this->_params[0]) {
            $this->_args = $this->_params[0];
            return true;
        }

        return false;
    }

    /**
     * Min:([int])
     */

    private function validate_min()
    {
        if (mb_strlen($this->_value) < $this->_params[0]) {
            $this->_args = $this->_params[0];
            return true;
        }

        return false;
    }

    /**
     * Date
     */

    private function validate_date()
    {
        return !is_numeric(strtotime($this->_value));
    }

    /**
     * Date Format:(format)
     */

    private function validate_date_format()
    {
        $dateTime = DateTime::createFromFormat('!' . $this->_params[0], $this->_value);

        if (!$dateTime || $dateTime->format($this->_params[0]) != $this->_value) {
            $date = new DateTime();
            $this->_args = $date->format($this->_params[0]);
            return true;
        }

        return false;
    }

    /**
     * Accepted
     */

    private function validate_accepted()
    {
        return is_bool($this->_value);
    }

    /**
     * Confirmed:(name)
     */

    private function validate_confirmed()
    {
        $confirm = $this->set_value($this->_params[0], false);

        if ($confirm != $this->_value) {
            $this->_args = isset($this->_params[1])? $this->_params[1]: $this->_params[0];
            return true;
        }

        return false;
    }

    /**
     * Title:(title)
     */

    private function validate_title()
    {
        if ($this->pullout)
            $this->fields['title'][$this->_name] = $this->_params[0];

        return false;
    }

    /**
     * Parse Url:([constant])
     */

    private function validate_parse_url()
    {
        $param = strtoupper($this->_params[0]);
        $default = $this->validate['parse_url']['default'];
        $components = $this->validate['parse_url']['other'];
        $component = in_array($param, $components)? constant('PHP_URL_' . $param): $default;
        $url = parse_url($this->_value, $component);

        $url && $this->fields['all'][$this->_name] = $url;

        return false;
    }
}

endif;