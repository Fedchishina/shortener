$( function() {
    'use strict';
    var $editForm = $('.edit-form');
    var $errBlock = $editForm.find('.error-list');

    $('.btn-edit').on('click', function () {
        $errBlock.html('');
        var $this = $(this);
        var $modalEdit = $('#modal-container-edit-url');
        $modalEdit.find( "input[name='short_url']" ).val( $this.data('url') );
        $modalEdit.find( "input[name='id']" ).val( $this.data('id') );
    });

    $('.edit-form').on('submit', function (event) {
        event.preventDefault();
        $errBlock.html('');

        $.ajax({
            url: $editForm.attr('action'),
            method: $editForm.attr('method'),
            data: $editForm.serialize(),
            dataType: 'html'
        }).done(function (data) {
            $(".edit-form .btn-close").trigger("click");
            $('.table-content').html(data);
        }).fail(function (err) {
            if (err.status == 422) {
                var errorList = '<ul>';
                var errors = JSON.parse(err.responseText);

                for(var prop in errors) {
                    if(!!errors[prop]) {
                        errorList += '<li><strong>' + errors[prop] + '</strong></li>';
                    }
                }
                errorList += '</ul>';
                $errBlock.html(errorList);
            };

        })
    })
});