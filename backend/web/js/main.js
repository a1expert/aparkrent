$(document).ready(function () {
    var phone = new Inputmask('+79999999999');
    phone.mask('.js-phone-mask');

    var inn = new Inputmask('9999999999');
    inn.mask('.js-inn');

    // var kpp = new Inputmask('9999999999');
    // kpp.mask('.js-kpp-mask');



    $('.datepicker').datepicker({
        changeMonth : true,
        changeYear : true,
        yearRange : "1950:2017",
        dateFormat : 'dd-mm-yy'
    });

    $(document).on('click', '.open-button', function (event) {
        event.preventDefault();
        if ($(this).parent().hasClass('open-list')) {
            $(this).parent().removeClass('open-list');
            $(this).next().slideUp(600);
        } else {
            $('.faq-head').not(this).parent().removeClass('open-list');
            $('.faq-head').not(this).next().slideUp(600);
            $(this).parent().addClass('open-list');
            $(this).next().slideDown(600);
        }
    });

    $(document).on('click', '.link-selectors div', function () {
        $('.link-selectors div.active').removeClass('active');
        $('.link-target.active').removeClass('active');
        $($(this).data('target')).addClass('active');
        $(this).addClass('active');
    });
});