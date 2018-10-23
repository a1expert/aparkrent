/**
 * Created at 07.11.2017 19:06
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */
$(document).on('change', '.js-child-form :input', function () {
    var form = $('.js-child-form');
    $.ajax({
        url: '/reserve-child/refresh?id='+form.data('reserve-id')+'&child_id='+form.data('child-id'),
        method: 'post',
        data: form.serializeArray(),
        dataType: 'json',
        success: function (data) {
            if (data.status == 'ok') {
                $('.modal-content').html(data.content);
            }
        }
    });
});