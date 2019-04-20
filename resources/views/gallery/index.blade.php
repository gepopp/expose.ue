@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span>Bildgallerien</span>
                        <span>
                            <a href="{{ route('creategallery', $realEstate) }}" class="btn btn-success btn-sm">neu</a>
                        </span>
                    </div>

                    <div class="card-body">
                        <ul class="list-group-flush"></ul>
                        @forelse($galleries as $realEstateGallery)
                            <li class="list-group-item d-flex justify-content-between">
                                <div>
                                    <p>{{ $realEstateGallery->name }}</p>
                                    <p>{{ $realEstateGallery->files->count() }} Bilder</p>
                                </div>
                                <div>
                                    <p><a href="#">bearbeiten</a> |
                                    <form method="post" action="{{ route('deletegallery', [$realEstate, $realEstateGallery]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <a onclick="$(this).closest('form').submit();">löschen</a>
                                    </form>


                                    </p>
                                    <p>
                                        @if($realEstateGallery->is_public) öffentliche Galerie @else private Galerie @endif
                                    </p>
                                </div>
                            </li>
                        @empty
                            <h3 class="text-center">Neue Gallerie erstellen</h3>
                            <a href="{{ route('creategallery', $realEstate) }}" class="btn btn-success">erstellen</a>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection