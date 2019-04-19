@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between"><span>Immobilie</span><span><a href="{{ route('home') }}" class="btn btn-default btn-sm">Zurück</a></span></div>

                    <div class="card-body">
                        <form method="post" action="{{ route('realestate.update', $realEstate ) }}">
                            @csrf
                            @method('PATCH')
                            <file-upload mfile="{{ json_encode( $realEstate->titleimage ) }}"></file-upload>
                            @if ($errors->has('titleimage_id'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('titleimage_id') }}</strong>
                                </span>
                            @endif
                            <div class="my-5"></div>
                            <div class="form-group">
                                <label for="name">{{ __('Titel*') }}</label>
                                <input id="name" maxlength="100" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') ?: $realEstate->name }}" required autofocus>
                                <small>max. 100 Zeichen</small>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <label for="description">Beschreibung für Kurzexpose</label>
                            <w-y-s-i-w-y-g name="description" content="{{ old('description') ?: $realEstate->description }}"></w-y-s-i-w-y-g>
                            <div class="form-group mb-0 mt-3">
                                <button type="submit" class="btn btn-primary btn-sm btn-block">
                                    {{ __('speichern') }}
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
    import FileUpload from "../../js/components/FileUpload";
    export default {
        components: {FileUpload}
    }
</script>