@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between"><span>Immobilie</span><span><a href="{{ route('home') }}" class="btn btn-default btn-sm">Zurück</a></span></div>

                    <div class="card-body">
                        <form method="post" action="{{ route('realestate.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="name">{{ __('Titel*') }}</label>
                                <input id="name" maxlength="50" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                                <small>max. 50 Zeichen</small>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <w-y-s-i-w-y-g name="description" content="{{ old('name') }}"></w-y-s-i-w-y-g>
                            <div class="form-group mb-0 mt-3">
                                <button type="submit" class="btn btn-primary btn-sm btn-block">
                                    {{ __('update') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    import WYSIWYG from "../../js/components/WYSIWYG";
    export default {
        components: {WYSIWYG}
    }
</script>