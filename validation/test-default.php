<?php if (!defined('ABSPATH')) exit('No direct script access allowed');

/**
 * Project: Validation
 */

/**
 * @SimplePAVE
 * https://t.me/SimplePAVE
 * info@simplepave.ru
 */

    // $sp_valid->set_bail_rev(); // Revers Bail
    // $sp_valid->set_bail_all(); // ALL On Bail

    // $sp_valid->set_auto_test([
    //     'subject' => 'Subject',
    //     'phone'   => '+11112223344',
    //     'email'   => 'user@user.com',
    // ]);

    /**
     * bail | title:title
     * group:key[,key...]( not == |, all, title )
     * required | accepted
     * min:3 | max:255 | confirmed:name[,title]
     * numeric | between:0,99
     * date | date_format:Y-m-d H:i:s
     * regex:/^.+$/i ( \| === | ) | float | email
     * phone[:format]( return (mask)[+9 (999) 999-99-99] )
     * parse_url[:( scheme | host | port | user | pass | path | query | fragment )]
     *
     * type = int | bool | float ( , or . ) | array
     * |type:int|       = (int)$value
     * |type:bool|      = (bool)$value
     * |type:float|     = (float)str_replace(',', '.', $value)
     * |type:array,|    === explode(' ', $value)
     * |type:array,,|   === explode(',', $value)
     * |type:array,\||  === explode('|', $value)
     * |type:array,sep| === explode('sep', $value)
     *
     * shield = ( | === \| )
     */

    $validation = $sp_valid->validation([
        'subject' => 'title:Subject -|group:mail',
        'phone'   => 'bail|required|phone:format|max:25',
        'email'   => 'title:E-mail :|bail|required|group:mail|email|max:100',
    ]);

    /* $sp_valid->status */

    // $sp_valid->get_errors()
    // $sp_valid->get_empties()
    // $sp_valid->get_fields()

    $_form = $sp_valid->get_form();

?>

<!-- Form -->

<div class="form-row">
    <div class="col">
        <input name="phone" type="tel" value="<?php echo $_form['phone']; ?>" placeholder="PHONE" class="form-control my-phone-mask">
    </div>
    <div class="col">
        <input name="email" type="email" value="<?php echo $_form['email']; ?>" placeholder="EMAIL" class="form-control">
    </div>
    <div class="col">
        <input name="subject" type="text" value="<?php echo $_form['subject']; ?>" placeholder="SUBJECT" class="form-control">
    </div>
</div>

<!-- End Form -->

<script type="text/javascript">
    jQuery(document).ready(function($){

        /**
         * Phone
         */

        $('.my-phone-mask').inputmask({
            mask: '+9 (999) 999-99-99',
            clearMaskOnLostFocus: true,
            clearIncomplete: true
        });

    });
</script>