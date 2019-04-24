@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span>{{ $realEstate->name }} - Text bearbeiten</span><span><a href="{{ route('realestate.text.index', $realEstate) }}" class="btn btn-default btn-sm">Zurück</a></span>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('realestate.text.update', [$realEstate, $realEstateText] ) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="name">{{ __('Titel*') }}</label>
                                        <input id="name" maxlength="100" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') ?: $realEstateText->name }}" required autofocus>
                                        <small>max. 100 Zeichen</small>
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <label for="description">Text</label>
                                    <w-y-s-i-w-y-g name="description" content="{{ old('description') ?: $realEstateText->description }}"></w-y-s-i-w-y-g>
                                    @if ($errors->has('description'))
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif

                                </div>
                                <div class="col-6">
                                    <label>Titelbild</label>
                                    <file-upload
                                            mfile="{{ json_encode( [$realEstateText->image] ) }}"
                                            uploadable="RealEstate" uploadableid="{{ $realEstateText->id }}"
                                            maxfiles="1"
                                            folder="textimages"
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
    import UploadLockedSubmitButton from "../../js/components/UploadLockedSubmitButton";

    export default {
        components: {UploadLockedSubmitButton}
    }
</script>