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
                                    @if($realEstate->titleimage && $realEstate->titleimage->thumb_name)
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
                                            <li class="nav-item">
                                                    <a href="{{ route('realestate.edit', $realEstate ) }}" class="nav-link">Grunddaten</a>
                                            </li>
{{--                                            <li class="nav-item">--}}
{{--                                                    <a href="{{ route('realestate.address.index', $realEstate ) }}" class="nav-link">Adressen ({{ $realEstate->address->count() }})</a>--}}
{{--                                            </li>--}}
                                            <li class="nav-item">
                                                    <a href="{{ route('galleries', $realEstate ) }}" class="nav-link">Gallerien ({{ $realEstate->gallery->count() }})</a>
                                            </li>
                                            <li class="nav-item">
                                                    <a href="{{ route('realestate.meta.index', $realEstate ) }}" class="nav-link">Metadaten ({{ $realEstate->meta->count() }})</a>
                                            </li>
                                            <li class="nav-item">
                                                    <a href="{{ route('realestate.text.index', $realEstate ) }}" class="nav-link">Texte ({{ $realEstate->text->count() }})</a>
                                            </li>
                                            <li class="nav-item">
                                                    <a href="{{ route('realestate.location.index', $realEstate ) }}" class="nav-link">Lagen ({{ $realEstate->location->count() }})</a>
                                            </li>
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">PDF's</a>
                                                <div class="dropdown-menu">
                                                    <a class="nav-link" href="{{ route('pdfcreator', $realEstate) }}" target="_blank">Creator</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="nav-link" href="{{ route('pdfcreator.single', [$realEstate, 'TitlePage']) }}" target="_blank">Titelseite</a>
                                                    <a class="nav-link" href="{{ route('pdfcreator.single', [$realEstate, 'TextPage']) }}" target="_blank">Textseiten</a>
                                                    <a class="nav-link" href="{{ route('pdfcreator.single', [$realEstate, 'MetaPage']) }}" target="_blank">Metaseiten</a>
                                                    <a class="nav-link" href="{{ route('pdfcreator.single', [$realEstate, 'LocationPage']) }}" target="_blank">Lageseiten</a>
                                                    <a class="nav-link" href="{{ route('pdfcreator.single', [$realEstate, 'ImagePage']) }}" target="_blank">Bildseiten</a>
                                                    <a class="nav-link" href="{{ route('pdfcreator.single', [$realEstate, 'SnippetPage']) }}" target="_blank">Snippetseiten</a>
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
