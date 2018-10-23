function imageCropper(params) {
    var $image = params.cropperImageHolder;
    function init() {
        $($image).cropper({
            aspectRatio: 1.7,
            zoomable: false,
            checkImageOrigin: false,
            cropend: function () {
                var data = $image.cropper("getData");
                $('#cropX').val(data.x);
                $('#cropY').val(data.y);
                $('#cropWidth').val(data.width);
                $('#cropHeight').val(data.height);
            },
        });
        var data = $image.cropper("getData");
        $('#cropX').val(data.x);
        $('#cropY').val(data.y);
        $('#cropWidth').val(data.width);
        $('#cropHeight').val(data.height);
    }
    init();
};


$('#file-for-crop').on('fileloaded', function() {
    console.log($(".file-preview-image"));
    params = {
        cropperImageHolder: $($(".file-preview-image")[0])
    };
    imageCropper(params);

});
