$('#story-search').selectize({
    valueField: 'id',
    labelField: 'title',
    searchField: ['title'],
    create: true,
    maxItems: 1,
    maxOptions: 10,
    render: {
        option: function(item, escape) {
            return '<div>' +
                '<span class="title">' +
                '<span class="name">' + escape(item.title) + '</span>' +
                '<span style="float: right;" class="name">' + escape(item.view) + '</span>' +
                '</span>' +
                '</div>';
        }
    },
    load: function(query, callback) {
        if (!query.length) return callback();
        $.ajax({
            url: '/search?type=stories&keyword=' + encodeURIComponent(query),
            type: 'GET',
            error: function() {
                callback();
            },
            success: function(res) {
                callback(res);
            }
        });
    },
});


$(document).on('click', '#search-story', function () {
    var val = $('#story-search').val();
    window.location.replace('?tim-kiem=' + val);
});