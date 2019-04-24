@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span>{{ $realEstate->name }} Daten</span><span><a href="{{ route('home') }}" class="btn btn-default btn-sm">Zurück</a></span>
                    </div>
                    <div class="card-body">
                        <meta-form metas="{{ json_encode( $metas ) }}"></meta-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
