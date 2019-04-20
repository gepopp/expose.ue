@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span>Gallery erstellen</span><span><a href="{{ route('home') }}" class="btn btn-default btn-sm">Zurück</a></span>
                    </div>

                    <div class="card-body">
                        <form method="post" action="{{ route('storegallery', $realEstate) }}">
                            @csrf
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="is_public" name="is_public">
                                <label class="form-check-label" for="is_public">
                                    Öffentliche Gallerie
                                    <small>( Bilder werden im Expose verwendet )</small>
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="name">{{ __('Titel*') }}</label>
                                <input id="name" maxlength="100" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                                <small>max. 100 Zeichen</small>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <label for="description">Beschreibung für diese Gallerie</label>
                            <w-y-s-i-w-y-g name="description" content="{{ old('description') }}"></w-y-s-i-w-y-g>
                            <div class="mt-3"></div>
                            <label>Bild upload
                                <small>( max. 10 pro Galerie)</small>
                            </label>
                            <multiple-file-upload></multiple-file-upload>
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
<script>
    import MultipleFileUpload from "../../js/components/MultipleFileUpload";

    export default {
        components: {MultipleFileUpload}
    }
</script>