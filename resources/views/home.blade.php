@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span>Objekte</span>
                        <span>
                            <a href="{{ route('realestate.create') }}" class="btn btn-success btn-sm">neu</a>
                        </span>
                    </div>

                    <div class="card-body">
                        @forelse($realEstates as $realEstate)
                        @empty
                            <h3 class="text-center">Noch keine Objekte</h3>
                            <a href="{{ route('realestate.create') }}" class="btn btn-success">Neu</a>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
