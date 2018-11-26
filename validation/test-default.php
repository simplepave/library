<?php if (!defined('ABSPATH')) exit('No direct script access allowed');

/**
 * Project: Validation
 */

/**
 * @SimplePAVE
 * https://t.me/SimplePAVE
 * info@simplepave.ru
 */

    // $sp_valid->set_auto_test([
    //     'phone'   => '+11112223344',
    //     'email'   => 'user@test.com',
    //     'subject' => 'Subject test',
    // ]);

    // $sp_valid->set_language([
    //     'required'    => 'Field is required.',
    //     'accepted'    => 'Confirm selection.',
    //     'max'         => 'Max %s characters.',
    //     'min'         => 'Min %s characters.',
    //     'numeric'     => 'Not a number.',
    //     'float'       => 'Not a float.',
    //     'between'     => 'Not between %s and %s.',
    //     'string'      => 'Not a string.',
    //     'regex'       => 'Wrong format.',
    //     'date'        => 'Not a date.',
    //     'date_format' => 'Format: %s',
    //     'confirmed'   => 'Does not match "%s".',
    //     'email'       => 'Not a email.',
    //     'phone'       => 'Not a phone.',
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
     * type:int       = (int)$value
     * type:bool      = (bool)$value
     * type:float     = (float)str_replace(',', '.', $value)
     * type:array,    === explode(' ', $value)
     * type:array,,   === explode(',', $value)
     * type:array,\|  === explode('|', $value)
     * type:array,sep === explode('sep', $value)
     *
     * shield = ( | === \| )
     */

    $sp_valid->validation($request_post, [
        'phone'   => 'required|phone:format|max:25',
        'email'   => 'required|email|max:100|title:E-mail :|group:mail',
        'subject' => 'title:Subject -|group:mail',
    ]);

    /**
     * $sp_valid->status = null | false | true
     *
     * $sp_valid->get_empties();
     * $sp_valid->get_errors();
     * $sp_valid->get_fields([string $key = false]); $key: 'all', ['title'], [...]
     * $sp_valid->get_form(string $name); return trim($request[$name]) or false
     */

    $default = [
        'phone'   => '+7 (111) 222-33-44',
        'email'   => '',
        'subject' => 'Subject default',
    ];

    $_form = function ($name) use ($sp_valid, $default) {

        if ($GLOBALS['request_post'])
            $result = $sp_valid->get_form($name);
        else
            $result = isset($default[$name])? $default[$name]: '';

        return $result;
    };

?>

<!-- Form -->

<div class="form-row">
    <div class="col">
        <input name="phone" type="tel" value="<?php echo $_form('phone'); ?>" placeholder="PHONE" class="form-control my-phone-mask">
    </div>
    <div class="col">
        <input name="email" type="email" value="<?php echo $_form('email'); ?>" placeholder="EMAIL" class="form-control">
    </div>
    <div class="col">
        <input name="subject" type="text" value="<?php echo $_form('subject'); ?>" placeholder="SUBJECT" class="form-control">
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