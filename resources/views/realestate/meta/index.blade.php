@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                        <span>{{ $realEstate->name }} - Metadaten</span>
                        <span>
                            <a href="{{ route('realestate.meta.create', $realEstate) }}" class="btn btn-success btn-sm">neu</a>
                        </span>
                        </div>
                        @include('realestate.nav')
                    </div>

                    <div class="card-body">
                        <ul class="list-group-flush">
                                @forelse($realEstate->meta as $realEstateMeta)
                                <li class="list-group-item">
                                    <div class="d-flex">
                                        <div class="mr-3">
                                            <img src="{{ Storage::url($realEstateMeta->image->thumb_name) }}" class="img-thumbnail mr-3">
                                        </div>
                                        <div class="w-100 ">
                                            <h3 class="d-flex justify-content-between">
                                                {{ $realEstateMeta->name }}
                                            <div>
                                                <a href="{{ route('realestate.meta.edit', [$realEstate, $realEstateMeta]) }}" class="btn btn-success">bearbeiten</a>
                                                <form method="post" action="{{ route('realestate.meta.destroy', [$realEstate, $realEstateMeta]) }}" class="d-inline">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="btn btn-danger">löschen</button>

                                                </form>
                                            </div>
                                            </h3>
                                           <meta-sort metas="{{ $realEstateMeta->metadata }}" metaId="{{ $realEstateMeta->id }}" realestateid="{{ $realEstate->id }}"></meta-sort>
                                    </div>

                                </li>
                                @empty
                                    <h3 class="text-center">Noch keine Daten</h3>
                                    <a href="{{ route('realestate.meta.create', $realEstate) }}" class="btn btn-success">Neu</a>
                                @endforelse

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
