@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span>Lage bearbeiten</span><span><a href="{{ route('realestate.location.index', $realEstate) }}" class="btn btn-default btn-sm">Alle Lagen</a></span>
                    </div>
                    <div class="card-body">

                        <form method="post" action="{{ route('realestate.location.update', [$realEstate, $realEstateLocation]) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="name">{{ __('Titel*') }}</label>
                                        <input id="name" maxlength="100" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') ?: $realEstateLocation->name }}" required autofocus>
                                        <small>max. 100 Zeichen</small>
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('name') }}</strong></span>
                                        @endif
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" value="1" id="is_public" name="is_public" {{ $realEstateLocation->is_public ? 'checked' : ''  }}>
                                        <label class="form-check-label" for="is_public">
                                            öffentlich
                                        </label>
                                    </div>
                                    <label for="description">Kurzbeschreibung</label>
                                    <w-y-s-i-w-y-g name="description" content="{{ old('description') ?: $realEstateLocation->description }}"></w-y-s-i-w-y-g>
                                    @if ($errors->has('description'))
                                        <div>
                                            <span class="text-danger"><strong>{{ $errors->first('description') }}</strong></span>
                                        </div>
                                    @endif

                                </div>
                                <div class="col-6">

                                    <location-map
                                            maptype="{{ $realEstateLocation->type }}"
                                            :old_zoom="{{ $realEstateLocation->zoom }}"
                                            location="{{ $realEstateLocation->lat_lng }}"
                                            radius="{{ $realEstateLocation->radius }}"
                                            marker="{{ $realEstateLocation->marker }}"
                                            marker_pos="{{ $realEstateLocation->marker_location }}"
                                    ></location-map>


                                    @if ($errors->has('map'))
                                        <div>
                                            <span class="text-danger"><strong>{{ $errors->first('map') }}</strong></span>
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