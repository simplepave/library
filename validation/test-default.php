<?php if (!defined('ABSPATH')) exit('No direct script access allowed');

/**
 * Project: Validation
 */

/**
 * @SimplePAVE
 * https://t.me/SimplePAVE
 * info@simplepave.ru
 */

?>
    <input name="phone"   type="tel"    value="<?php echo $_POST['phone']; ?>" placeholder="PHONE">
    <input name="email"   type="email"  value="<?php echo $_POST['email']; ?>" placeholder="EMAIL">
    <input name="subject" type="hidden" value="Subject!">
<?php

    // $sp_valid->set_bail_rev(); // Revers Bail
    // $sp_valid->set_bail_on();  // ALL On Bail

    // $sp_valid->set_auto_test([
    //     'subject' => 'Subject',
    //     'phone'   => '+71112223344',
    //     'email'   => 'user@user.com',
    // ]);

    /**
     * bail | group:key[,key...]( not | ) | title:title
     * required | accepted
     * min:3 | max:255 | confirmed:name[,title]
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
