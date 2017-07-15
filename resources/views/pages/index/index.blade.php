@extends('layouts.app')
@section('content')
    <div class="container">
        <h1 class="index-title">
            Shortener URL Generator
        </h1>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form class="index-form" role="form">
                        <div class="form-group">
                            <label for="long_url">
                                Enter your url
                            </label>
                            <input type="long_url" class="form-control" id="long_url">
                        </div>
                        <div class="form-group form-group--disabled">
                            <label for="short_url">
                                Generated url (you can change it):
                            </label>
                            <input type="long_url" class="form-control" id="short_url">
                        </div>
                        <button type="submit" class="btn btn-default">
                            Generate short url
                        </button>
                    </form>
                </div>
            </div>
            @if (\Illuminate\Support\Facades\Auth::check())
                @include('pages.index.table')
            @endif
        </div>
    </div>
@endsection