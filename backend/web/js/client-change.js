/**
 * Created at 07.10.2017 20:15
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */
$(document).on('click', '.js-decision-change', function () {
    var _this = $(this);
    $.ajax({
        url: _this.data('url'),
        method: 'post',
        dataType: 'json',
        success: function (data) {
            if (data.status == 'ok') {
                _this.parents('tr').detach();
            }
        }
    });
});