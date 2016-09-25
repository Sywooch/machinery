$( document ).ready(function() {
    front.init();
    subCategory.init();
    user.popoverInit();
    radio.radioInit();
});

var radio = [];

radio.radioInit = function(){
    $('.styled-radio input').change(function(){
        $('.styled-radio .input').removeClass('checked');
        $(this).next().addClass('checked');
    });
}

var user = [];
user.popoverInit = function(){
    
    $('#popover-overlay').click(function(){
        $(this).hide();
        $(".popover-toggle").popover('hide');
    });

    $(".popover-toggle").popover({
        html : true,
         trigger: 'manual',
        content: function() {
          return $("#popover-login-content").html();
        }
    }).on('show.bs.popover', function () {
        $('#popover-overlay').show();
    }).click(function(e) {
        $(this).popover('toggle');
    });
}
var front = [];
front.init = function(){
    $('#front-tabs-1 a').click(function(){
        $(this).parent().find('a').removeClass('active');
        $(this).addClass('active');
        $('.tab-catalog-category').removeClass('active');
       
        $('#'+$(this).attr('data-tab')).addClass('active');
    });
}
var subCategory = [];
subCategory.init = function(){
    $('.sub-menu__items').scrollNav({
        sections: 'h2 a',
        subSections: false,
        sectionElem: 'section',
        showHeadline: true,
        headlineText: '',
        showTopLink: false,
        topLinkText: 'Top',
        fixedMargin: 40,
        scrollOffset: 40,
        animated: true,
        speed: 500,
        insertTarget: $('#sub-menu'),
        insertLocation: 'appendTo',
        arrowKeys: false,
        scrollToHash: true,
        onRender: function(){
            $('.scroll-nav__link').unbind().click(function(){
                var id = $(this).attr('href');
                location.href = $(id + ' a').attr('href');
                return false;
            });
        }
    });
}
