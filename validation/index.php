<?php

/**
 * Project: Validation
 */

/**
 * @SimplePAVE
 * https://t.me/SimplePAVE
 * info@simplepave.ru
 */

$view = 'view-default';
$auto_test = isset($_GET['auto_test']) && $_GET['auto_test'] == 'on'? true: false;

define('ABSPATH', dirname(__FILE__) . '/');

require_once(ABSPATH . 'inc/helpers.php');
require_once(ABSPATH . 'inc/SP_Validation.php');

$sp_valid = new SP_Validation(true, !$auto_test);

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
 *   |title:title| = title parameter
 *   |bail|        = first error => break
 *   |required|    = required
 *
 *   |required|accepted|
 *   |string|min:3|max:255|confirmed:name[,title]|
 *   |numeric|between:0,99|
 *   |date|date_format:Y-m-d H:i:s|
 *   |regex:/^.+$/i ( \| === | )|float|email|phone|
 *
 *   [,title] = optional parameter
 *
 *    type = int | bool | float ( , or . ) | array
 *   |type:int|       => (int)$value
 *   |type:bool|      => (bool)$value
 *   |type:float|     => (float)str_replace(',', '.', $value)
 *   |type:array,|    === explode(' ', $value)
 *   |type:array,,|   === explode(',', $value)
 *   |type:array,\||  === explode('|', $value)
 *   |type:array,sep| === explode('sep', $value)
 *
 */

$home_title = get_class($sp_valid);
$sp_menu = [];
$filelist = glob('*.php');

$parse_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path_arr = explode('/', trim($parse_path, '/'));

$get_page = false;
$path_end = end($path_arr);

if ($path_end && in_array($path_end . '.php', $filelist)) {
    array_pop($path_arr);
    $get_page = $path_end != 'index'? $path_end: false;
}

$get_path = implode('/', $path_arr);
$get_path = $get_path? '/' . $get_path: '';

foreach ($filelist as $file) {
    $file = rtrim($file, '.php');
    $sp_menu[$file] = $get_path . '/' . $file;
}

require_once(ABSPATH . 'inc/' . $view . '/header-default.php');

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mt-3">
            <form id="sp-form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
                <div class="container-fluid px-0">
<?php
if (!$get_page) :

    // $sp_valid->set_bail_rev(); // Revers Bail
    // $sp_valid->set_bail_on();  // ALL On Bail

    $sp_valid->set_auto_test([
        'string'      => 'String str',
        'numeric'     => '3',
        'float'       => '47,10',
        'confirmed'   => 'user@user.com',
        'regex'       => 'http://site.com',
        'date_format' => '15.12.2013',
        'phone'       => '+11112223344',
        'email'       => 'user@user.com',
        'accepted'    => '1',
        'select'      => 'city2',
    ]);

    $validation = $sp_valid->validation([
        'string'      => 'bail|group:string|min:3|max:11',
        'numeric'     => 'numeric|between:3,7',
        'float'       => 'float|type:float',
        'confirmed'   => 'required|confirmed:email,E-mail',
        'regex'       => 'regex:/^https?:\/\/\S*?\.\S*?$/',
        'date_format' => 'date_format:d.m.Y|type:array,.',
        'phone'       => 'phone|max:25',
        'email'       => 'email|max:100|type:array,@',
        'subject'     => 'group:string',
        'accepted'    => 'accepted|group:take',
        'options'     => 'group:take',
        'select'      => 'title:Select City|group:state',
    ]);

    $_form = sp_form();

