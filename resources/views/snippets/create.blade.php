@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span>Neues Textsnippet</span><span><a href="{{ route('textSnippet.index') }}" class="btn btn-default btn-sm">Alle Texte</a></span>
                    </div>
                    <div class="card-body">

                        <form method="post" action="{{ route('textSnippet.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">{{ __('Titel*') }}</label>
                                        <input id="title" maxlength="100" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}" required autofocus>
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('name') }}</strong></span>
                                        @endif
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" value="1" id="use_as_page" name="use_as_page">
                                        <label class="form-check-label" for="use_as_page">
                                            Als Exposeseite verwenden
                                        </label>
                                    </div>
                                    <label for="description">Text</label>
                                    <w-y-s-i-w-y-g name="text" content="{{ old('text') }}"></w-y-s-i-w-y-g>
                                    @if ($errors->has('text'))
                                        <div>
                                            <span class="text-danger"><strong>{{ $errors->first('text') }}</strong></span>
                                        </div>
                                    @endif

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2 offset-10">
                                    <upload-locked-submit-button></upload-locked-submit-button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
