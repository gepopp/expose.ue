

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span>{{ $realEstate->name }} - Adressen</span>
                        <span>
                            <a href="{{ route('realestate.address.create', $realEstate) }}" class="btn btn-success btn-sm">neu</a>
                        </span>
                    </div>

                    <div class="card-body">
                        <ul class="list-group-flush">
                            @forelse($realEstate->address as $realEstateAddress)
                                <li class="list-group-item">
                                    <div class="d-flex">
                                        <div class="mr-3">
                                        </div>
                                        <div class="w-100 ">
                                            <h3 class="d-flex justify-content-between">
                                                {{ $realEstateAddress->name }}
                                                <div>
                                                    <a href="{{ route('realestate.location.edit', [$realEstate, $realEstateAddress]) }}" class="btn btn-success">bearbeiten</a>
                                                    <form method="post" action="{{ route('realestate.location.destroy', [$realEstate, $realEstateAddress]) }}" class="d-inline">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button class="btn btn-danger">löschen</button>
                                                    </form>
                                                </div>
                                            </h3>
                                            {!!  $realEstateAddress->description !!}
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <h3 class="text-center">Noch keine Lage.</h3>
                                <a href="{{ route('realestate.address.create', $realEstate) }}" class="btn btn-success">Neu</a>
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