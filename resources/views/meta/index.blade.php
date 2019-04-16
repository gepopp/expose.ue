@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between"><span>Meta Daten Felder</span>
                        <span>
                            <a href="{{ route('meta.create') }}" class="btn btn-success btn-sm">Neu</a>

                        </span>
                    </div>

                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @forelse($metas as $meta)
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>{{ $meta->name }} ( {{ $meta->postfix }} ) </span>
                                    <span>
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <a href="{{ route('meta.edit', $meta->id ) }}" class="btn btn-success btn-sm">bearbeiten</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <form method="post" action="{{ route('meta.destroy', $meta) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">löschen</button>
                                            </form>
                                        </li>
                                    </ul>
                                     </span>
                                </li>
                            @empty
                                <li class="list-group-item text-center">
                                    <h3>Noch kein Daten</h3>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
