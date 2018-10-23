/**
 * Created at 07.10.2017 15:45
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */
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

function getBik(query) {
    $.ajax({
            url: '/suggest/bik?query=' + query,
            method: 'get',
            dataType: 'json',
            success: function (data) {
                if (data) {
                    $('#client-bik').val(data.data.bic);
                    $('#client-correspondent_account').val(data.data.correspondent_account);
                }
            }
        }
    );
}

function getCurrentClientId() {
    return location.search.replace('?id=', '');
}

function refreshFileTable() {
    $.ajax({
        method: 'post',
        url: '/client/get-file-table?id=' + getCurrentClientId(),
        dataType: 'json',
        success: function (data) {
            if (data.status == 'ok') {
                $('#files .js-files-content').html(data.content);
            } else {
                toastr.error("Ошибка при обновлении данных. Пожалуйста, перезапустите страницу");
            }
        }
    });
}

$(document).on('submit', '#to-client-form', function (event) {
    event.preventDefault();
    var _this = $(this);
    $.ajax({
        url: _this.attr('action'),
        method: 'post',
        data: _this.serializeArray(),
        dataType: 'json',
        success: function (data) {
            if (data.status == 'ok') {
                if (data.loaded == 'true') {
                    $('.mfp-close').click();
                    refreshFileTable();
                    toastr.success('Выполнено успешно');
                }
            } else {
                toastr.success('Произошла ошибка, попробуйте позже');
            }
        }
    });
});

$(document).on('click', '.js-update-and-new-to-client', function () {
    $.ajax({
        url: $(this).data('url') + '?id=' + $(this).data('id'),
        method: 'post',
        dataType: 'json',
        success: function (data) {
            if (data.status == 'ok') {
                $('.modal-content').html(data.content);
                $('#fileUploader').fileUploader();
                openModal();
                $('.datepicker').datepicker({
                    changeMonth: true,
                    dateFormat: 'dd-mm-yy'
                });
            }
        }
    });
});

$(document).on('click', '.js-delete-in-client', function () {
    var _this = $(this);
    if (confirm('Уверены, что хотите удалить этот файл?')) {
        $.ajax({
            url: _this.data('url') + '?id=' + _this.data('id'),
            method: 'post',
            dataType: 'json',
            success: function (data) {
                if (data.status == 'ok') {
                    refreshFileTable();
                    toastr.success('Удаление прошло успешно!');
                } else {
                    toastr.error('Произошла ошибка, попробуйте позже');
                }
            }
        });
    }
});

$(document).on('change', '.js-type-change', function () {
    var _this = $(this);
    $.ajax({
        url: '/client/get-special-fields?id=' + _this.data('id') + '&type=' + _this.val(),
        method: 'post',
        dataType: 'json',
        success: function (data) {
            if (data.status == 'ok') {
                $('.js-special-fields').html(data.content);
            }
            $('.js-type-target').hide();
            $('.type-' + _this.val()).show();
        }
    });
});

$(document).on('change', '.js-client-change-status', function () {
    var _this = $(this);
    $.ajax({
        url: '/client/status-change',
        method: 'post',
        dataType: 'json',
        data: {
            id: _this.data('id'),
            status: _this.val(),
        },
        success: function (data) {
            if (data.status == 'ok') {
                _this.parents('tr').removeClass('red');
                _this.parents('tr').removeClass('green');
                _this.parents('tr').removeClass('gray');
                switch (_this.val()) {
                    case '0':
                        _this.parents('tr').addClass('red');
                        break;
                    case '1':
                        _this.parents('tr').addClass('green');
                        break;
                    case '3':
                        _this.parents('tr').addClass('gray');
                        break;
                }
                toastr.success('Статус успешно изменен');
            } else {
                toastr.error(data.message);
            }
        }
    })
});

$(document).on('change', '.js-client-change', function () {
    if ($(this).val() == '') {
        $('.js-new-client-fields').show();
    } else {
        $('.js-new-client-fields').hide();
    }
});

$(document).on('change', '.js-inn', function () {
    var _this = $(this);
    $.ajax({
        url: '/suggest/inn?query=' + _this.val(),
        method: 'get',
        dataType: 'json',
        success: function (data) {
            if (data) {
                $('.js-kpp').val(data.data.kpp);
                $('.js-ogrn').val(data.data.ogrn);
                $('.js-company-name').val(data.value);
                $('.js-company-address').val(data.data.address.value);
                getBik(data.data.name.full);
            }
        }
    });
});

$(document).on('click', '.js-new-password-button', function (e) {
    e.preventDefault();
    var _this = $(this);
    $.ajax({
        url: _this.attr('href'),
        method: 'post',
        dataType: 'json',
        success: function (data) {
            if (data.status == 'success') {
                toastr.success('Новый пароль успешно оправлен');
            } else {
                toastr.error(data.message);
            }
        }
    })
});