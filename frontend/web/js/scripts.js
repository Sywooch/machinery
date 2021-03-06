$(document).ready(function () {
    $('body').on('click', '.has-stop-prepagation', function(e){
        e.stopPropagation();
    })
    try {
        $('input:radio, input:checkbox').styler();
    } catch (e) {
    }
    try {
        setTimeout(function () {
            $('select').styler({
                selectVisibleOptions: 8
            });
        }, 1);
    } catch (e) {
    }
    try {
        $('.slider-block').slick({
            fade: true,
            autoplay: true,
            dots: true,
            arrows: false,
            appendDots: '.dots-filter-slider'
        });
    } catch (e) {
    }
    try {
        $('.list-products-slider').slick({
            dots: false,
            arrows: true,
            slidesToShow: 5,
            appendArrows: $('.list-products-slider-arrows')
        })
    } catch (e) {
    }

    $('body').on('click', '.btn-open-filter', function (e) {
        e.preventDefault();
        $('.filter-drop-container').slideDown(200);
    });
    $('body').on('click', '.close-drop', function (e) {
        e.preventDefault();
        $('.filter-drop-container').slideUp(200);
    });
    $('body').on('click', '.btn-view', function (e) {
        e.preventDefault();
        var _self = $(this);
        var _view = _self.data('view');
        $('.list-offers').removeClass('_list').removeClass('_grid').addClass(_view);
        $('.btn-view').removeClass('active');
        _self.addClass('active');
        $.cookie('view', _view);
    });
    $('.btn-hover-hint').hoverIntent({
        over: function () {
            console.log(this);
            $(this).parent().addClass('open');
            $(this).find('.package-drop').fadeIn(300);
        },
        out: function () {
            console.log(this);
            $(this).parent().removeClass('open');
            $(this).find('.package-drop').fadeOut(300);
        },
        timeout: 300
    });

    $('body').append(galleryPopup);


    try {
        $('.big-images-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.slider-nav'
        }).on('afterChange', function (event, slick, currentSlide) {
            console.log( currentSlide);
            // $('.slider-nav').slick('slickGoTo', currentSlide, true);
            $('.slider-nav').find('[data-slick-index='+currentSlide+']').trigger('click');
            $('#slide-number').text(currentSlide + 1);
        });
        $('.slider-nav').slick({
            slidesToShow: 5,
            slidesToScroll: 1,
            asNavFor: '.big-images-slider',
            dots: false,
            centerMode: false,
            focusOnSelect: true,
            // initialSlide: 2,
            appendArrows: '.small-images'
        });

    } catch (e) {
    }
    try {
        initPhotoSwipeFromDOM('.gallery-swipe');
    } catch (e) {
        console.log(e);
    }

    /**
     * Заказ пакетов и опций объявления
     */

    $('body').on('change', 'input.package_radio', function (e) {
        e.preventDefault();
        checkboxOptions();
        costOrder();
    });

    /**
     * при изменении пакта или опций отправляем новый заказ
     */
    $('body').on('change', 'input.enhancement-checkbox, input.package_radio', function (e) {
        e.preventDefault();
        var data = [];
        $('input.enhancement-checkbox:checked').not('.in_pack').each(function (idx, el) {
            data.push($(el).val());
        });
        $('#advert-order_options').val(JSON.stringify(data))
        costOrder();
    });

    /**
     * Переопределяет опции
     */
    var checkboxOptions = (function checkboxOptions() {
        $('input.enhancement-checkbox').each(function (idx, el) {
            var checkedPack = $('input.package_radio:checked');
            if (!checkedPack.length) return;
            var pack_id = checkedPack.val();
            var id = $(el).val();
            var pack = packs[pack_id].customOptions;
            if (in_array(id, pack)) {
                $(el).prop({"checked": true, "disabled": true})
                    .addClass('in_pack')
                    .attr('title', $(el).data('inpack'))
                    .trigger('refresh');
            } else {
                $(el).prop({"checked": false, "disabled": false})
                    .removeClass('in_pack')
                    .attr('title', false)
                    .trigger('refresh');
            }
        });
        return checkboxOptions;
    }());

    /**
     * Пересчитывает сумму заказа
     */
    var costOrder = (function costOrder() {
        var cost = 0;
        // var costBox = $('#cost-options-advert');
        var cost_pack = +$('input.package_radio:checked').not('.in_order_active').data('cost') || 0;
        // var cost_options = 0;
        $('input.enhancement-checkbox:checked').not('.in_pack').each(function (idx, el) {
            var _cost = +$(el).data('cost');
            cost += _cost;
        });
        cost += cost_pack;
        $('#cost-options-advert').text(cost);
        return costOrder;
    }());
    /**
     * Каскадные селекты в фильтре
     */
    // $('body').on('change','select.select-cascade', function(e){
    //     e.preventDefault();
    //     var url = $(this).data('url');
    //     var target = $(''+$(this).data('target'));
    //     var data = {
    //         id: this.value
    //         // _csrf: yii.getCsrfToken()
    //     };
    //     $.get(url, data, function(d){
    //         $(target).html('').trigger('refresh');
    //         // if(d.length){
    //             for(item in d){
    //                 console.log(d[item]);
    //                 $(target).append(d[item]);
    //             }
    //         // }
    //         $(target).trigger('refresh');
    //     }, 'json');
    //
    // });



}); // end ready

