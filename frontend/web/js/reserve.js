var filesToSend = []; // файлы из дропзоны(только имя и путь на сервере)

$(document).ready(function () {

    function hidePriceSection() {
        if (($(document).scrollTop() + $(window).height()) >= $('body').height() - 76) {
            $('#price-section').addClass('hide')
        } else {
            $('#price-section').removeClass('hide')
        }
    }

    hidePriceSection();

    $(document).scroll(function () {
        hidePriceSection();
    });

    function countPrice() {
        $.ajax({
            url: '/reserve/count-price',
            data: $('form.reserve-page:first').serializeArray(),
            dataType: 'json',
            method: 'post',
            beforeSend: function (request) {
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            success: function (data) {
                if (data.status == 'ok') {
                    $('.js-price').html(data.answer.price);
                    $('.js-price-input').val(data.answer.price);
                    $('.error-summary').html(data.answer.message);
                    // $('.error-summary').html('');
                }
            }
        });
    }

    function resetPage() {
        var model = $('input[name="ReserveForm[model_id]"]').val();
        $('input').val('');
        $('input[name="ReserveForm[model_id]"]').val(model);
        $('.non-choice').attr('selected', 'selected');
        $('.js-price-input').val(0);
        $('.js-price').html(0);
        $('.check-other-job').removeClass('active');
        $('input[name="ReserveForm[type]"]').val(1);
        $('.js-radio-target').attr('placeholder', 'ФИО');

        if(dropzone !== undefined) {
            dropzone.removeAllFiles();
        }

        $('.additional-parameters').css({'display':'none'});
        $('.additional-parameters-switch').find("input").prop("checked", false);

        filesToSend = [];
    }

    $(document).on('change', '.js-date', function () {
        countPrice();
    });

    $(document).on('keyup', '.js-input-delivery-time', function () {
        countPrice();
    });

    $(document).on('change', '.js-delivery-select', function () {
        var _this = $(this);
        var address = _this.find('option[value="' + _this.val() + '"]').data('address');
        if (_this.hasClass('delivery')) {
            $('input.delivery').val(address);
        } else {
            $('input.return').val(address);
        }
        countPrice();
    });

    $(document).on('click', '.check-other-job', function () {
        if ($(this).children('input').val() == 1) {
            $(this).children('input').val(0);
        } else {
            $(this).children('input').val(1);
        }
        countPrice();
    });

    $(document).on('submit', 'form.reserve-page', function (event) {
        event.preventDefault();
        var _this = $(this);
        var data = _this.serializeArray();
        $.each(filesToSend, function (index, object) {
            data[data.length] = {
                name: 'ReserveForm[files][' + index + '][name]',
                value: object.name,
            };
            data[data.length] = {
                name: 'ReserveForm[files][' + index + '][path]',
                value: object.path,
            };
        });
        $.ajax({
            method: 'post',
            url: '/reserve/create',
            dataType: 'json',
            data: data,
            beforeSend: function (request) {
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            success: function (data) {
                var errorSummary = _this.find('.error-summary');
                if (data.status == 'ok') {
                    yaCounter45911007.reachGoal('reserve');
                    $('#success').html(data.message);
                    $.magnificPopup.open({
                        items: {
                            src: '#reserve-success'
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
                    resetPage();
                    $('.error-summary').empty();
                } else {
                    errorSummary.css('color', '#931009');
                    errorSummary.html(data.message);
                }
            }
        })
    });

    $(document).on('click', '.radio_button', function () {
        $('.js-radio-target').val('');
        $('.js-radio-target').attr('placeholder', $(this).data('placeholder'));
        $('input[name="ReserveForm[type]"]').val($(this).data('type'));
        $('.radio_button').removeClass('active');
        $(this).addClass('active');
    });

    if ($('div.file-loader').length > 0) {
        var dropzone = new Dropzone('div.file-loader', {
            url: "/tools/upload-registration-image",
            paramName: 'image_files',
            maxFilesize: 5,
            headers: {
                'X-CSRF-Token': $("meta[name='csrf-token']").attr('content'),
            },
            previewTemplate: '<div class="file_box"><span data-dz-name></span><div class="x" data-dz-remove></div></div>',
        });


        dropzone.on('complete', function (file) {
            if (!file.accepted) {
                var files = $(this)[0].previewsContainer.childNodes;
                files[files.length - 1].remove();
                alert('Данный тип файла не поддерживается!');
            }
        });

        dropzone.on('success', function (file) {
            var path = JSON.parse(file.xhr.response).filename;
            var fileName = file.name;
            filesToSend.push({
                name: fileName,
                path: path,
            });
        });

        dropzone.on('removedfile', function (file) {
            var path = JSON.parse(file.xhr.response).filename;
            for (var i = 0; i < filesToSend.length; i++) {
                if (path == filesToSend[i]['path']) {
                    filesToSend.splice(i, 1);
                }
            }
        });

        $(document).on('click', '.dropzone-message', function () {
            $('.file-loader').click();
        });
    }

    $.datetimepicker.setLocale('ru');

    $('.datetimepicker').datetimepicker({
        minDate: 0,
        format: 'Y-m-d',
        dayOfWeekStart: 1,
        timepicker: false,
        scrollMonth: false,
        scrollInput: false
    });

    countPrice();

    $('#redirect-to-main').click(function(){
        if(!device.mobile()) {
            window.location.href = '/';
        }
    });

    $('.js-date-range-picker').dateRangePicker({
        singleMonth: true,
        showShortcuts: false,
        showTopbar: false,
        language: 'ru',
        startDate: moment().endOf('day').format('YYYY-MM-DD'),
        separator: ' до ',
    }).bind('datepicker-closed', function(){
        countPrice();
    });

    // Подключение Magnific Modal
    $('.popup-reserve').magnificPopup({
        type: 'inline',

        fixedContentPos: false,
        fixedBgPos: true,

        overflowY: 'auto',

        closeBtnInside: true,
        preloader: false,

        midClick: true,
        removalDelay: 300,
        mainClass: 'my-mfp-zoom-in',

        callbacks: {
            open: function(data) {
                var magnificPopup = $.magnificPopup.instance;

                var id = $(magnificPopup.st.el).data('id');
                var title = $(magnificPopup.st.el).data('title');

                $(magnificPopup.content).find('.title').text(title);
                $(magnificPopup.content).find('#reserveform-model_id').val(id);
            },
            close: function() {
                resetPage();
            }
        }
    });

});