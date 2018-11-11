<?php

    // $sp_valid->set_bail_rev();
    // $sp_valid->set_bail_on();

    $sp_valid->set_auto_test([
        'subject' => 'Subject test',
        'phone'   => '+11112223344',
        'email'   => 'user@user.com',
    ]);

    $validation = $sp_valid->validation([
        'subject' => 'title:Subject - |required|group:mail',
        'phone'   => 'title:Tel : |bail|required|group:mail|phone|max:25',
        'email'   => 'title:E-mail : |bail|required|group:mail|email|max:100',
    ]);

    $_form = sp_form();
?>


    <input name="phone"   type="tel"    value="<?php echo $_form['phone']; ?>" placeholder="PHONE" class="my-phone-mask">
    <input name="email"   type="email"  value="<?php echo $_form['email']; ?>" placeholder="EMAIL">
    <input name="subject" type="hidden" value="Subject!">


<script type="text/javascript">
    jQuery(document).ready(function($){
        $('.my-phone-mask').inputmask({mask: '+9 (999) 999-99-99', clearMaskOnLostFocus: true, clearIncomplete: true});
    });
</script>