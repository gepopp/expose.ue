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
                                            <ul class="nav">

                                                <li class="nav-item">
                                                    <a href="{{ route('realestate.edit', $realEstate ) }}" class="nav-link">bearbeiten</a>
                                                </li>
                                                <li class="nav-item">
                                                    <form method="post" action="{{ route('realestate.destroy', $realEstate) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a class="nav-link" onclick="form.submit();" style="cursor: pointer">löschen</a>
                                                    </form>
                                                </li>
                                                <li class="nav-item dropdown">
                                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">PDF's</a>
                                                    <div class="dropdown-menu">
                                                        <a class="nav-link" href="{{ route('titlepage', $realEstate) }}" target="_blank">Titelseite</a>
                                                        <a class="nav-link" href="{{ route('titlepageh', $realEstate) }}" target="_blank">Titelseite horizontal</a>
                                                        <a class="nav-link" href="{{ route('desc', $realEstate) }}" target="_blank">Beschreibung</a>
                                                    </div>
                                                </li>
                                            </ul>
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
