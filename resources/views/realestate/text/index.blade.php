@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <span>{{ $realEstate->name }} - Text</span>
                            <span>
                            <a href="{{ route('realestate.text.create', $realEstate) }}" class="btn btn-success btn-sm">neu</a>
                        </span>
                        </div>
                        @include('realestate.nav')
                    </div>
                    <div class="card-body">
                        <ul class="list-group-flush">
                            @forelse($realEstate->text as $realEstateText)
                                <li class="list-group-item">
                                    <div class="d-flex">
                                        <div class="mr-3">
                                            @if($realEstateText->image)
                                                <img src="{{ Storage::url($realEstateText->image->thumb_name) }}" class="img-thumbnail mr-3">
                                            @else
                                                <img src="{{ asset('img/thumb.jpg') }}"  class="img-fluid img-thumbnail float-left mr-3" width="80">
                                            @endif
                                        </div>
                                        <div class="w-100 ">
                                            <h3 class="d-flex justify-content-between">
                                                {{ $realEstateText->name }}
                                                <div>
                                                    <a href="{{ route('realestate.text.edit', [$realEstate, $realEstateText]) }}" class="btn btn-success">bearbeiten</a>
                                                    <form method="post" action="{{ route('realestate.text.destroy', [$realEstate, $realEstateText]) }}" class="d-inline">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button class="btn btn-danger">löschen</button>
                                                    </form>
                                                </div>
                                            </h3>
                                            {!!  $realEstateText->description !!}
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <h3 class="text-center">Noch keinen Text.</h3>
                                <a href="{{ route('realestate.text.create', $realEstate) }}" class="btn btn-success">Neu</a>
                            @endforelse

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
