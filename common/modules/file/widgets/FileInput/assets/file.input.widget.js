var FileInputWidget = {
    init: function (id, initialPreview, initialPreviewConfig, multiple, showRemove) {
        $(id).fileinput({
            'theme': 'explorer',
            showRemove: showRemove ? true : false,
            overwriteInitial: false,
            initialPreviewAsData: true,
            initialPreview: initialPreview,
            initialPreviewConfig: initialPreviewConfig
        });

        if (!showRemove) {
            $(id + 'w .kv-file-remove').remove();
        }

    }
};
