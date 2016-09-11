var promo = [];
promo.add = function(code,id,model){
    if(!code.val()){
        return false;
    }
    $.get('/admin/product/promo-codes/add-ajax', {code: code.val(), id:id, model:model}, function(data){
        console.log(data);
        if(data.status == 'success'){
           location.reload(); 
        }
        
    });
}