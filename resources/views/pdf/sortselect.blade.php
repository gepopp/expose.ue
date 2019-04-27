@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span>PDF erzeugen - {{ $realEstate->name }}</span>
                        <span><a href="{{ route('realestate.edit', $realEstate) }}" class="btn btn-success">bearbeiten</a></span>
                    </div>

                    <div class="card-body">

                        <pdf-creator realestate="{{ json_encode($realEstate) }}" csrf-token="{{ csrf_token() }}"></pdf-creator>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
