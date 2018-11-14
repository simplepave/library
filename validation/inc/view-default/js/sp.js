/**
 * Project: Validation
 */

/**
 * @SimplePAVE
 * https://t.me/SimplePAVE
 * info@simplepave.ru
 */

jQuery(document).ready(function($){

    /**
     * dropdown
     */

    // let spDropdownMenu = false;

    // $('.sp-dropdown > a.btn').hover(function() {
    //     if (!$('.sp-dropdown').hasClass('show'))
    //         $('.sp-dropdown .dropdown-toggle').trigger('click');
    // } , function() {
    //     setTimeout(function() {
    //         if (!spDropdownMenu && $('.sp-dropdown').hasClass('show'))
    //             $('.sp-dropdown .dropdown-toggle').trigger('click');
    //     }, 2000);
    // });

    // $('.sp-dropdown .dropdown-menu').hover(function() {
    //     spDropdownMenu = true;
    // } , function() {
    //     spDropdownMenu = false;
    //     setTimeout(function() {
    //         if (!spDropdownMenu && $('.sp-dropdown').hasClass('show'))
    //             $('.sp-dropdown .dropdown-toggle').trigger('click');
    //     }, 2000);
    // });

    /**
     * Auto Test
     */

    $('#sp-auto-test').click(function(e) {
        e.preventDefault();
        if ($(this).hasClass('working')) return;
        $(this).addClass('working')
        let spForm = $('#sp-form');
        let action = spForm.attr('action');
        let sep = ~action.indexOf('?')? '&': '?';

        spForm.attr('action', action + sep + 'auto_test=on').submit();
    });

    /**
     * Storage
     */

    $('.sp-nav-session a').click(function(e) {
        try {
            sessionStorage.setItem('sp_nav_session', $(this).attr('href'));
        }
        catch (e) {
            if (e == QUOTA_EXCEEDED_ERR)
                console.log('QUOTA_EXCEEDED_ERR');
        }
    });

    (function() {
        let arg = sessionStorage.getItem('sp_nav_session');
        let nav = $('.sp-nav-session a[href="' + arg + '"]');

        if (arg !== null) {
            if (nav.length)
                nav.trigger('click');
            else
                sessionStorage.removeItem('sp_nav_session');
        }

        $('.sp-tab-session').show();
    }());

    /**
     * Phone
     */

    let phonemask = $('.phone-mask');

    if (phonemask.length)
        phonemask.inputmask({
            mask: '+9 (999) 999-99-99',
            clearMaskOnLostFocus: true,
            clearIncomplete: true
        });
});