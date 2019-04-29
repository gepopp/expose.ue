@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            Textsnippets
                            <span><a href="{{ route('textSnippet.create') }}" class="btn btn-success">Neu</a></span>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-group-flush">
                            @forelse($textSnippets as $textSnippet)
                                <li class="list-group-item">
                                    <h3>{{ $textSnippet->title }}</h3>
                                    <hr>
                                    {!! $textSnippet->text !!}
                                    <a href="{{ route('textSnippet.edit', $textSnippet) }}" class="btn btn-success">bearbeiten</a>
                                </li>
                            @empty
                                <h3 class="text-center">Noch keinen Text.</h3>
                                <a href="{{ route('textSnippet.create') }}" class="btn btn-success">Neu</a>
                            @endforelse

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
