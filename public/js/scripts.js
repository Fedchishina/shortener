$( function() {
    'use strict';
    $('.btn-edit').on('click', function () {
        var $this = $(this);
        var $modalEdit = $('#modal-container-edit-url');
        $modalEdit.find( "input[name='short_url']" ).val( $this.data('url') );
        $modalEdit.find( "input[name='id']" ).val( $this.data('id') );
    });
});