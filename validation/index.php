<?php

/**
 * Project: Validation
 */

define('ABSPATH', dirname(__FILE__) . '/');
require_once(ABSPATH . 'SP_Validation.php');

?>
<form id="" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
    <input name="last_name"       type="text"  placeholder="Фамилия"        value="<?php echo $_POST['last_name']; ?>">
    <input name="first_name"      type="text"  placeholder="Имя"            value="<?php echo $_POST['first_name']; ?>">
    <input name="middle_name"     type="text"  placeholder="Отчество"       value="<?php echo $_POST['middle_name']; ?>">
    <input name="date_birth"      type="text"  placeholder="Дата рождения"  value="<?php echo $_POST['date_birth']; ?>">
    <input name="passport_series" type="text"  placeholder="Серия паспорта" value="<?php echo $_POST['passport_series']; ?>">
    <input name="passport_issued" type="text"  placeholder="Дата выдачи"    value="<?php echo $_POST['passport_issued']; ?>">
    <input name="phone"           type="tel"   placeholder="Ваш телефон"    value="<?php echo $_POST['phone']; ?>">
    <input name="email"           type="email" placeholder="Ваш e-mail"     value="<?php echo $_POST['email']; ?>">
    <div>
        <input name="accepted" type="checkbox" id="accepted" checked="checked">
        <label for="accepted">Я даю согласие</label> ||
        <input type="radio" name="browser" value="firefox" id="firefox">
        <label for="firefox">Firefox</label>
        <input type="radio" name="browser" value="opera" id="opera">
        <label for="opera">Opera</label>
    </div>
    <input name="subject" type="hidden" value="Получить отчет">
    <input type="submit" value="Отправить">
</form>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['phone'])) {

    $sp_valid = new SP_Validation();

    $validation = $sp_valid->validation([
        'last_name'       => 'bail|min:3|max:25|group:mail',
        'first_name'      => 'bail|min:3|max:25|group:mail',
        'middle_name'     => 'group:order,mail|bail|min:3|max:25',
        'date_birth'      => 'group:order,mail|bail|date_format:d.m.Y|confirmed:passport_issued',
        'passport_series' => 'group:order|bail|min:10|max:25|type:int|numeric',
        'passport_issued' => 'group:order|bail|date_format:d.m.Y',
        'phone'           => 'bail|phone|max:25|group:mail',
        'email'           => 'bail|email|max:100|group:mail',
        'subject'         => 'type:string',
        'accepted'        => 'accepted|group:take',
        'browser'         => 'group:take',
    ]);

    echo '<pre>';

    var_dump($sp_valid->status);
    echo '<br>';

    dump('get_empties');
    dump('get_errors');
    dump('get_fields');

    echo '<hr><br>';

    // intval | strval | floatval
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