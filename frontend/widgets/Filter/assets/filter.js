var FilterService = function () {
    this.data = {};
    this.filterCommand = new FilterCommand();
}

FilterService.prototype.updateProperties = function (result, name) {

    for (var t in result) {
        let select = $('#filterForm select.select-' + t),
            current = select.val(),
            categories = result[t];

        // if (name && name == 'subcategory' && t == 'category') {
        //     continue;
        // }

        if (!categories.length) {
            select.prop('disabled', 'disabled');
        } else {
            select.prop('disabled', false);
        }

        select.html('').trigger('refresh');
        select.append("<option value='' class='level-0' data-translit=''>All</option>");

        for (var i in categories) {
            let item = categories[i];
            if(typeof item == 'object')
            select.append("<option value='" + item.id + "' class='level-0' data-translit='" + item.transliteration + "'>" + item.name + " (" + item.count.count + ")</option>");
        }

        if (current) {
            select.find('option[value=' + current + ']').attr('selected', 'selected');
        }

    }

    $('#filterForm select').trigger('refresh');
    $('#filter-count-result').text('( ' + result.counter + ' )');
}

FilterService.prototype.init = function () {
    let self = this;
    $('#filterForm select').change(function () {
        self.changeFilter();
    });

    $('#filterform-price-max').change(function () {
        self.changeFilter();
    });

    $('#filterform-price-min').change(function () {
        self.changeFilter();
    });
}

FilterService.prototype.changeFilter = function () {
    let self = this;
    self.filterCommand.loadData($('#filterForm').serializeArray()).then(result => self.updateProperties(result, name));
}


var FilterCommand = function () {
    this.loadData = function (data) {
        return new Promise((resolve, reject) => {
            $.get('/ajax/categories', data, function (res) {
                resolve(res);
            });

        })
    }
}


$(document).ready(function () {
    var filter = new FilterService();
    filter.init();
    console.log(categoriesJson);
    filter.updateProperties(categoriesJson);
});

