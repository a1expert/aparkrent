/**
 * Created at 26.10.2017 19:00
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */
$(document).on('submit', '.js-find-reserve', function (e) {
    e.preventDefault();
    var _this = $(this);
    $.ajax({
        url: '/site/pay',
        dataType: 'json',
        method: 'post',
        data: {
            id: $('.js-reserve-id').val(),
        },
        beforeSend: function(request) {
            return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
        },
        success: function (data) {
            if (data.status == 'ok') {
                _this.find('.error-summary').html('');
                if ($('.online-pay-info').length == 0) {
                    $('.online-pay').after(data.content);
                } else {
                    $('.online-pay-info').replaceWith(data.content);
                }
            } else {
                _this.find('.error-summary').html(data.message);
                $('.online-pay-info').detach();
            }
        }
    });
});
