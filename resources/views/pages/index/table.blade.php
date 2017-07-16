<h4>
    Your {{$urls->total()}} generated urls:
</h4>
<div class="row">
    <div class="col-md-12">
        <table class="table">
            <thead>
            <tr>
                <th>Original URL</th>
                <th>Created at</th>
                <th>Short URL</th>
                <th>All Click</th>
                <th>Change</th>
            </tr>
            </thead>
            <tbody>
            @foreach($urls as $url)
                <tr>
                    <td>{{ $url->long_url }}</td>
                    <td>{{ $url->created_at }}</td>
                    <td>
                        <a href="{{ url('/') . '/' . $url->short_url }}" target="_blank">{{url('/') . '/'. $url->short_url}}</a>
                    </td>
                    <td>{{$url->count_clicks}}</td>
                    <td>
                        <a class="btn btn-default btn-edit" href="#modal-container-edit-url" role="button" class="btn" data-toggle="modal" data-id="{{$url->id}}" data-url="{{$url->short_url}}">
                            Edit
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{$urls->links()}}
    @include('pages.modal.url.edit')
</div>