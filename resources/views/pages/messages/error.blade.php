@if ($errors->has('foreign_url'))
    <span class="help-block">
        <strong>{{$errors->first('foreign_url')}}</strong>
    </span>
@endif