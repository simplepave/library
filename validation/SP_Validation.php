<?php if (!defined('ABSPATH')) exit('No direct script access allowed');

/**
 * @SimplePAVE
 * https://t.me/SimplePAVE
 * info@simplepave.ru
 */

if (!class_exists('SP_Validation')) :

class SP_Validation {

    private $validate;
    private $_name, $_value;
    private $_params, $_args;

    private $errors = [];
    private $empties = [];
    private $fields = [];

    private $bail = false;
    private $bail_on = false;
    private $pullout;

    public $status = true;

    /**
     * Construct
     */

    public function __construct($pullout = true)
    {
        $this->pullout = $pullout;

        $this->validate = [
            'required'    => [false, 'value' => 'Обязательное поле.'],
            'accepted'    => [null,  'value' => 'Подтвердить выбор.'],
            'max'         => [1,     'value' => 'Больше чем %s симв.',  'd' => 255],
            'min'         => [1,     'value' => 'Минимум %s симв.',     'd' => 3],
            'numeric'     => [null,  'value' => 'Не число.'],
            'float'       => [1,     'value' => 'Не float.',            'd' => '/^\d+\.\d+$/'],
            'between'     => [2,     'value' => 'Не между %s и %s.',    'd' => [0,99]],
            'string'      => [null,  'value' => 'Не строка.'],
            'regex'       => [1,     'value' => 'Ошибочный формат.',    'd' => '/^.+$/i'],
            'date'        => [null,  'value' => 'Не является датой.'],
            'date_format' => [1,     'value' => 'Формат: %s',           'd' => 'Y-m-d H:i:s'],
            'confirmed'   => [[2,1], 'value' => 'Не совпадает с "%s".', 'd' => 'password'],
            'email'       => [1,     'value' => 'Не e-mail.',  'd' => '/^.+@.+\..+$/i'],
            'phone'       => [1,     'value' => 'Не телефон.', 'd' => '/^\+?\d[-\s]?\(?\d{3}\)?[-\s]?[-\s\d]{7,9}$/'],
            'type'        => [[2,1], 'd' => 'string'],
        ];
    }

    /**
     * Basic
     */

    public function validation($data = false)
    {
        if (is_array($data)) {
            foreach ($data as $name => $items) {
                $this->_name = $name;
                $this->_value = $this->name_isset();
                $variables = explode('|', $items);
                $bail = $this->bail? !in_array('bail', $variables): in_array('bail', $variables);
                $bail = $this->bail_on || $bail;

                if (in_array('required', $variables)) $this->validate('required');
                elseif (empty($this->_value) && !is_bool($this->_value) && $this->_value !== '0')
                    continue;

                foreach ($variables as $variable) {
                    if ($bail && isset($this->errors[$this->_name])) break;

                    $validate = explode(':', $variable, 2);
                    $key = trim($validate[0]);

                    if (array_key_exists($key, $this->validate)) {
                        $param = $this->validate[$key][0];
                        if (is_bool($param)) continue;

                        if (!is_null($param)) {
                            $this->_params = [];

                            if ($args = isset($validate[1])? trim($validate[1]): false) {
                                $limit = (array)$param;
                                $params = explode(',', $args, $limit[0]);
                                $limit = isset($param[1])? $param[1]: $limit[0];

                                if (count($params) >= $limit)
                                    $this->_params = array_map('trim', $params);
                            }
                            if (!$this->_params && isset($this->validate[$key]['d']))
                                $this->_params = (array)$this->validate[$key]['d'];
                        }
                        $this->validate($key);
                    }
                }
                if ($this->pullout) $this->group($items);
            }
            // mail field name
        }
    }

    /**
     * Set Bail
     */

    public function set_bail_rev()
    {
        $this->bail = true;
    }

    public function set_bail_on()
    {
        $this->bail_on = true;
    }

    /**
     * Get Response
     */

    public function get_errors()
    {
        return $this->errors;
    }

    public function get_empties()
    {
        return $this->empties?: false;
    }

    public function get_fields()
    {
        return $this->status? $this->fields: false;
    }

    /**
     * Helper Methods
     */

    private function name_isset($request = false)
    {
        $name = $request?: $this->_name;
        $field = isset($_POST[$name])? trim($_POST[$name]): false;

        if (!$request) {
            if ($this->pullout)  $this->fields['all'][$name] = $field;
            if (is_bool($field)) $this->empties[] = $name;
        }

        return $field;
    }

    private function group($value)
    {
        if (preg_match('/group\s?:([a-z0-9_,\s]+)/', $value, $outer)) {
            $groups = explode(',', $outer[1]);
            $name = $this->_name;

            foreach ($groups as $group) {
                if ($group = str_replace(' ', '', $group))
                    $this->fields[$group][$name] = $this->fields['all'][$name];
            }
        }
    }

    /**
     * Basic Helper Methods
     */

    private function errors($key)
    {
        $value = $this->validate[$key]['value'];

        if ($this->_args) {
            $args = is_array($this->_args)? $this->_args: (array)$this->_args;
            $value = vsprintf($value, $args);
        }

        $this->errors[$this->_name][$key] = $value;
        $this->status && $this->status = false;
    }

    private function validate($key)
    {
        if (method_exists($this, 'validate_' . $key)) {
            $this->_args && $this->_args = false;

            if ($this->{'validate_' . $key}())
                $this->errors($key);
        }
    }

    /**
     * Type
     */

    private function validate_type()
    {
        if ($this->pullout) {
            $value = $this->_value;
            $type = $this->_params[0];

            switch ($type) {
                case 'int':    $value = (int)$value; break;
                case 'bool':   $value = (bool)$value; break;
                case 'float':  $value = (float)$value; break;
                case 'string': $value = (string)$value; break;
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
        return $this->_value !== '0' && empty($this->_value);
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
     * Phone:([regex])
     */

    private function validate_phone()
    {
        return $this->validate_regex();
    }

    /**
     * E-mail:([regex])
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
     * Date Format:([format])
     */

    private function validate_date_format()
    {
        $dateTime = DateTime::createFromFormat('!'.$this->_params[0], $this->_value);

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

    public function validate_accepted()
    {
        // $acceptable = ['yes', 'on', '1', 1, true, 'true'];
        // !in_array($this->_value, $acceptable, true);
        return is_bool($this->_value);
    }

    /**
     * Confirmed:(name)
     */

    public function validate_confirmed()
    {
        $confirm = $this->name_isset($this->_params[0]);

        if ($confirm != $this->_value) {
            $this->_args = isset($this->_params[1])? $this->_params[1]: $this->_params[0];
            return true;
        }

        return false;
    }
}

endif;