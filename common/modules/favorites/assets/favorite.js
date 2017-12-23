var Favorite = {

    init: function () {
        this.initButton();
        this.initCategoryButton();
    },

    initButton: function () {

        $('.favorite-button').unbind().click(function () {
            Favorite.send($(this));
            return false;
        });

    },

    initCategoryButton: function () {

        $('.favorite-category a').click(function () {
            var favoriteId = $(this).attr('data-id');
            var categoryId = $(this).attr('data-category');
            Favorite.touchCategory(favoriteId, categoryId);
            return false;
        });

    },

    touchCategory: function (favoriteId, categoryId) {
        $.post('/favorites/default/touch-category', {favoriteId: favoriteId, categoryId: categoryId}, function (data) {
            if (data.status == 'success') {
                if (data.type == 'remove') {
                    $('#favorite-' + favoriteId + '-category-' + categoryId).removeClass('active');
                } else {
                    $('#favorite-' + favoriteId + '-category-' + categoryId).addClass('active');
                }
            }
        }, 'json');
    },

    send: function (e) {
        $.post('/favorites/default/touch', {
            entityId: e.attr('data-id'),
            entity: e.attr('data-entity')
        }, function (data) {
            if (data.status == 'success') {
                if (data.type == 'add') {
                    $('#favorite-entity-' + data.entityId).addClass('active');
                } else {
                    $('#favorite-entity-' + data.entityId).removeClass('active');
                }

                $('#favorites-block-widget .items-count').text(data.count);

                if (data.count) {
                    $('#favorites-block-widget').addClass('active');
                } else {
                    $('#favorites-block-widget').removeClass('active');
                }

            }

            if (data.status == 'error') {
                if (data.type == 'auth') {
                    $('#favorites-auth-modal').modal('show');
                }
            }

        }, 'json')
    }
};

Favorite.init();

$(document).ready(function(){
    $('body').on('click', '.btn-favorite', function(e){
        e.preventDefault();
        var a = $(this);
        var text = a.text();
        var href = a.attr('href');
        var dataHref = a.data('href');
        var dataText = a.data('text');
        var model = a.data('model');
        var id = a.data('id');
        var btn = $('a[data-model='+model+'][data-id='+id+']');
        // console.log(a.data);
        $.post(href, {entityId: id, entity: model}, function(d){
            if(a.data('action') == 'add'){
                btn.data('action', 'remove');
                btn.removeClass('add-favorite').addClass('remove-favorite');
            } else {
                btn.data('action', 'add');
                btn.removeClass('remove-favorite').addClass('add-favorite');
            }
            btn.attr('href', dataHref)
                .data('href', href)
                .data('text', text)
                .find('span')
                .text(dataText);
        }, 'json');



    })
});