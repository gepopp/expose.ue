@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span>{{ $realEstate->name }} - Metadaten</span>
                        <span>
                            <a href="{{ route('realestate.meta.create', $realEstate) }}" class="btn btn-success btn-sm">neu</a>
                        </span>
                    </div>

                    <div class="card-body">
                        <ul class="list-group-flush">
                            <li class="list-group-item">
                                @forelse($realEstate->meta as $meta)

                                @empty
                                    <h3 class="text-center">Noch keine Daten</h3>
                                    <a href="{{ route('realestate.meta.create', $realEstate) }}" class="btn btn-success">Neu</a>
                                @endforelse
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
