

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span>{{ $realEstate->name }} - Lagen</span>
                        <span>
                            <a href="{{ route('realestate.location.create', $realEstate) }}" class="btn btn-success btn-sm">neu</a>
                        </span>
                    </div>

                    <div class="card-body">
                        <ul class="list-group-flush">
                            @forelse($realEstate->location as $realEstateLocation)
                                <li class="list-group-item">
                                    <div class="d-flex">
                                        <div class="mr-3">
                                            <static-map latlng="{{$realEstateLocation->lat_lng}}" type="{{ $realEstateLocation->type }}" zoom="{{ $realEstateLocation->zoom }}" marker="{{ $realEstateLocation->marker }}" radius="{{ $realEstateLocation->radius }}"></static-map>
                                        </div>
                                        <div class="w-100 ">
                                            <h3 class="d-flex justify-content-between">
                                                {{ $realEstateLocation->name }}
                                                <div>
                                                    <a href="{{ route('realestate.location.edit', [$realEstate, $realEstateLocation]) }}" class="btn btn-success">bearbeiten</a>
                                                    <form method="post" action="{{ route('realestate.location.destroy', [$realEstate, $realEstateLocation]) }}" class="d-inline">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button class="btn btn-danger">löschen</button>
                                                    </form>
                                                </div>
                                            </h3>
                                            {!!  $realEstateLocation->description !!}
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <h3 class="text-center">Noch keine Lage.</h3>
                                <a href="{{ route('realestate.location.create', $realEstate) }}" class="btn btn-success">Neu</a>
                            @endforelse

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    import StaticMap from "../../../js/components/StaticMap";
    export default {
        components: {StaticMap}
    }
</script>