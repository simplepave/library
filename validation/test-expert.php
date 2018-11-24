<?php

    $sp_valid->set_auto_test([
        'phone'   => '+11112223344',
        'email'   => 'user@test.com',
        'subject' => 'Subject test',
    ]);

    // $sp_valid->set_bail_rev();
    // $sp_valid->set_bail_all();

    $sp_valid->set_language([
        'required'    => 'Field is required.',
        'accepted'    => 'Confirm selection.',
        'max'         => 'Max %s characters.',
        'min'         => 'Min %s characters.',
        'numeric'     => 'Not a number.',
        'float'       => 'Not a float.',
        'between'     => 'Not between %s and %s.',
        'string'      => 'Not a string.',
        'regex'       => 'Wrong format.',
        'date'        => 'Not a date.',
        'date_format' => 'Format: %s',
        'confirmed'   => 'Does not match "%s".',
        'email'       => 'Not a email.',
        'phone'       => 'Not a phone.',
    ]);

    $sp_valid->validation($request_post, [
        'phone'   => 'bail|required|phone:format|max:25',
        'email'   => 'title:E-mail :|bail|required|group:mail|email|max:100',
        'subject' => 'title:Subject -|required|group:mail',
    ]);

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

    <input name="phone"   type="tel"   value="<?php echo $_form('phone'); ?>" placeholder="PHONE" class="phone-mask">
    <input name="email"   type="email" value="<?php echo $_form('email'); ?>" placeholder="EMAIL">
    <input name="subject" type="text"  value="<?php echo $_form('subject'); ?>">

<!-- End Form -->

<script type="text/javascript">
    jQuery(document).ready(function($){
        // ...
    });
</script>