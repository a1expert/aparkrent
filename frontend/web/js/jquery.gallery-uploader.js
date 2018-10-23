/**
 * Плагин для загрузки изображения через ajax
 */
(function ($) {
    $.fn.galleryUploader = function () {
        return this.each(function () {
            var _this = $(this);
            var sendAjax = function (gallery, index) {
                if (gallery.length > index) {
                    var gallery_item = gallery[index];
                    return $.ajax({
                        type: 'POST',
                        url: gallery_item.url,
                        data: gallery_item.form_data,
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        beforeSend: function (request) {
                            return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                        },
                        success: function(data) {
                            gallery_item.image.attr('src', data.preview_url);
                            gallery_item.input.val(data.preview_url);
                        },
                        error: function(data) {
                        },
                        complete: function () {
                            sendAjax(gallery, ++index);
                        }
                    });
                }
            };

            _this.on('change', function(){
                if (_this[0].files) {
                    var gallery = [];
                    for (var i = 0; i < _this[0].files.length; i++) {
                        var form_data = new FormData();
                        form_data.append('image_files', _this[0].files[i]);
                        form_data.append('image_path', $(this).data('path'));
                        var galleryBlock  = {
                            url : $(this).data('upload-url'),
                            form_data: form_data,
                            image : $('<img src="/images/loading_coupon.gif" style="width: 200px">'),
                            input : $('<input type="hidden"  name="'+ $(this).data('model') +'"/>')
                        };
                        //$('.label-'+ $(this).data('block-image')).remove();
                        $('.removeBlock-'+ $(this).data('block-image')).html('').append(galleryBlock.image).append(galleryBlock.input);
                        gallery.push(galleryBlock);
                    }
                    sendAjax(gallery, 0);
                    _this.val('');
                }
            });
        });
    };
})(jQuery);
$(document).on('click', function(){
    $('.gallery-uploader').galleryUploader();
});
