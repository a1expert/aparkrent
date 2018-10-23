/**
 * Created at 13.12.2017 15:19
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */
$(document).on('click', '.js-delete-in-car', function () {
    var _this = $(this);
    if (confirm('Вы действительно хотите удалить?')) {
        $.ajax({
            url: _this.data('url'),
            method: 'post',
            dataType: 'json'
        });
    }
});

$(document).on('click', '.js-add-defect-to-car', function () {
    $.ajax({
        url: $(this).data('url'),
        method: 'post',
        dataType: 'json',
        success: function (data) {
            if (data.status == 'ok') {
                $('.modal-content').html(data.content);
                openModal();
                $('.mfp-wrap').removeAttr('tabindex');
            }
        }
    });
});

function openModal() {
    $.magnificPopup.open({
        items: {
            src: '#modal'
        },
        type: 'inline',
        fixedContentPos: true,
        fixedBgPos: true,

        overflowY: 'auto',

        closeBtnInside: true,
        preloader: false,

        midClick: true,
        removalDelay: 300,
    }, 0);
}