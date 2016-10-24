$( document ).ready(function(){taxonomy.init();});
var taxonomy = [];
taxonomy.conteiner = $('#tree');
taxonomy.button = $('form#w0 button');
taxonomy.vid = 0;

taxonomy.init = function(){
    
    this.vid = vocabularyId;
    this.pid = parentId;

    taxonomy.writeTree(tree);
    taxonomy.nesTable();
}

taxonomy.nesTable = function(){
    var that = this;
    that.conteiner.nestable({maxDepth:10,group:1 }); 
    that.conteiner.on('change', function() {
            that.button.removeAttr('disabled'); 
        });
    that.button.attr('disabled', 'disabled');
    that.button.click(function(){ 
            var data = that.conteiner.nestable('serialize');
            $.post('', {vid:that.vid, pid:that.pid, data:data}, function(){ 
                that.button.attr('disabled', 'disabled'); 
            });
            return false; 
        });
}

taxonomy.writeTree = function(tree){
    console.log(tree);
    var ol = this.treeBuild(tree);
    this.conteiner.append(ol);  
}

taxonomy.treeBuild = function(tree){
    

    
    var ol = $('<ol>').addClass('dd-list');
    for(var key in tree){
        
        var li = $('<li>');
        li.attr('data-id',tree[key].id);
        li.addClass('dd-item');
        
        var div = $('<div>');
        div.addClass('dd-handle dd3-handle');
        li.append(div);
        
        
        
        var i = $('<i>');
        i.addClass('glyphicon glyphicon-align-right pull-right');
        
        var lnk = $('<a>');
        lnk.attr('title', 'List');
        lnk.attr('href','hierarchy?TaxonomyItemsRepository[vid]='+tree[key].vid+'&TaxonomyItemsRepository[pid]='+tree[key].id);
        lnk.append(i);
        
        var div = $('<div>');
        div.addClass('dd3-content');
        div.text(tree[key].name);
        div.append(lnk);
        
        li.append(div);  
        
        if(tree[key].childrens != undefined){
            li.append(this.treeBuild(tree[key].childrens));
        }
        
        ol.append(li);
    }
    return ol;
}