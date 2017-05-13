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
