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

    $sp_valid->set_auto_test([
        'string'      => 'Text test',
        'numeric'     => '3',
        'float'       => '47,10',
        'confirmed'   => 'user@test.com',
        'regex'       => 'http://test.com/index.php',
        'date_format' => '15.12.2013',
        'phone'       => '+11112223344',
        'email'       => 'user@test.com',
        'accepted'    => 'on',
        'select'      => 'city-2',
    ]);

    $sp_valid->validation($request_post, [
        'string'      => 'bail|group:string|min:3|max:11',
        'numeric'     => 'group:numeric|numeric|type:int|between:3,7',
        'float'       => 'required|group:numeric|float|type:float',
        'confirmed'   => 'required|confirmed:email,E-mail',
        'regex'       => 'group:outer|regex:/^https?:\/\/\S*?\.\S*?$/|parse_url:host',
        'date_format' => 'group:outer|required|date_format:d.m.Y|type:array,.',
        'phone'       => 'group:outer|required|phone:format|max:25',
        'email'       => 'group:outer|required|email|max:100|type:array,@',
        'subject'     => 'title:Subject :|group:string',
        'accepted'    => 'accepted|group:take',
        'options'     => 'group:take',
        'select'      => 'required|title:City :|group:state',
    ]);

    $default = [
        'string'  => 'Text default',
        'numeric' => '7',
        'regex'   => 'http://default.com/',
        'phone'   => '+7 (111) 222-33-44',
        'options' => 'off',
        'select'  => 'city-3',
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

<div class="form-row justify-content-start">
    <div class="col-9">
        <div class="form-row mb-3">
            <div class="col-3">
                <input name="string" type="text" placeholder="STRING" value="<?php echo $_form('string'); ?>" class="form-control">
            </div>
            <div class="col-3">
                <input name="numeric" type="text" placeholder="NUMERIC" value="<?php echo $_form('numeric'); ?>" class="form-control">
            </div>
            <div class="col-3">
                <input name="date_format" type="text" placeholder="DATE_FORMAT" value="<?php echo $_form('date_format'); ?>" class="form-control">
            </div>
            <div class="col-3">
                <input name="confirmed" type="text"  placeholder="CONFIRMED" value="<?php echo $_form('confirmed'); ?>" class="form-control">
            </div>
        </div>
        <div class="form-row">
            <div class="col-3">
                <input name="regex" type="text"  placeholder="REGEX: http://site.com" value="<?php echo $_form('regex'); ?>" class="form-control">
            </div>
            <div class="col-3">
                <input name="float" type="text"  placeholder="FLOAT" value="<?php echo $_form('float'); ?>" class="form-control">
            </div>
            <div class="col-3">
                <input name="phone" type="tel" placeholder="PHONE" value="<?php echo $_form('phone'); ?>" class="form-control phone-mask">
            </div>
            <div class="col-3">
                <input name="email" type="email" placeholder="EMAIL" value="<?php echo $_form('email'); ?>" class="form-control">
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="form-row">
            <div class="col mb-2">
                <div class="btn-group" data-toggle="buttons">
                    <label class="sp-btn-accepted btn btn-outline-warning<?php echo $_form('accepted')? ' active': ''; ?>">
                        <input name="accepted" type="checkbox" autocomplete="off"<?php echo $_form('accepted')? ' checked': ''; ?>> <span><i class="fa fa-check" aria-hidden="true"></i> I agree</span>
                    </label>
                </div>
            </div>
            <div class="col mb-2">
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-outline-success<?php echo $_form('options') != 'off'? ' active': ''; ?>">
                        <input name="options" type="radio" value="on" autocomplete="off"<?php echo $_form('options') != 'off'? ' checked': ''; ?>>
                        <span>ON</span>
                    </label>
                    <label class="btn btn-outline-danger<?php echo $_form('options') == 'off'? ' active': ''; ?>">
                        <input name="options" type="radio" value="off" autocomplete="off"<?php echo $_form('options') == 'off'? ' checked': ''; ?>>
                        <span>OFF</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="form-row align-items-center">
            <div class="col">
                <select name="select" class="form-control custom-select">
                    <option value=""<?php echo empty($_form('select'))? ' selected': ''; ?>>Select City</option>
                    <option value="city-1"<?php echo $_form('select') == 'city-1'? ' selected': ''; ?>>City One</option>
                    <option value="city-2"<?php echo $_form('select') == 'city-2'? ' selected': ''; ?>>City Two</option>
                    <option value="city-3"<?php echo $_form('select') == 'city-3'? ' selected': ''; ?>>City Three</option>
                </select>
            </div>
        </div>
    </div>
</div>
<input name="subject" type="hidden" value="Subject hidden">

<!-- End Form -->

<script type="text/javascript">
    jQuery(document).ready(function($){
        // ...
    });
</script>