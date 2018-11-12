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