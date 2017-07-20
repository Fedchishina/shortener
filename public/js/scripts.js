$( function() {
    'use strict';

    //founding edit short url form
    var $editForm = $('.edit-form');
    var $errBlock = $editForm.find('.error-list');

    // click on button "edit" in table urls of user
    $('.btn-edit').on('click', function () {
        $errBlock.html('');
        var $this = $(this);
        var $modalEdit = $('#modal-container-edit-url');
        //filling the form with url parameters
        $modalEdit.find( "input[name='short_url']" ).val( $this.data('url') );
        $modalEdit.find( "input[name='id']" ).val( $this.data('id') );
    });

    //click on button "Save" on edit short url form
    $('.edit-form').on('submit', function (event) {
        event.preventDefault();
        $errBlock.html('');

        $.ajax({
            url: $editForm.attr('action'),
            method: $editForm.attr('method'),
            data: $editForm.serialize(),
            dataType: 'html'
        }).done(function (data) {
            //close modal form
            $(".edit-form .btn-close").trigger("click");
            //update content of table
            $('.table-content').html(data);
        }).fail(function (err) {
            //validation errors
            if (err.status == 422) {
                var errorList = '<ul>';
                var errors = JSON.parse(err.responseText);
                //getting list of errors
                for(var prop in errors) {
                    if(!!errors[prop]) {
                        errorList += '<li><strong>' + errors[prop] + '</strong></li>';
                    }
                }
                errorList += '</ul>';
                //viewing list of errors on edit short url form
                $errBlock.html(errorList);
            };

        })
    })
});