?>
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
                            <div class="form-row mb-2">
                                <div class="col">
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-secondary<?php echo $_form['accepted']? ' active': ''; ?>">
                                            <input name="accepted" type="checkbox" autocomplete="off"<?php echo $_form['accepted']? ' checked': ''; ?>> I agree
                                        </label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-secondary<?php echo $_form['options'] == 'radio1'? ' active': ''; ?>">
                                            <input name="options" type="radio" value="radio1" autocomplete="off"<?php echo $_form['options'] == 'radio1'? ' checked': ''; ?>> Radio 1
                                        </label>
                                        <label class="btn btn-secondary<?php echo $_form['options'] == 'radio2'? ' active': ''; ?>">
                                            <input name="options" type="radio" value="radio2" autocomplete="off"<?php echo $_form['options'] == 'radio2'? ' checked': ''; ?>> Radio 2
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
<?php
else :
    sp_test($get_page);
endif;
?>
                    <div class="form-row mt-3">
                        <div class="col-12" style="align-self: flex-end">
                            <input type="submit" value="Submit" class="sp-submit btn btn-secondary w-100">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- * *************  ************* * -->

<div class="container-fluid">
    <div class="row">
        <div class="col-2 pl-0" style="position: absolute; left: 0; margin-left: 15px;">
<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($sp_valid->status) {
            $class = 'border-success text-success';
            $text = '( true )';
        } else {
            $class = 'border-danger text-danger';
            $text = '( false )';
        }
    } else {
        $class = 'border-warning text-warning';
        $text = '( bool )';
    }
?>
            <div class="rounded text-center mt-3 py-2 border <?php echo $class; ?>">
                <span>Status : <?php echo $text; ?></span>
            </div>
        </div>

<!-- * ************* * -->

<?php
    if ($sp_menu) :
?>
        <div class="col-2 pl-0" style="margin-right: auto; margin-left: auto;">
            <div class="sp-dropdown dropdown btn-group mt-3 w-100">
<?php
        if ($get_page)
            $link = isset($sp_menu[$get_page])? $sp_menu[$get_page]: '#';
        else
            $link = isset($sp_menu['index'])? $sp_menu['index']: '#';
?>
                <a class="btn btn-info w-100" href="<?php echo  $link; ?>"><?php echo $get_page? $get_page: $home_title; ?></a>
                <button id="sp-dropdown-menu" type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split py-2 active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                </button>
                <div class="dropdown-menu dropdown-menu-right w-100 text-left mt-0" aria-labelledby="sp-dropdown-menu">
<?php
        foreach ($sp_menu as $page => $link) :
            if ($page != 'index' && $get_page != $page) :
?>
                    <a class="dropdown-item" href="<?php echo $link; ?>"><?php echo $page; ?></a>
<?php
            endif;
        endforeach;

        if (isset($sp_menu['index'])) :
?>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo $sp_menu['index']; ?>"><?php echo $home_title; ?></a>
<?php
        endif;
?>
                </div>
            </div>
        </div>

<!-- * ************* * -->

<?php
    endif;

    if ($sp_valid->get_auto_test()) :
        if ($auto_test) :
?>
        <div class="col-2 pl-0" style="position: absolute; right: 0;">
            <div class="rounded text-center mt-3 py-2 border border-warning text-warning">
                <span>Auto Test : ( WORKING )</span>
            </div>
        </div>
<?php
        else :
?>
        <div class="col-2 pl-0" style="position: absolute; right: 0;">
            <a id="sp-auto-test" class="btn btn-outline-success w-100 mt-3 py-2" href="#">Auto Test : ( ON )</a>
        </div>
<?php
        endif;
    endif;
?>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
<?php
    if ($sp_valid->get_empties()) :
?>
        <div class="col-2">
            <pre class="mb-0">
<?php
                dump('get_empties');
?><hr></pre>
        </div>
<?php
    endif;
?>
        <div class="col">
            <pre class="mb-0">
<?php
                dump('get_errors');
                dump('get_fields');
?><hr></pre>
        </div>
<?php
    if ($auto_test && $sp_valid->get_auto_test()) :
?>
        <div class="col">
            <pre class="mb-0">
<?php
                dump('get_auto_test');
?><hr></pre>
        </div>
<?php
    endif;
?>
    </div>
</div>
<?php

require_once(ABSPATH . 'inc/' . $view . '/footer-default.php');