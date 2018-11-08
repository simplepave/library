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
 * Header view
 */

require_once(ABSPATH . 'inc/' . $view . '/header-default.php');

?>
<form id="" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
    <input name="phone"   type="tel"    value="<?php echo $_POST['phone']; ?>" placeholder="PHONE">
    <input name="email"   type="email"  value="<?php echo $_POST['email']; ?>" placeholder="EMAIL">
    <div>
        <input name="subject" type="hidden" value="Тема письма!">
        <input name="submit"  type="submit" value="Отправить">
    </div>
</form>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $sp_valid = new SP_Validation(true);

    // $sp_valid->set_bail_rev(); // Revers Bail
    // $sp_valid->set_bail_on();  // ALL On Bail

    /**
     * bail | group:key[,key...]( not | ) | title:title
     * required | accepted
     * max:255 | min:3 | confirmed:name[,title]
     * numeric | between:0,99
     * date | date_format:Y-m-d H:i:s
     * regex:/^.+$/i ( \| === | ) | float | email | phone
     *
     * type = int | bool | float ( , or . ) | array
     * |type:int|       => (int)$value
     * |type:bool|      => (bool)$value
     * |type:float|     => (float)str_replace(',', '.', $value)
     * |type:array,|    === explode(' ', $value)
     * |type:array,,|   === explode(',', $value)
     * |type:array,\||  === explode('|', $value)
     * |type:array,sep| === explode('sep', $value)
     *
     * shield = ( | => \| )
     */

    $validation = $sp_valid->validation([
        'subject' => 'required|group:mail',
        'phone'   => 'bail|required|group:mail|phone|max:25',
        'email'   => 'bail|required|group:mail|email|max:100',
    ]);

    // $sp_valid->get_empties()
    // $sp_valid->get_errors()
    // $sp_valid->get_fields()

    echo '<pre>';

    echo 'Status : ';
    var_dump($sp_valid->status);
    echo '<br>';

    dump('get_empties', false);
    dump('get_errors', false);
    dump('get_fields');

    echo '<hr><br>';
}

/**
 * Footer view
 */

require_once(ABSPATH . 'inc/' . $view . '/footer-default.php');