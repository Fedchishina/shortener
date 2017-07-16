<div class="modal fade" id="modal-container-edit-url" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/url/edit" method="POST" role="form">
            {{csrf_field()}}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        Editing short URL
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="short_url">
                            short URL
                        </label>
                        <input type="text" class="form-control" id="short_url" name="short_url"/>
                    </div>
                    <div class="form-group">
                        <input type="hidden" value="" name="id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>