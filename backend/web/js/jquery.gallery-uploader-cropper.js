/**
 * Плагин для загрузки изображения через ajax
 */
(function ($) {
    $.fn.galleryUploader = function (options) {
        return this.each(function () {
            var file;
            var $inputImage = $(this);

            if (window.FileReader) {
                $inputImage.change(function () {
                    var files = this.files;
                    var counter = $inputImage.data('counter');
                    for (var i = 0; i < files.length; i++) {
                        file = files[i];
                        var form_data = new FormData();
                        form_data.append('photo', file);
                        form_data.append('counter', counter);
                        $.ajax({
                            type: 'POST',
                            url: $inputImage.data('url'),
                            data: form_data,
                            processData: false,
                            contentType: false,
                            dataType: "json",
                            success: function (dataResponse) {
                                $inputImage.parents('.size-block').children('.js-images-block').append(dataResponse.content);
                            },
                            error: function (data) {
                                alert(data.responseText);
                            }
                        });
                        counter++;
                    }
                    $inputImage.attr('data-counter', counter);
                    $inputImage.val('');
                });
            }

        });

    };
})(jQuery);