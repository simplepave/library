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

        <link rel="apple-touch-icon" sizes="180x180" href="/validation/inc/view-default/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/validation/inc/view-default/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/validation/inc/view-default/favicon/favicon-16x16.png">
        <link rel="manifest" href="/validation/inc/view-default/favicon/site.webmanifest">
        <link rel="mask-icon" href="/validation/inc/view-default/favicon/safari-pinned-tab.svg" color="#052128">
        <meta name="msapplication-TileColor" content="#052128">
        <meta name="theme-color" content="#ffffff">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="/validation/inc/view-default/css/bootstrap.min.css">

        <title><?php echo $get_page? $get_page . ' | ': '', $home_title; ?></title>

        <style type="text/css">
            .form-control:focus {
                border-color: #17a2b8;
                box-shadow: 0 0 0 .2rem rgba(23, 162, 184, .5);
            }
            .sp-submit {
                transition: 0.5s;
                background-size: 4rem 4rem;
                background-image: linear-gradient(-45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);
            }
            .sp-submit:hover {
                background-position: -20px center;
            }
            .block-striped {
                background-size: 2rem 2rem;
                background-image: linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);
            }
            .sp-dropdown:hover > .dropdown-menu {
                display: block;
            }
            .sp-table tr:first-child td {
                border-top: none;
            }
        </style>

        <script src="/validation/inc/view-default/js/jquery-3.3.1.slim.min.js"></script>
    </head>
    <body>