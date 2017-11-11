
/*var FilterForm = {

    init: function () {
        this.initOrders();
        this.reset();
        this.initSubmit();
    },
    reset: function(){

    },

    initSubmit: function(){

        $('#filter-form').submit(function (e) {
            var params = $(this).serializeArray().filter(function (value) {
                return value.value != '' && value.value != 0;
            });
            location.href = decodeURI(location.pathname + '?' + $.param(params))

            return false;
        });

        $('#uk-dropdown-filter').on('hide.uk.dropdown', function () {
            var params = $('#filter-form').serializeArray().filter(function (value) {
                return value.value != '' && value.value != 0;
            });
            location.href = decodeURI(location.pathname + '?' + $.param(params))

            return false;
        });

    },

    initOrders: function () {

        $('#filter-form .order a').each(function () {
            var attr = $(this).attr('data-attr');
            var current = $('#filterform-sort').val();

            if (current.charAt(0) == '-' && attr == current.slice(1)) {
                $(this).addClass('_desc');
            } else if (current == attr) {
                $(this).addClass('_asc');
            }
        });


        $('#filter-form .order a').click(function () {
            $('#filter-form .order a').removeClass('_asc').removeClass('_desc');

            var attr = $(this).attr('data-attr');
            var current = $('#filterform-sort').val();

            if (current == attr) {
                if (attr.charAt(0) != '-') {
                    attr = '-' + attr;
                    $(this).addClass('_desc');
                }
            } else {
                $(this).addClass('_asc');
            }
            $('#filterform-sort').val(attr);

            return false;
        });
    }
}
*/

$(document).ready(function () {
    // FilterForm.init();
    console.log('filter');
    $('body').on('change','#obj-category', function(e){
        e.preventDefault();
        var url = '/ajax/categories';
        var data = {id: this.value};
        $.get(url, data, function(d){
            console.log(d);
            return false;
        }, 'json');
        return false;
    });
});

