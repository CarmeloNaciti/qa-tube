$(function() {
    $('#search').on('click', function() {
        var query = encodeURI($('#search_text').val().trim());

        if (query.length > 0) {
            var href = "http://qa-tube/object/search/" + encodeURI($('#search_text').val());

            window.location.replace(href);
            window.location.href = href;
        }

        return false;
    });
});

$(function() {
    $('.panel-heading').on('click', function(event) {
        var $element = $(event.target),
            mediaId = $element.data('id');

        window.location.href = "http://qa-tube/object/view/" + mediaId;
    });
});