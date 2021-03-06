@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span>Neue Immobilie</span><span><a href="{{ route('realestate.text.index', $realEstate) }}" class="btn btn-default btn-sm">Alle Texte</a></span>
                    </div>
                    <div class="card-body">

                        <form method="post" action="{{ route('realestate.text.store', $realEstate) }}">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <label>Titelbild</label>
                                    <upload-crop></upload-crop>
                                    @if ($errors->has('file_id'))
                                        <div>
                                            <span class="text-danger"><strong>{{ $errors->first('file_id') }}</strong></span>
                                        </div>
                                    @endif
                                    <hr>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">{{ __('Titel*') }}</label>
                                        <input id="name" maxlength="100" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                                        <small>max. 100 Zeichen</small>
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('name') }}</strong></span>
                                        @endif
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" value="1" id="is_public" name="is_public">
                                        <label class="form-check-label" for="is_public">
                                            öffentlich
                                        </label>
                                    </div>
                                    <label for="description">Kurzbeschreibung</label>
                                    <w-y-s-i-w-y-g name="description" content="{{ old('description') }}"></w-y-s-i-w-y-g>
                                    @if ($errors->has('description'))
                                        <div>
                                            <span class="text-danger"><strong>{{ $errors->first('description') }}</strong></span>
                                        </div>
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
