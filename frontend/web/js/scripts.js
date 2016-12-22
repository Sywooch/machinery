$( document ).ready(function() {
    front.init();
    subCategory.init();
    user.popoverInit();
    radio.radioInit();
    multiTable.initMultiDelete();
});

var modal = [];

modal.show = function(title, content){

    var m = $('#modalShow');
    if(!m.length){
        return false;
    }
    m.find('.modal-header span').html('<h3>'+title+'</h3>');
    m.find('.modal-body').html(content);
    m.modal('show');
    
    return false;
}

var multiTable = [];
multiTable.header = $('.header-table-list');
multiTable.list = $('.table-list-item');
multiTable.url = multiTable.header.attr('data-url');
multiTable.initMultiDelete = function(){
    multiTable.header.find('#multi-delete-button').click(function(){
        var link = '';
        multiTable.list.find('.chb').each(function(){
            if($(this).val() == 1){
                link += '&id[]='+$(this).attr('data-id');
            }
        });
        location.href = multiTable.url+'?' + link;
        return false;
    });
    
    multiTable.header.find('#chb_all').change(function(){
      multiTable.list.find('.chb').val($(this).val()).checkboxX('refresh');  
      multiTable.multiDeleteAction();
    }); 
    
    multiTable.list.find('.chb').change(function(){
        var checked = true;
        multiTable.list.find('.chb').each(function(){
            checked *= $(this).val();
        })
        multiTable.header.find('#chb_all').val(checked).checkboxX('refresh');
        multiTable.multiDeleteAction();
   });
}

multiTable.multiDeleteAction = function(){
    var count = 0;
    multiTable.list.find('.chb').each(function(){
           count += $(this).val() * 1;
    })
    multiTable.header.find('#multi-text').text('Выбрано '+count+' '+multiTable.declension(count, ['продукт','продукта','продуктов']));
    
    if(count){
      multiTable.header.find('#multi-text').show();  
      multiTable.header.find('#multi-delete-button').show();
    }else{
      multiTable.header.find('#multi-text').hide();  
      multiTable.header.find('#multi-delete-button').hide();
    }
}

multiTable.declension = function (num, expressions) {
    var result;
    count = num % 100;
    if (count >= 5 && count <= 20) {
        result = expressions['2'];
    } else {
        count = count % 10;
        if (count == 1) {
            result = expressions['0'];
        } else if (count >= 2 && count <= 4) {
            result = expressions['1'];
        } else {
            result = expressions['2'];
        }
    }
    return result;
}

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
