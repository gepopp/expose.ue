@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
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
                                    <a href="{{ route('realestate.edit', $realEstate) }}">
                                    @if($realEstate->titleimage)
                                        <img src="{{ Storage::url($realEstate->titleimage->thumb_name) }}" class="img-fluid img-thumbnail float-left mr-3" width="80">
                                    @else
                                        <img src="{{ asset('img/thumb.jpg') }}"  class="img-fluid img-thumbnail float-left mr-3" width="80">
                                    @endif
                                    </a>
                                    <div class="d-flex justify-content-between">
                                        <p><strong>{{ $realEstate->name }}</strong></p>
                                        <div>
                                            <form method="post" action="{{ route('realestate.destroy', $realEstate) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm">löschen</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div>
                                        <ul class="nav">
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">bearbeiten</a>
                                                <div class="dropdown-menu">
                                                    <a href="{{ route('realestate.edit', $realEstate ) }}" class="nav-link">Grunddaten</a>
                                                    <a href="{{ route('realestate.address.index', $realEstate ) }}" class="nav-link">Adressen</a>
                                                    <a href="{{ route('galleries', $realEstate ) }}" class="nav-link">Gallerien</a>
                                                    <a href="{{ route('realestate.meta.index', $realEstate ) }}" class="nav-link">Metadaten</a>
                                                    <a href="{{ route('realestate.text.index', $realEstate ) }}" class="nav-link">Texte</a>
                                                    <a href="{{ route('realestate.location.index', $realEstate ) }}" class="nav-link">Lagen</a>
                                                </div>
                                            </li>
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">PDF's</a>
                                                <div class="dropdown-menu">
                                                    <a class="nav-link" href="{{ route('titlepage', $realEstate) }}" target="_blank">Titelseite</a>
                                                    <a class="nav-link" href="{{ route('titlepageh', $realEstate) }}" target="_blank">Titelseite
                                                        horizontal</a>
                                                    <a class="nav-link" href="{{ route('titlepages', $realEstate) }}" target="_blank">Titelseite
                                                        kleines Logo</a>
                                                    <a class="nav-link" href="{{ route('desc', $realEstate) }}" target="_blank">Beschreibung</a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @empty
                                <h3 class="text-center">Noch keine Objekte</h3>
                                <a href="{{ route('realestate.create') }}" class="btn btn-success">Neu</a>
                                @endforelse
                                </li>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
