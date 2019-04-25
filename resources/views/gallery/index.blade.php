@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class=" d-flex justify-content-between">
                            <span>Bildgallerien</span>
                            <span>
                            <a href="{{ route('creategallery', $realEstate) }}" class="btn btn-success btn-sm">neu</a>
                        </span>
                        </div>
                        @include('realestate.nav')
                    </div>

                    <div class="card-body">
                        <ul class="list-group-flush"></ul>
                        @forelse($galleries as $realEstateGallery)
                            <li class="list-group-item d-flex justify-content-between">
                                <div>
                                    <p>{{ $realEstateGallery->name }}</p>
                                    <p>{{ $realEstateGallery->images->count() }} Bilder - <a href="{{ route('gallery.sort', [$realEstate, $realEstateGallery]) }}">sortieren und beschriften</a> </p>
                                    @foreach($realEstateGallery->images as $image)
                                        <img src="{{ Storage::url($image->thumb_name) }}" class="img-thumbnail d-inline" width="50">
                                    @endforeach

                                </div>
                                <div>
                                    <p><a href="{{ route('editgallery', [ $realEstate, $realEstateGallery ]) }}">bearbeiten</a> |
                                    <form method="post" action="{{ route('deletegallery', [$realEstate, $realEstateGallery]) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <a onclick="$(this).closest('form').submit();" href="#">löschen</a>
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