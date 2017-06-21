var FileInputAvatarWidget = {
    init: function (id, initialPreview, initialPreviewConfig, uploadUrl) {
        $(id).fileinput({
            //  'theme': 'explorer',
            uploadUrl: uploadUrl,
            browseLabel: $(id).data('browselabel') ? $(id).data('browselabel') : 'Browse',
            uploadAsync: false,
            maxFileCount: 1,
            showRemove: false,
            showUpload: false,
            showCaption: false,
            showClose: false,
            autoReplace: true,
            initialPreviewShowDelete: true,
            overwriteInitial: true,
            initialPreviewAsData: true,
            initialPreview: initialPreview,
            initialPreviewConfig: initialPreviewConfig
        }).on("filebatchselected", function (event, files) {
            $(id).fileinput("upload");
        });
    }
};
