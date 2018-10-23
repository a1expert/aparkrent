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

function getCurrentReserveId() {
    return location.search.replace('?id=', '');
}

function refreshTables() {
    $.ajax({
        method: 'post',
        url: '/reserve/get-tables?id=' + getCurrentReserveId(),
        dataType: 'json',
        success: function (data) {
            if (data.status == 'ok') {
                $('#files .js-content').html(data.files);
                $('#fines .js-content').html(data.fines);
                $('#reserve-children .js-content').html(data.reserve_children);
                $('#info').html(data.info);
            } else {
                toastr.error("Ошибка при обновлении данных. Пожалуйста, перезапустите страницу");
            }
        }
    });
}

$(document).on('click', '.js-generate-file', function () {
    var _this = $(this);
    $('.info-file').html('Начата генерация документа');
    $.ajax({
        url: _this.data('url'),
        data: {
            file_type_id: $('#reservefile-type_id').val()
        },
        dataType: 'json',
        success: function (data) {
            if (data.status == 'success') {
                $('#link-holder').val(data.filepath);
                $('#name-holder').val(data.filename);
                toastr.success(data.message);
            } else {
                toastr.error(data.message);
            }
            $('.info-file').html('');
        }
    })
});

$(document).on('submit', '#to-reserve-form', function (event) {
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
                    refreshTables();
                    $('.mfp-close').click();
                    toastr.success('Данные успещно обновлены');
                } else {
                    $('.modal-content').html(data.content);
                    openModal();
                }
            } else {
                toastr.error('Произошла ошибка. Пожалуйста, перезагрузите страницу');
            }
        }
    });
});

// Добавление и редактирование файлов и штрафов
$(document).on('click', '.js-update-and-new-to-reserve', function () {
    $.ajax({
        url: $(this).data('url') + '?id=' + $(this).data('id'),
        method: 'post',
        dataType: 'json',
        success: function (data) {
            if (data.status == 'ok') {
                if (data.loaded == 'true') {
                    refreshTables();
                    $('.mfp-close').click();
                    toastr.success('Данные успещно обновлены');
                } else {
                    $('.modal-content').html(data.content);
                    $('#fileUploader').fileUploader();
                    openModal();
                    $('.datepicker').datepicker({
                        changeMonth: true,
                        dateFormat: 'dd-mm-yy'
                    });
                }
            }
        }
    });
});

$(document).on('click', '.js-delete-in-reserve', function () {
    var _this = $(this);
    if (confirm('Уверены, что хотите удалить?')) {
        $.ajax({
            url: _this.data('url') + '?id=' + _this.data('id'),
            method: 'post',
            dataType: 'json',
            success: function (data) {
                if (data.status == 'ok') {
                    refreshTables();
                    toastr.success('Удаление прошло успешно!');
                } else {
                    toastr.error('Произошла ошибка, попробуйте позже');
                }
            }
        });
    }
});

$(document).on('change', '.js-type-selector', function () {
    var current = $(this).val();
    $.ajax({
        url: '/reserve/get-list-service',
        method: 'post',
        data: {
            type: $(this).val(),
        },
        dataType: 'json',
        success: function (data) {
            if (data.status == 'ok') {
                $('.js-service-list').empty();
                $.each(data.array, function (index, value) {
                    $('.js-service-list').append('<option value="' + index + '">' + value + '</option>');
                });
            }
        }
    });
    $('.js-type-target').hide();
    $('.js-type-' + current).show();
});

$(document).on('click', '.js-count-price', function (event) {
    event.preventDefault();
    $.ajax({
        url: $(this).attr('href'),
        method: 'get',
        dataType: 'json',
        success: function (data) {
            if (data.status == 'ok') {
                $('.js-price-target').html(data.price);
                toastr.success('Успешно');
            } else {
                toastr.error(data.message);
            }
        }
    })
});

$(document).on('change', '.js-reserve-change-status', function () {
    var _this = $(this);
    $.ajax({
        url: '/reserve/status-change',
        method: 'post',
        dataType: 'json',
        data: {
            id: _this.data('id'),
            status: _this.val(),
        },
        success: function (data) {
            if (data.status == 'ok') {
                _this.parents('tr').removeClass('gray');
                _this.parents('tr').removeClass('red');
                _this.parents('tr').removeClass('green');
                switch (_this.val()) {
                    case '1':
                        _this.parents('tr').addClass('red');
                        break;
                    case '2':
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

$(document).on('change', '.js-reserve-change-lead-status', function () {
    $.ajax({
        url: '/reserve/lead-status-change',
        method: 'post',
        dataType: 'json',
        data: {
            id: $(this).data('id'),
            status: $(this).val(),
        },
        success: function (data) {
            if (data.status == 'ok') {
                toastr.success('Статус успешно изменен');
            } else {
                toastr.error(data.message);
            }
        }
    })
});

$(document).on('click', '.js-count-child-price', function () {
    var _this = $(this);
    $.ajax({
        url: _this.data('url'),
        method: 'post',
        dataType: 'json',
        data: {
            id: $(this).data('id'),
        },
        success: function (data) {
            if (data.status == 'ok') {
                $('#js-child-price-'+_this.data('id')).html(data.price);
                toastr.success('Успешно!');
            } else {
                toastr.error(data.message);
            }
        }
    })
});

$(document).on('click', '.js-set-pay', function () {
    if (confirm('Вы уверены, что хотите поставить оплату?')) {
        $.ajax({
            url: $(this).data('url'),
            method: 'post',
            success: function (data) {
                if (data.status == 'success') {
                    toastr.success('Успешно!');
                    refreshTables();
                } else {
                    toastr.error(data.message);
                }
            }
        });
    }
});

$(document).on('click', '.js-return-pay', function () {
    if (confirm('Вы уверены, что хотите отменить оплату?')) {
        $.ajax({
            url: $(this).data('url'),
            method: 'post',
            success: function (data) {
                if (data.status == 'success') {
                    toastr.success('Успешно!');
                    refreshTables();
                } else {
                    toastr.error(data.message);
                }
            }
        });
    }
});