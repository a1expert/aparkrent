function cropperInit(params) {
    var fileReader = new FileReader(),
        file;
    var container = params.imageContainer;
    container.hide();
        var $image = params.cropperImageHolder;
    var imageHolder = params.imageHolder;
    var imageLinkHolder = params.imageLinkHolder;
    var saveButton = params.saveButton;
    var $inputImage = params.uploadInput;

    function init() {

        if (window.FileReader) {
            $inputImage.change(function () {
                var files = this.files;
                if (!files.length) {
                    return;
                }

                file = files[0];

                if (/^image\/\w+$/.test(file.type)) {
                    container.show();
                    fileReader.readAsDataURL(file);
                    fileReader.onload = function () {
                        $inputImage.val("");
                        $image.cropper("destroy");
                        $image.attr('src', this.result);
                        $($image).cropper({
                            aspectRatio: params.imageWidth / params.imageHeight, //параметр передан из страницы image.php
                            preview: params.cropperImagePreviewHolder,
                            viewMode: 0,
                            zoomable: true,
                            checkImageOrigin: false,
                            minContainerHeight:params.imageHeight*1.2,
                        });
                    };
                } else {
                    alert("Выберите файл изображения.");
                }
            });
        } else {
            $inputImage.addClass("hide");
        }


    }

    var cropBoxData,
        canvasData;

    init();


    saveButton.on('click', function () {

        var data = $image.cropper("getData"),
            val = "";
        try {
            val = JSON.stringify(data);
        } catch (e) {
            console.log(data);
        }
        console.log(data);

        var crop_x = data.x;
        var crop_y = data.y;
        var crop_w = data.width;
        var crop_h = data.height;

        var fd = new FormData();

        var lastImage = imageHolder.attr('src');
        fd.append('width', params.imageWidth);
        fd.append('height', params.imageHeight);

        fd.append('crop_x', crop_x);
        fd.append('crop_y', crop_y);
        fd.append('crop_w', crop_w);
        fd.append('crop_h', crop_h);
        fd.append('image_file', file);
        saveButton.prop('disabled', true);
        //saveButton.button({loadingText: 'Сохранение...'}).button('loading');
        $.ajax({
            type: 'POST',
            url: params.url,
            data: fd,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (data) {
                imageLinkHolder.val(data.link);
                imageHolder.attr('src', data.image);
                saveButton.prop('disabled', false);
                $('#submit-button').prop('disabled', false);
                container.hide();
                //alert('OK');
            },
            error: function (data) {
                imageHolder.attr('src', lastImage);
                alert(data.responseText);
                saveButton.prop('disabled', false);
                //saveButton.button('reset')
            }
        });
    });
};
