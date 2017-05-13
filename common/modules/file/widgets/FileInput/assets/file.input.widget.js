var FileInputWidget = {
    init: function (id, initialPreview, initialPreviewConfig) {
        $(id).fileinput({
            'theme': 'explorer',
            overwriteInitial: false,
            initialPreviewAsData: true,
            initialPreview: initialPreview,
            initialPreviewConfig: initialPreviewConfig
        });

    }
};
