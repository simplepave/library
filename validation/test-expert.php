<?php

    // $sp_valid->set_bail_rev();
    // $sp_valid->set_bail_on();

    $sp_valid->set_auto_test([
        'subject' => 'Subject test',
        'phone'   => '+11112223344',
        'email'   => 'user@user.com',
    ]);

    $validation = $sp_valid->validation([
        'subject' => 'title:Subject -|required|group:mail',
        'phone'   => 'bail|required|phone:format|max:25',
        'email'   => 'title:E-mail :|bail|required|group:mail|email|max:100',
    ]);

    $_form = $sp_valid->get_form();

?>

<!-- Form -->

    <input name="phone"   type="tel"    value="<?php echo $_form['phone']; ?>" placeholder="PHONE" class="phone-mask">
    <input name="email"   type="email"  value="<?php echo $_form['email']; ?>" placeholder="EMAIL">
    <input name="subject" type="hidden" value="Subject!">

<!-- End Form -->

<script type="text/javascript">
    jQuery(document).ready(function($){
        // ...
    });
</script>