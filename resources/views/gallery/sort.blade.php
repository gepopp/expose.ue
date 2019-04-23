@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span>{{ $realEstateGallery->name }} - beschriften und sortieren</span>
                        <span>
                            <a href="{{ route('galleries', $realEstate) }}" class="btn btn-success btn-sm">zurück</a>
                        </span>
                    </div>

                    <div class="card-body">

                        <gallery-sort images="{{ json_encode($realEstateGallery->images) }}"></gallery-sort>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection