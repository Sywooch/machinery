var catalogMenu = [];
catalogMenu.id = 'catalog-menu';
catalogMenu.menu = $('#'+catalogMenu.id);
catalogMenu.collapseTimer = 0;
catalogMenu.collapseDelay = 400;
catalogMenu.collapseLast = false;
catalogMenu.init = function(){
    this.hoverInit();
}

catalogMenu.hoverInit = function(){
    var menuItem = this.menu.find('.menu-item');
    
    menuItem.hover(function(){
     
        var item = $(this);
        clearTimeout(catalogMenu.collapseTimer);
        catalogMenu.collapseTimer = setTimeout(function() { 
                            if(catalogMenu.collapseLast){
                                catalogMenu.collapseLast.removeClass('menu-collapse');
                            }
                            catalogMenu.collapseLast = item;
                            item.addClass('menu-collapse');
                            catalogMenu.collapseDelay = 200;
                        }, catalogMenu.collapseDelay);
    },
    function(){
       var item = $(this);
       clearTimeout(catalogMenu.collapseTimer);
       catalogMenu.collapseDelay = 400;
       catalogMenu.collapseTimer = setTimeout(function() {   
                            item.removeClass('menu-collapse');
                        }, catalogMenu.collapseDelay);
       
    });
    

}



$( document ).ready(function() {
   catalogMenu.init();
});
