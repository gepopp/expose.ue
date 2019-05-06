@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <span>Immobilie bearbeiten</span><span><a href="{{ route('home') }}" class="btn btn-default btn-sm">Alle Immobilien</a></span>
                        </div>
                        <div>
                            @include('realestate.nav')
                        </div>
                    </div>
                    <div class="card-body">

                        <form method="post" action="{{ route('realestate.update', $realEstate) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-12">
                                    <label>Titelbild</label>
                                    <upload-crop :ratio="2.2" existingimage="{{ $realEstate->titleimage->blob() }}"></upload-crop>
                                    @if ($errors->has('file_id'))
                                        <div>
                                            <span class="text-danger"><strong>{{ $errors->first('file_id') }}</strong></span>
                                        </div>
                                    @endif
                                    <hr>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="name">{{ __('Titel*') }}</label>
                                        <input id="name" maxlength="100" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') ?: $realEstate->name }}" required autofocus>
                                        <small>max. 100 Zeichen</small>
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('name') }}</strong></span>
                                        @endif
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-8">
                                            <label for="street">{{ __('Straße') }}</label>
                                            <input id="street" maxlength="100" type="text" class="form-control{{ $errors->has('street') ? ' is-invalid' : '' }}" name="street" value="{{ old('street') ?: $realEstate->street }}">
                                            @if ($errors->has('street'))
                                                <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('street') }}</strong></span>
                                            @endif
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="number">{{ __('Hausnummer') }}</label>
                                            <input id="number" maxlength="100" type="text" class="form-control{{ $errors->has('number') ? ' is-invalid' : '' }}" name="number" value="{{ old('number') ?: $realEstate->number }}">
                                            @if ($errors->has('number'))
                                                <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('number') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-2">
                                            <label for="country">Land</label>
                                            <select class="form-control" id="country" name="country">
                                                <option value="DE" {{ $realEstate->country == 'DE' ? 'selected' : '' }}>DE</option>
                                                <option value="AT" {{ $realEstate->country == 'AT' ? 'selected' : '' }}>AT</option>
                                            </select>
                                            @if ($errors->has('country'))
                                                <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('country') }}</strong></span>
                                            @endif
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="zip">{{ __('Postleitzahl') }}</label>
                                            <input id="zip" maxlength="100" type="text" class="form-control{{ $errors->has('zip') ? ' is-invalid' : '' }}" name="zip" value="{{ old('zip') ?: $realEstate->zip }}">
                                            @if ($errors->has('zip'))
                                                <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('zip') }}</strong></span>
                                            @endif
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="city">{{ __('Stadt') }}</label>
                                            <input id="city" maxlength="100" type="text" class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" name="city" value="{{ old('city') ?: $realEstate->city }}">
                                            @if ($errors->has('city'))
                                                <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('city') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>

                                    <p>Anzeige:</p>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="show_address" id="inlineRadio1" value="0" {{ $realEstate->show == 0 ? 'checked' : '' }} >
                                        <label class="form-check-label" for="inlineRadio1">nicht Anzeigen</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="show_address" id="inlineRadio2" value="1" {{ $realEstate->show == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inlineRadio2">Nur Land und Stadt</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="show_address" id="inlineRadio3" value="2" {{ $realEstate->show == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inlineRadio3">Mit Straße</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="show_address" id="inlineRadio4" value="3" {{ $realEstate->show == 3 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inlineRadio4">Ganze Adresse</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="description">Kurzbeschreibung</label>
                                    <w-y-s-i-w-y-g name="description" content="{{ old('description') ?: $realEstate->description }}"></w-y-s-i-w-y-g>
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
