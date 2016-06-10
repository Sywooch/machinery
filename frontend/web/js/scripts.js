$( document ).ready(function() {
    subCategory.init();
    
});


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
