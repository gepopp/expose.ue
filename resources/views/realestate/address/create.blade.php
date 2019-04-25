@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span>Neue Adresse</span><span><a href="{{ route('realestate.address.index', $realEstate) }}" class="btn btn-default btn-sm">Alle Adressen</a></span>
                    </div>
                    <div class="card-body">

                        <form method="post" action="{{ route('realestate.address.store', $realEstate) }}">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="name">{{ __('Titel*') }}</label>
                                        <input id="name" maxlength="100" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('name') }}</strong></span>
                                        @endif
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="is_public" name="is_public">
                                        <label class="form-check-label" for="is_public">
                                            öffentlich
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label for="address_line_1">{{ __('Adresszeile 1*') }}</label>
                                        <input id="address_line_1" maxlength="100" type="text" class="form-control{{ $errors->has('address_line_1') ? ' is-invalid' : '' }}" name="address_line_1" value="{{ old('address_line_1') }}" required>
                                        @if ($errors->has('address_line_1'))
                                            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('address_line_1') }}</strong></span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="address_line_2">{{ __('Adresszeile 2') }}</label>
                                        <input id="address_line_2" maxlength="100" type="text" class="form-control{{ $errors->has('address_line_2') ? ' is-invalid' : '' }}" name="address_line_2" value="{{ old('address_line_2') }}">
                                        @if ($errors->has('address_line_2'))
                                            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('address_line_2') }}</strong></span>
                                        @endif
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-4">
                                            <label for="zip">{{ __('Postleitzahl') }}</label>
                                            <input id="zip" maxlength="100" type="text" class="form-control{{ $errors->has('zip') ? ' is-invalid' : '' }}" name="zip" value="{{ old('zip') }}" required>
                                            @if ($errors->has('zip'))
                                                <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('zip') }}</strong></span>
                                            @endif
                                        </div>
                                        <div class="form-group col-8">
                                            <label for="city">{{ __('Stadt') }}</label>
                                            <input id="city" maxlength="100" type="text" class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" name="city" value="{{ old('city') }}" required>
                                            @if ($errors->has('city'))
                                                <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('city') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="country">{{ __('Staat') }}</label>
                                        <input id="country" maxlength="100" type="text" class="form-control{{ $errors->has('country') ? ' is-invalid' : '' }}" name="country" value="{{ old('country') }}">
                                        @if ($errors->has('country'))
                                            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('country') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label>Bild</label>
                                    <file-upload mfile="null" maxfiles="1" folder="addressimages"></file-upload>
                                    @if ($errors->has('file_id'))
                                        <div>
                                            <span class="text-danger"><strong>{{ $errors->first('file_id') }}</strong></span>
                                        </div>
                                    @endif
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
<script>
    import LocationMap from "../../../js/components/LocationMap";

    export default {
        components: {LocationMap}
    }
</script>