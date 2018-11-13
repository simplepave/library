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
    // $sp_valid->set_bail_on();  // ALL On Bail

    $sp_valid->set_auto_test([
        'string'      => 'String str',
        'numeric'     => '3',
        'float'       => '47,10',
        'confirmed'   => 'user@user.com',
        'regex'       => 'http://site.com/index.php',
        'date_format' => '15.12.2013',
        'phone'       => '+11112223344',
        'email'       => 'user@user.com',
        'accepted'    => '1',
        'select'      => 'city2',
    ]);

    $validation = $sp_valid->validation([
        'string'      => 'bail|group:string|min:3|max:11',
        'numeric'     => 'group:numeric|numeric|type:int|between:3,7',
        'float'       => 'required|group:numeric|float|type:float',
        'confirmed'   => 'required|confirmed:email,E-mail',
        'regex'       => 'group:outer|regex:/^https?:\/\/\S*?\.\S*?$/|parse_url:PHP_URL_PATH',
        'date_format' => 'group:outer|required|date_format:d.m.Y|type:array,.',
        'phone'       => 'group:outer|required|phone:format|max:25',
        'email'       => 'group:outer|required|email|max:100|type:array,@',
        'subject'     => 'title:Subject :|group:string',
        'accepted'    => 'accepted|group:take',
        'options'     => 'group:take',
        'select'      => 'title:City :|group:state',
    ]);

    $_form = $sp_valid->get_form();

?>

<!-- Form -->

<div class="form-row justify-content-start">
    <div class="col-9">
        <div class="form-row mb-3">
            <div class="col-3">
                <input name="string" type="text" placeholder="STRING" value="<?php echo $_form['string']; ?>" class="form-control">
            </div>
            <div class="col-3">
                <input name="numeric" type="text" placeholder="NUMERIC" value="<?php echo $_form['numeric']; ?>" class="form-control">
            </div>
            <div class="col-3">
                <input name="date_format" type="text" placeholder="DATE_FORMAT" value="<?php echo $_form['date_format']; ?>" class="form-control">
            </div>
            <div class="col-3">
                <input name="confirmed" type="text"  placeholder="CONFIRMED" value="<?php echo $_form['confirmed']; ?>" class="form-control">
            </div>
        </div>
        <div class="form-row">
            <div class="col-3">
                <input name="regex" type="text"  placeholder="REGEX: http://site.com" value="<?php echo $_form['regex']; ?>" class="form-control">
            </div>
            <div class="col-3">
                <input name="float" type="text"  placeholder="FLOAT" value="<?php echo $_form['float']; ?>" class="form-control">
            </div>
            <div class="col-3">
                <input name="phone" type="tel" placeholder="PHONE" value="<?php echo $_form['phone']; ?>" class="form-control phone-mask">
            </div>
            <div class="col-3">
                <input name="email" type="email" placeholder="EMAIL" value="<?php echo $_form['email']; ?>" class="form-control">
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="form-row">
            <div class="col mb-2">
                <div class="btn-group" data-toggle="buttons">
                    <label class="sp-btn-accepted btn btn-outline-warning<?php echo $_form['accepted']? ' active': ''; ?>">
                        <input name="accepted" type="checkbox" autocomplete="off"<?php echo $_form['accepted']? ' checked': ''; ?>> <span><i class="fa fa-check" aria-hidden="true"></i> I agree</span>
                    </label>
                </div>
            </div>
            <div class="col mb-2">
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-outline-success<?php echo $_form['options'] != 'off'? ' active': ''; ?>">
                        <input name="options" type="radio" value="on" autocomplete="off"<?php echo $_form['options'] != 'off'? ' checked': ''; ?>>
                        <span>ON</span>
                    </label>
                    <label class="btn btn-outline-danger<?php echo $_form['options'] == 'off'? ' active': ''; ?>">
                        <input name="options" type="radio" value="off" autocomplete="off"<?php echo $_form['options'] == 'off'? ' checked': ''; ?>>
                        <span>OFF</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="form-row align-items-center">
            <div class="col">
                <select name="select" class="form-control custom-select">
                    <option value="city1"<?php echo $_form['select'] == 'city1'? ' selected': ''; ?>>City One</option>
                    <option value="city2"<?php echo $_form['select'] == 'city2'? ' selected': ''; ?>>City Two</option>
                    <option value="city3"<?php echo $_form['select'] == 'city3'? ' selected': ''; ?>>City Three</option>
                </select>
            </div>
        </div>
    </div>
</div>
<input name="subject" type="hidden" value="Subject!">

<!-- End Form -->

<script type="text/javascript">
    jQuery(document).ready(function($){
        // ...
    });
</script>