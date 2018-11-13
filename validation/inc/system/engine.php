<?php if (!defined('ABSPATH')) exit('No direct script access allowed');

/**
 * Project: Validation
 */

/**
 * @SimplePAVE
 * https://t.me/SimplePAVE
 * info@simplepave.ru
 */

    require_once(ABSPATH . 'inc/system/helpers.php');
    require_once(ABSPATH . 'inc/SP_Validation.php');

    $auto_test = isset($_GET['auto_test']) && $_GET['auto_test'] == 'on'? true: false;

    $sp_valid = new SP_Validation(true, $auto_test);

    $home_title = get_class($sp_valid);
    $sp_menu = [];

    $parse_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $path_arr = explode('/', trim($parse_path, '/'));

    $get_page = false;
    $path_end = end($path_arr);
    $filelist = glob('*.php');

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

    require_once(ABSPATH . 'inc/' . $view . '/header.php');

?>

<!-- * ************* form  ************* * -->

<div class="container-fluid" style="max-width: 2560px;">
    <div class="row">
        <div class="col-12 mt-3">
            <form id="sp-form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
                <div class="container-fluid px-0">
<?php
    sp_test($get_page?: 'inc/system/test-info');
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

<!-- * ************* info  ************* * -->

<?php

    $get_empties = $sp_valid->get_empties();
    $get_errors = $sp_valid->get_errors();
    $get_fields = $sp_valid->get_fields();
    $get_auto_test = $sp_valid->get_auto_test();

?>

<div class="container-fluid" style="max-width: 2560px; position: relative;">
    <div class="row">
        <div class="col pl-0" style="max-width: 33%; position: absolute; left: 0; margin-left: 15px;">
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
        <div class="col px-0" style="max-width: 33%; margin-right: auto; margin-left: auto;">
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

    if ($get_auto_test) :
        if ($auto_test) :
?>
        <div class="col pl-0" style="max-width: 33%; position: absolute; right: 0;">
            <div class="rounded text-center mt-3 py-2 border border-warning text-warning">
                <span>Auto Test : ( WORKING )</span>
            </div>
        </div>
<?php
        else :
?>
        <div class="col pl-0" style="max-width: 33%; position: absolute; right: 0;">
            <a id="sp-auto-test" class="btn btn-outline-success w-100 mt-3 py-2" href="#">Auto Test : ( ON )</a>
        </div>
<?php
        endif;
    endif;
?>
    </div>
</div>

<!-- * ************* outer  ************* * -->

<div class="container-fluid" style="max-width: 2560px;">
    <div class="row">
<?php
    if ($get_empties) :
?>
        <div class="col mx-auto" style="max-width: 200px;">
            <pre class="mb-0">
<?php
                dump('get_empties');
?><hr></pre>
        </div>
<?php
    endif;

    if ($get_errors || $get_fields) :
?>
        <div class="col mx-auto" style="max-width: 850px;">
            <pre class="mb-0">
<?php
                dump('get_errors');
                dump('get_fields');
?><hr></pre>
        </div>
<?php
    endif;

    if ($auto_test && $get_auto_test) :
?>
        <div class="col mx-auto" style="max-width: 500px;">
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

    require_once(ABSPATH . 'inc/' . $view . '/footer.php');