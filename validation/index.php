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

define('ABSPATH', dirname(__FILE__) . '/');

require_once(ABSPATH . 'inc/helpers.php');
require_once(ABSPATH . 'inc/SP_Validation.php');

$sp_valid = new SP_Validation(true);

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

foreach ($filelist as $file) {
    $file = rtrim($file, '.php');
    if ($file == 'index')
        $sp_menu[$file] = $_SERVER['PHP_SELF'];
    else
        $sp_menu[$file] = $_SERVER['PHP_SELF'] . '?page=' . $file;
}

if (isset($_GET['page']))
    $get_page = $_GET['page'];

require_once(ABSPATH . 'inc/' . $view . '/header-default.php');

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mt-3">
            <form id="" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
                <div class="container-fluid pl-0">
<?php
if (!isset($get_page)) :
?>
                    <div class="form-row justify-content-start">
                        <div class="col-9">
                            <div class="form-row mb-3">
                                <div class="col-3">
                                    <input name="string" type="text" placeholder="STRING" value="<?php echo $_POST['string']; ?>" class="form-control">
                                </div>
                                <div class="col-3">
                                    <input name="numeric" type="text" placeholder="NUMERIC" value="<?php echo $_POST['numeric']; ?>" class="form-control">
                                </div>
                                <div class="col-3">
                                    <input name="date_format" type="text" placeholder="DATE_FORMAT" value="<?php echo $_POST['date_format']; ?>" class="form-control">
                                </div>
                                <div class="col-3">
                                    <input name="confirmed" type="text"  placeholder="CONFIRMED" value="<?php echo $_POST['confirmed']; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-3">
                                    <input name="regex" type="text"  placeholder="REGEX: http://site.com" value="<?php echo $_POST['regex']; ?>" class="form-control">
                                </div>
                                <div class="col-3">
                                    <input name="float" type="text"  placeholder="FLOAT" value="<?php echo $_POST['float']; ?>" class="form-control">
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
                                        <option value="city1" selected>City One</option>
                                        <option value="city2">City Two</option>
                                        <option value="city3">City Three</option>
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
                            <input type="submit" value="Submit" class="btn btn-info w-100">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($get_page)) {

        // $sp_valid->set_bail_rev(); // Revers Bail
        // $sp_valid->set_bail_on();  // ALL On Bail

        $sp_valid->set_auto_test([
            'string'      => 'String str',
            'numeric'     => '3',
            'float'       => '47,10',
            'confirmed'   => 'user@user.com',
            'regex'       => 'http://site.com',
            'date_format' => '15.12.2013',
            'phone'       => '+71112223344',
            'email'       => 'user@user.com',
            'select'      => 'city2',
        ]);

        $validation = $sp_valid->validation([
            'string'      => 'bail|group:string|min:3|max:13',
            'numeric'     => 'numeric|between:3,7|type:int',
            'float'       => 'float|type:float',
            'confirmed'   => 'required|confirmed:email,E-mail',
            'regex'       => 'regex:/^https?:\/\/\S*?\.\S*?$/|type:float',
            'date_format' => 'date_format:d.m.Y',
            'phone'       => 'phone|max:25',
            'email'       => 'email|max:100|type:array,@',
            'subject'     => 'group:string',
            'accepted'    => 'accepted|group:take',
            'options'     => 'group:take',
            'select'      => 'title:Select City|group:state',
        ]);

    }

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-2 pl-0" style="position: absolute; left: 0; margin-left: 15px;">
<?php
    if ($sp_valid->status) {
        $class = 'border-success text-success';
        $text = 'bool(true)';
    } else {
        $class = 'border-danger text-danger';
        $text = 'bool(false)';
    }
?>
            <div class="rounded text-center mt-3 py-2 border <?php echo $class; ?>">
                <span>Status : <?php echo $text; ?></span>
            </div>
        </div>
<?php
    if ($sp_menu) :
?>
        <div class="col-2" style="margin-right: auto; margin-left: auto;">
            <div class="btn-group mt-3 w-100">
                <button type="button" class="btn btn-info dropdown-toggle py-2 w-100" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo isset($get_page)? $get_page: $home_title; ?>
                </button>
                <div class="dropdown-menu">
<?php
        foreach ($sp_menu as $page => $link) :
            if ($page != 'index') :
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
<?php
    endif;

    $class = 'col-12';
    if ($sp_valid->get_auto_test()) :
        $class = 'col-6';
?>
        <div class="col-2 pl-0" style="position: absolute; right: 0; margin-right: 15px;">
            <div class="rounded text-center mt-3 py-2 border border-warning text-warning">
                <span>Auto Test : ( ON )</span>
            </div>
        </div>
<?php
    endif;
?>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="<?php echo $class; ?> pl-0">
            <pre>
<?php

    dump('get_empties', false);
    dump('get_errors', false);
    dump('get_fields');

    echo '<hr><br>';

?>
            </pre>
        </div>
<?php
    if ($sp_valid->get_auto_test()) :
?>
        <div class="<?php echo $class; ?> pl-0">
            <pre>
<?php

    dump('get_auto_test', false);
    echo '<hr><br>';

?>
            </pre>
        </div>
<?php
    endif;
?>
    </div>
</div>
<?php
} else {
?>
<div class="container-fluid">
    <div class="row">
<?php
    if ($sp_menu) :
?>
        <div class="col-2" style="margin-right: auto; margin-left: auto;">
            <div class="btn-group mt-3 w-100">
                <button type="button" class="btn btn-info dropdown-toggle py-2 w-100" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo isset($get_page)? $get_page: $home_title; ?>
                </button>
                <div class="dropdown-menu">
<?php
        foreach ($sp_menu as $page => $link) :
            if ($page != 'index') :
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
<?php
    endif;
?>
    </div>
</div>
<?php
}

require_once(ABSPATH . 'inc/' . $view . '/footer-default.php');