@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span>Gallery erstellen</span><span><a href="{{ route('galleries', $realEstate) }}" class="btn btn-default btn-sm">Zurück</a></span>
                    </div>
                    <form method="post" action="{{ route('storegallery', $realEstate) }}">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">

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
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="is_public" name="is_public">
                                        <label class="form-check-label" for="is_public">
                                            Öffentliche Gallerie
                                            <small>( Bilder werden im Expose verwendet )</small>
                                        </label>
                                    </div>
                                    <label for="description">Beschreibung für diese Gallerie</label>
                                    <w-y-s-i-w-y-g name="description" content="{{ old('description') }}"></w-y-s-i-w-y-g>
                                    @if ($errors->has('description'))
                                        <div>
                                            <span class="text-danger"><strong>{{ $errors->first('description') }}</strong></span>
                                        </div>
                                    @endif
                                    <upload-locked-submit-button></upload-locked-submit-button>
                                </div>
                                <div class="col-8">
                                    <label>Bild upload
                                        <small>( max. 10 pro Galerie)</small>
                                    </label>
                                    <file-upload mfile="null" maxFiles="10" folder="galleryimages"></file-upload>
                                    @if ($errors->has('file_id'))
                                        <div>
                                            <span class="text-danger"><strong>{{ $errors->first('file_id') }}</strong></span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
