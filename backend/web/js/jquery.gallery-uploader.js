//сырая версия новой галереи

$(document).ready(function () {
    $(".gallery-uploader").change(function () {
        $.each($(this)[0].files, function (i, val) {
            photo = new FormData();
            photo.append('photo', val);
            $.ajax({
                url: '/upload/image',
                processData: false,
                contentType: false,
                data: photo,
                type: "post",
                dataType: 'json',
                success: function (data) {
                    $('.main').append('<div class="js-gallery-item">\n' +
                        '<div class="img-wrap"><img src="' + data.preview_url + '"/><input type="text" class="hide filename" name="ModelGallery[arrayImages][]" value="' + data.filename + '"></div>' +
                        '<div class="text-wrap"><button>Удалить</button></div>' +
                        '</div>');
                }
            });
        });
    });


    $(".gallery-uploader-desc").change(function () {
        var count_item = 0;
        $(".desc .js-gallery-item").each(function () {
            var element = $(this),
                value = element.data("num");
            if (value > count_item) {
                count_item = value;
            }
        });
        count_item++;
        
        $.each($(this)[0].files, function (i, val) {
            var _current_count = i + count_item;
            photo = new FormData();
            photo.append('photo', val);
            $.ajax({
                url: '/upload/image',
                processData: false,
                contentType: false,
                data: photo,
                type: "post",
                dataType: 'json',
                success: function (data) {
                    $('.desc').append('  <div class="js-gallery-item" data-num="'+_current_count+'">\n' +
                        '                        <div class="img-wrap">\n' +
                        '                        <img class="js-img" src="' + data.preview_url + '"/>\n' +
                        '                        <input type="text" class="hide filename" name="PhotoDescriptionProduct[arrayImages]['+_current_count+'][photo]"\n' +
                        '                    value="' + data.filename + '">\n' +
                        '                        </div>\n' +
                        '                        <div class="text-wrap">\n' +
                        '                        <input type="text" class="text" name="PhotoDescriptionProduct[arrayImages]['+_current_count+'][title_en]" value="title_en">\n' +
                        '                        <input type="text" class="text" name="PhotoDescriptionProduct[arrayImages]['+_current_count+'][title_fr]" value="title_fr">\n' +
                        '                        <button>Удалить</button>\n' +
                        '                        </div>\n' +
                        '                        </div>');
                }
            });
        });
    });
});

$(document).on('click', '.text-wrap button', function (e) {
    e.preventDefault();
    $(this).parents('.js-gallery-item').remove();
});