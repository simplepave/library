<?php

/**
 * Project: Validation
 */

/**
 * @SimplePAVE
 * https://t.me/SimplePAVE
 * info@simplepave.ru
 */

define('ABSPATH', dirname(__FILE__) . '/');

require_once(ABSPATH . 'inc/helpers.php');
require_once(ABSPATH . 'inc/SP_Validation.php');

$page_index = true;

/**
 * ************* Settings *************
 */

/**
 * Views
 */

// ... My Views
// ... /inc/( view-default )/[file.php]
$view = 'view-default';

/**
 * Test template
 */

// ... My Test Templates
// sp_test('test-default');
// sp_test('test-my_template');

/**
 * ********* End Settings *************
 */

/**
 *   new SP_Validation(false) = get_fields => false, get_empties => false
 *
 *   $sp_valid->validation([]);
 *   $sp_valid->set_bail_rev(); Revers Bail
 *   $sp_valid->set_bail_on();  ALL On Bail
 *
 *   shield = ( | => \| )
 *
 *   |group:key[,key...]( not | )| = group array key
 *   |title|     = title parameter
 *   |bail|      = first error => break
 *   |required|  = required
 *
 *   |required|accepted|
 *   |string|max:255|min:3|confirmed:name[,title]|
 *   |numeric|between:0,99|
 *   |date|date_format:Y-m-d H:i:s|
 *   |regex:/^.+$/i ( \| === | )|float|email|phone|
 *
 *   [,title] = optional parameter
 *
 *    type = int | bool | float ( , or . ) | array
 *   |type:array,|    === explode(' ', $value)
 *   |type:array,,|   === explode(',', $value)
 *   |type:array,sep| === explode('sep', $value)
 *
 */

if ($page_index) :
    require_once(ABSPATH . 'inc/' . $view . '/header-default.php');
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mt-3">
            <form id="" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
                <div class="container-fluid pl-0">
                    <div class="form-row justify-content-start">
                        <div class="col-1" style="align-self: flex-end">
<input name="subject" type="hidden" value="Тема письма!">
<input type="submit" value="Submit" class="btn btn-info w-100" style="padding-top: 33px; padding-bottom: 33px;">
                        </div>
                        <div class="col-8">
                            <div class="form-row mb-3">
                                <div class="col-3">
<input name="string" type="text" placeholder="STRING" value="<?php echo $_POST['string']; ?>" class="form-control">
                                </div>
                                <div class="col-3">
<input name="numeric" type="text" placeholder="NUMERIC" value="<?php echo $_POST['numeric']; ?>" class="form-control">
                                </div>
                                <div class="col-3">
<input name="float" type="text"  placeholder="FLOAT" value="<?php echo $_POST['float']; ?>" class="form-control">
                                </div>
                                <div class="col-3">
<input name="confirmed" type="text"  placeholder="CONFIRMED" value="<?php echo $_POST['confirmed']; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-3">
<input name="regex" type="text"  placeholder="REGEX: 999.99" value="<?php echo $_POST['regex']; ?>" class="form-control">
                                </div>
                                <div class="col-3">
<input name="date_format" type="text" placeholder="DATE_FORMAT" value="<?php echo $_POST['date_format']; ?>" class="form-control">
                                </div>
                                <div class="col-3">
<input name="phone" type="tel" placeholder="PHONE" value="<?php echo $_POST['phone']; ?>" class="form-control">
                                </div>
                                <div class="col-3">
<input name="email" type="email" placeholder="EMAIL" value="<?php echo $_POST['email']; ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-row mb-2">
                                <div class="col">
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-secondary active">
<input name="accepted" type="checkbox" checked autocomplete="off"> I agree
                                        </label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-secondary active">
<input type="radio" name="options" id="option1" autocomplete="off" checked> Radio 1
                                        </label>
                                        <label class="btn btn-secondary">
<input type="radio" name="options" id="option2" autocomplete="off"> Radio 2
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row align-items-center">
                                <div class="col">
                                    <select name="select" class="form-control custom-select">
                                        <option value="1" selected>Choose...</option>
                                        <option value="2">One</option>
                                        <option value="3">Two</option>
                                        <option value="10">Ten</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $sp_valid = new SP_Validation();

    // $sp_valid->set_bail_rev(); // Revers Bail
    // $sp_valid->set_bail_on();  // ALL On Bail

    $validation = $sp_valid->validation([
        'string'      => 'title:Строка тест|bail|group:string|min:3|max:7',
        'numeric'     => 'group:numeric|numeric|between:3,7|type:int',
        'float'       => 'group:numeric|float|type:float',
        'confirmed'   => 'required|group:string|confirmed:date_format,DATE_FORMAT',
        'regex'       => 'group:regex|regex:/^\d+(\.\|\,)\d+$/|type:array,,',
        'date_format' => 'bail|required|group:date,string|date_format:d.m.Y',
        'phone'       => 'bail|group:regex|phone|max:25|type:array,',
        'email'       => 'bail|group:regex|email|max:100',
        'subject'     => 'group:string',
        'accepted'    => 'accepted|group:take',
        'options'     => 'group:take',
        'select'      => 'group:take|between:1,7',
    ]);

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-2 pl-0">
<?php
    if ($sp_valid->status) {
        $class = ' bg-success text-white';
        $text = 'bool(true)';
    } else {
        $class = ' bg-danger text-white';
        $text = 'bool(false)';
    }
?>
                        <div class="rounded text-center mt-3 py-2<?php echo $class; ?>">
                            <span>Status : <?php echo $text; ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 pl-0">
                        <pre>
<?php

    dump('get_empties', false);
    dump('get_errors', false);
    dump('get_fields');

    echo '<hr><br>';
}
?>
                        </pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

require_once(ABSPATH . 'inc/' . $view . '/footer-default.php');
endif;