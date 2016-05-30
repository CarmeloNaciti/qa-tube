$(function() {
    $('#search').on('click', function() {
        var $searchText = $('#search_text'),
            query = encodeURI($searchText.val().trim());

        if (query.length > 0) {
            var href = Routing.generate('_search_object', {'searchTerm' : encodeURI($searchText.val())});

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

        if (parseInt(mediaId) >= 0) {
            window.location.href = Routing.generate('_view_object', {'id' : mediaId});
        }
    });
});

$(function() {
   $('.btn-team').on('click', function () {
       var $this = $(this);

       $this.find('.glyphicon-ok').toggleClass('hidden');
       $this.find('.glyphicon-remove').toggleClass('hidden');
       $this.toggleClass('btn-info');
       $this.toggleClass('btn-warning');

       $('.' + _.snakeCase($this.find('#text').text())).toggleClass('hidden');
   })
});

$(function() {
    $('#delete_object').on('click', function (event) {

        event.preventDefault();

        var id = $(this).data('id'),
            url = Routing.generate('_delete_object', {'id' : id});

        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            closeOnConfirm: false,
            animation: false
        }).then(function(isConfirm) {

            if(isConfirm) {
                $.post(url, function (data) {
                    if (data['deleted']) {
                        swal({
                            title: 'Deleted!',
                            text: 'Hope this does not come as a surprise.',
                            type: 'success',
                            allowOutsideClick: false,
                            animation: false
                        }).then(function (redirect) {
                            if (redirect) {
                                url = Routing.generate('_homepage');
                                window.location.href = url;
                            }
                        })
                    } else {
                        swal({
                            title: 'An error has occurred',
                            text: 'This file has not been deleted. Please re-try',
                            type: 'error',
                            allowOutsideClick: false,
                            animation: false
                        })
                    }
                });
            }
        })
    });
});