/**
 * Плагин для загрузки изображения через ajax
 */
(function ($) {
    $.fn.imageUploader = function (options) {
        return this.each(function () {
            var file;
            var imageLinkHolder = $($(this).data('link-holder'));
            var imageHolder = $($(this).data('image-holder'));
            var $inputImage = $(this);
            var aspectRatio = $($(this).data('aspect-ratio'));
            if (window.FileReader) {
                $inputImage.change(function () {
                    var files = this.files;
                    if (!files.length) {
                        return;
                    }
                    file = files[0];

                    $inputImage.val("");
                    imageHolder.attr('src', '/images/preloader.gif');

                    var form_data = new FormData();
                    form_data.append('photo', file);
                    $.ajax({
                        type: 'POST',
                        url: $(this).data('upload-url'),
                        data: form_data,
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function (dataResponse) {
                            imageLinkHolder.val(dataResponse.filename);
                            imageHolder.attr('src', dataResponse.for_crop);
                            // initCropper($('.js-image-holder'),aspectRatio);
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });

                });
            }

        });

    };
})(jQuery);



function initCropper(image,aspectRatio) {
    $(image).cropper('destroy');
    $(image).cropper({

        aspectRatio: aspectRatio[0],
        zoomable: false,
        checkImageOrigin: false,
        cropend: function () {
            var data = image.cropper("getData");
            $('#cropX').val(data.x);
            $('#cropY').val(data.y);
            $('#cropWidth').val(data.width);
            $('#cropHeight').val(data.height);
        },
    });
    var data = image.cropper("getData");
    $('#cropX').val(data.x);
    $('#cropY').val(data.y);
    $('#cropWidth').val(data.width);
    $('#cropHeight').val(data.height);
}
