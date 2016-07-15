var filter = [];
filter.id = 'filter';
filter.element = 'filter-item';
filter.filter = $('#'+filter.id);

filter.init = function(){
    filter.filter.find('.' + filter.element).each(function(){
       var url = $(this).attr('data-url');  
       var text = $(this).text();
       var a = $('<a>');
       a.text(text)
       a.attr('href', url);
       $(this).html(a);
   }); 
}

$( document ).ready(function() {
   filter.init();
});
