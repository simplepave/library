

    <input name="phone"   type="tel"    value="<?php echo $_POST['phone']; ?>" placeholder="PHONE">
    <input name="email"   type="email"  value="<?php echo $_POST['email']; ?>" placeholder="EMAIL">
    <input name="subject" type="hidden" value="Subject!">


<?php

    // $sp_valid->set_bail_rev();
    // $sp_valid->set_bail_on();

    $sp_valid->set_auto_test([
        'subject' => 'Subject',
        'phone'   => '+71112223344',
        'email'   => 'user@user.com',
    ]);

    $validation = $sp_valid->validation([
        'subject' => 'required|group:mail',
        'phone'   => 'bail|required|group:mail|phone|max:25',
        'email'   => 'bail|required|group:mail|email|max:100',
    ]);
