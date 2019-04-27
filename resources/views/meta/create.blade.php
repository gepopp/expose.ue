@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between"><span>Meta Daten Felder</span><span><a href="{{ route('meta.index') }}" class="btn btn-default btn-sm">Zurück</a></span></div>

                    <div class="card-body">
                        <form method="post" action="{{ route('meta.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="name">{{ __('Name*') }}</label>
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="postfix">{{ __('Postfix (EUR, m², usw.)') }}</label>
                                <input id="postfix" type="text" class="form-control{{ $errors->has('postfix') ? ' is-invalid' : '' }}" name="postfix" value="{{ old('postfix') }}" >
                                @if ($errors->has('postfix'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('postfix') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="format_number" name="format_number">
                                <label class="form-check-label" for="format_number">
                                    Zahlen formattieren ( 2 Kommastellen und 1.000er Punkt )
                                </label>
                            </div>
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary btn-sm btn-block">
                                    {{ __('update') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
