@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span>Text bearbeiten</span><span><a href="{{ route('textSnippet.index') }}" class="btn btn-default btn-sm">Zurück</a></span>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('textSnippet.update', $textSnippet) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="title">{{ __('Titel*') }}</label>
                                        <input id="title" maxlength="100" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') ?: $textSnippet->title }}" required autofocus>
                                        @if ($errors->has('title'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" value="1" id="use_as_page" name="use_as_page" {{ $textSnippet->use_as_page ? 'checked' : '' }}>
                                        <label class="form-check-label" for="use_as_page">
                                            Als Expose Seite verwenden
                                        </label>
                                    </div>
                                    <label for="text">Text</label>
                                    <w-y-s-i-w-y-g name="text" content="{{ old('text') ?: $textSnippet->text }}"></w-y-s-i-w-y-g>
                                    @if ($errors->has('text'))
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $errors->first('text') }}</strong>
                                        </span>
                                    @endif

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2 offset-10">
                                    <upload-locked-submit-button></upload-locked-submit-button>
                                </div>
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
    import UploadLockedSubmitButton from "../../js/components/UploadLockedSubmitButton";

    export default {
        components: {UploadLockedSubmitButton}
    }
</script>