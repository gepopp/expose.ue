@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span>Gallery bearbeiten</span><span><a href="{{ route('galleries', $realEstate) }}" class="btn btn-default btn-sm">Zurück</a></span>
                    </div>

                    <div class="card-body">
                        <form method="post" action="{{ route('updategallery', [$realEstate, $realEstateGallery] ) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="name">{{ __('Titel*') }}</label>
                                        <input id="name" maxlength="100" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') ?: $realEstateGallery->name }}" required autofocus>
                                        <small>max. 100 Zeichen</small>
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="is_public" name="is_public" {{ $realEstateGallery->is_public ? 'checked' : '' }} >
                                        <label class="form-check-label" for="is_public">
                                            Öffentliche Gallerie
                                            <small>( Bilder werden im Expose verwendet )</small>
                                        </label>
                                        <label for="description">Beschreibung für diese Gallerie</label>
                                    </div>
                                    <w-y-s-i-w-y-g name="description" content="{{ old('description') ?: $realEstateGallery->description }}"></w-y-s-i-w-y-g>
                                    @if ($errors->has('description'))
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif

                                </div>
                                <div class="col-8">
                                    <label>Bild upload
                                        <small>( max. 10 pro Galerie)</small>
                                    </label>
                                    <file-upload
                                            mfile="{{ json_encode($realEstateGallery->images ) }}"
                                            uploadable="RealEstateGallery"
                                            uploadableid="{{ $realEstateGallery->id }}"
                                            maxfiles="10" folder="galleryimages"
                                    ></file-upload>
                                    @if ($errors->has('file_id'))
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $errors->first('file_id') }}</strong>
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
    import MultipleFileUpload from "../../js/components/MultipleFileUpload";

    export default {
        components: {MultipleFileUpload}
    }
</script>
<script>
    import UploadLockedSubmitButton from "../../js/components/UploadLockedSubmitButton";

    export default {
        components: {UploadLockedSubmitButton}
    }
</script>
<script>
    import FileUpload from "../../js/components/FileUpload";

    export default {
        components: {FileUpload}
    }
</script>