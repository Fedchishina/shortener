@extends('layouts.app')
@section('content')
    <div class="container">

        @if ($errors->has('unknown_url'))
            <span class="help-block">
                <strong>{{$errors->first('unknown_url')}}</strong>
            </span>
        @endif

        <h1 class="index-title">
            Shortener URL Generator
        </h1>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('generate') }}" class="index-form" role="form">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="long_url">
                                Enter your url:
                            </label>
                            <input type="text" class="form-control" id="long_url" name="long_url" value="{{old('long_url')}}">
                            @if ($errors->has('long_url'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('long_url') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="short_url">
                                Enter short url (if you want):
                            </label>
                            <input type="text" class="form-control" id="short_url" name="short_url" value="{{old('short_url')}}">
                            @if ($errors->has('short_url'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('short_url') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group form-group--disabled">
                            <label for="short_url">
                                Generated url:
                            </label>
                            <input type="text" class="form-control" id="short_url" name="short_url" disabled>
                        </div>
                        <button type="submit" class="btn btn-default">
                            Generate short url
                        </button>
                    </form>
                </div>
            </div>

            @if(\Session::has('shortUrlLink'))
                <div class="row">
                    <label for="generate_url">
                        Generated url:
                    </label>
                    <a id="generate_url" href="{{\Session::get('shortUrlLink')}}" target="_blank">
                        {{\Session::get('shortUrlLink')}}
                    </a>
                </div>
            @endif

            @if (\Auth::check())
                <div class="table-content">
                    @include('pages.index.table')
                </div>
                @include('pages.modal.url.edit')
            @endif
        </div>
    </div>
@endsection