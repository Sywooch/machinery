var filter = [];
filter.id = 'filter';
filter.element = 'filter-item';
filter.filter = $('#'+filter.id);

filter.init = function(){
    this.init();
}
filter.link = function(){
   var params = window.location.pathname.split('/').filter(function(e){return e});
   var link = params.splice(0, 2).join('/');

   filter.filter.find('.' + filter.element).each(function(){
       var params = $(this).attr('data-params');
       var text = $(this).text();
       var a = $('<a>');
       a.text(text)
       a.attr('href', '/' + link + '/' + params);
       $(this).html(a);
   }); 
}
filter.init = function(){
    this.link();
}

$( document ).ready(function() {
   filter.init();
});
