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
     * Phone
     */

    var phonemask = $('.phone-mask');

    if (phonemask.length)
        phonemask.inputmask({
            mask: '+9 (999) 999-99-99',
            clearMaskOnLostFocus: true,
            clearIncomplete: true
        });

});