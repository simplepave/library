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
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="/validation/inc/view-default/css/bootstrap.min.css">

        <title><?php echo isset($get_page)? $get_page . ' | ': '', $home_title; ?></title>

        <style type="text/css">
            .form-control:focus {
                border-color: #17a2b8;
                box-shadow: 0 0 0 .2rem rgba(23, 162, 184, .5);
            }
        </style>

        <script src="/validation/inc/view-default/js/jquery-3.3.1.slim.min.js"></script>
    </head>
    <body>