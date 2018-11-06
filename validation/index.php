<?php

/**
 * Project: Validation
 */

define('ABSPATH', dirname(__FILE__) . '/');
require_once(ABSPATH . 'SP_Validation.php');

?>
<form id="" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
    <input name="string"      type="text"  placeholder="STRING"      value="<?php echo $_POST['string']; ?>">
    <input name="numeric"     type="text"  placeholder="NUMERIC"     value="<?php echo $_POST['numeric']; ?>">
    <input name="float"       type="text"  placeholder="FLOAT"       value="<?php echo $_POST['float']; ?>">
    <input name="confirmed"   type="text"  placeholder="CONFIRMED"   value="<?php echo $_POST['confirmed']; ?>">
    <input name="regex"       type="text"  placeholder="REGEX"       value="<?php echo $_POST['regex']; ?>">
    <input name="date_format" type="text"  placeholder="DATE_FORMAT" value="<?php echo $_POST['date_format']; ?>">
    <input name="phone"       type="tel"   placeholder="PHONE"       value="<?php echo $_POST['phone']; ?>">
    <input name="email"       type="email" placeholder="EMAIL"       value="<?php echo $_POST['email']; ?>">
    <div>
        <input name="accepted" type="checkbox" id="accepted" checked="checked">
        <label for="accepted">I agree</label> ||
        <input type="radio" name="radio" value="radio_1" id="radio_1" checked="checked">
        <label for="radio_1">R1</label>
        <input type="radio" name="radio" value="radio_2" id="radio_2">
        <label for="radio_2">R2</label>
    </div>
    <input name="subject" type="hidden" value="Тема письма!">
    <input type="submit" value="Отправить">
</form>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['phone'])) {

    $sp_valid = new SP_Validation();

    $validation = $sp_valid->validation([
        'string'      => 'bail|min:3|max:7|group:string_1',
        'numeric'     => 'group:numeric|numeric|between:3,7|type:int',
        'float'       => 'bail|group:numeric|float|between:0.3,0.7|type:float',
        'confirmed'   => 'bail|required|group:string|confirmed:date_format,DATE',
        'regex'       => 'bail|group:regex|regex:/^\d+\,\d+$/|type:array,,',
        'date_format' => 'bail|required|group:date,string|date_format:d.m.Y',
        'phone'       => 'bail|group:regex|phone|max:25|type:array,',
        'email'       => 'bail|group:regex|email|max:100',
        'subject'     => 'group:string',
        'accepted'    => 'accepted|group:take',
        'radio'       => 'group:take',
    ]);

    /*
        new SP_Validation(false) = get_fields => false, get_empties => false

        |group:key[,key]| = group array key([a-z0-9_,])
        |bail|      = first error => break
        |required|  = required

        |required|accepted|
        |string|max:255|min:3|confirmed:name[,title]|
        |numeric|between:0,99|
        |date|date_format:Y-m-d H:i:s|
        |regex:/^.+$/i|float[:/reg/]|email[:/reg/]|phone[:/reg/]|

        [:/reg/] || [,title] = optional parameter

         type = int | bool | float | array
        |type:array,|    === explode(' ', $value)
        |type:array,,|   === explode(',', $value)
        |type:array,sep| === explode('sep', $value)

    */

    echo '<pre>';

    var_dump($sp_valid->status);
    echo '<br>';

    dump('get_empties');
    dump('get_errors');
    dump('get_fields');

    echo '<hr><br>';
}

    function dump($name) {
        global $sp_valid;

        if ($res = $sp_valid->$name()) {
            echo '<hr><br>';
            echo $name;
            echo '<br><br>';
            var_dump($res);
            echo '<br>';
        }
    }