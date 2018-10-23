/**
 * Плагин для загрузки изображения через ajax
 */
(function ($) {
    $.fn.fileUploader = function (options) {
        return this.each(function () {
            var file;
            var info = $($(this).data('info'));
            var imageLinkHolder = $($(this).data('link-input'));
            var $inputImage = $(this);
            var imageNameHolder = $($(this).data('name-input'));
            console.log(info);

            if (window.FileReader) {
                $inputImage.change(function () {
                    var files = this.files;
                    if (!files.length) {
                        return;
                    }
                    file = files[0];
                    // fileReader.readAsDataURL(file);
                    // fileReader.onload = function () {
                    $inputImage.val("");
                    // };

                    var form_data = new FormData();
                    info.html('Загрузка начата');
                    // var last_image = imageHolder.attr('src');
                    form_data.append('file', file);
                    $.ajax({
                        type: 'POST',
                        url: $(this).data('upload-url'),
                        data: form_data,
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function (dataResponse) {
                            console.log(dataResponse);
                            imageLinkHolder.val(dataResponse.path);
                            imageNameHolder.val(dataResponse.filename);
                            info.html('Загрузка завершена успешно');
                            $('.file-info-block .file-title').text(file.name);
                            $('.file-info-block').show();
                        },
                        error: function (data) {
                            alert(data.responseText);
                            info.html('Ошибка при загрузке');
                        }
                    });

                });
            }

        });

    };
})(jQuery);