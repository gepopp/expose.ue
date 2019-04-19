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
                        <ul class="list-group-flush">
                            @forelse($realEstates as $realEstate)

                                <li class="list-group-item">

                                    <div class="d-flex">
                                        <div>
                                            <img src="{{  Storage::url($realEstate->titleimage->thumb_name ) }}" class="img-thumbnail mr-5" width="80">
                                        </div>
                                        <div>
                                            <p><strong>{{ $realEstate->name }}</strong></p>
                                            <div class="d-flex">
                                                <div>
                                                    <a href="{{ route('realestate.edit', $realEstate ) }}" class="btn btn-default btn-sm">bearbeiten</a>
                                                </div>
                                                <div class="ml-3">
                                                    <form method="post" action="{{ route('realestate.destroy', $realEstate) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-default btn-sm d-inline">löschen</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <h3 class="text-center">Noch keine Objekte</h3>
                                <a href="{{ route('realestate.create') }}" class="btn btn-success">Neu</a>
                            @endforelse
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
