@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span>{{ $realEstate->name }} - neuer Datensatz</span><span><a href="{{ route('realestate.meta.index', $realEstate) }}" class="btn btn-default btn-sm">zurück</a></span>
                    </div>
                    <div class="card-body">

                        <form method="post" action="{{ route('realestate.meta.store', $realEstate) }}">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <label>Bild</label>
                                    <upload-crop :ratio="1"></upload-crop>
                                    <hr>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">{{ __('Titel*') }}</label>
                                        <input id="name" maxlength="100" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                                        <small>max. 100 Zeichen</small>
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('name') }}</strong></span>
                                        @endif
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" value="1" id="is_public" name="is_public" checked>
                                        <label class="form-check-label" for="is_public">
                                            öffentlich
                                        </label>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h3>Metadaten</h3>
                                </div>
                                @foreach($metas as $meta)
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="meta-{{$meta->slug}}">{{ $meta->name }}</label>
                                            <div class="input-group mb-2">
                                                <input type="text" class="form-control catch-enter" id="meta-{{$meta->slug}}" name="meta[{{$meta->id}}][value]">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">{{ $meta->postfix }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="meta[{{$meta->id}}][column]" id="column-left" value="left" checked>
                                            <label class="form-check-label" for="column-left">links</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="meta[{{$meta->id}}][column]" id="column-right" value="right">
                                            <label class="form-check-label" for="column-right">rechts</label>
                                        </div>
                                    </div>
                                @endforeach
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
<script>
    import MetaList from "../../../js/components/MetaList";

    export default {
        components: {MetaList}
    }
</script>
<script>
    import GridTest from "../../../js/components/GridTest";

    export default {
        components: {GridTest}
    }
</script>
<script>
    import UploadCrop from "../../../js/components/UploadCrop";
    export default {
        components: {UploadCrop}
    }
</script>