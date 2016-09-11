$( document ).ready(function() {
    front.init();
    subCategory.init();
});

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
        sections: 'h2',
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
    });
}
