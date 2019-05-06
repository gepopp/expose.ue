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

                        <form method="post" action="{{ route('realestate.meta.update', [$realEstate, $realEstateMeta]) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">{{ __('Titel*') }}</label>
                                        <input id="name" maxlength="100" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') ?: $realEstateMeta->name }}" required autofocus>
                                        <small>max. 100 Zeichen</small>
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('name') }}</strong></span>
                                        @endif
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" value="1" id="is_public" name="is_public" {{ $realEstateMeta->is_public ? 'checked' : ''  }}>
                                        <label class="form-check-label" for="is_public">
                                            öffentlich
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label>Bild</label>
                                    <upload-crop existingImage="{{ $realEstateMeta->image->blob() }}" :ratio="1"></upload-crop>
                                    @if ($errors->has('file_id'))
                                        <div>
                                            <span class="text-danger"><strong>{{ $errors->first('file_id') }}</strong></span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h3>Metadaten</h3>
                                </div>
                                @foreach(json_decode($realEstateMeta->metadata) as $meta)
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="meta-{{$meta->slug}}">{{ $meta->name }}</label>
                                            <div class="input-group mb-2">
                                                <input type="text" class="form-control" id="meta-{{$meta->slug}}" name="meta[{{$meta->id}}][]" value="{{ isset($meta->value) ? $meta->value : '' }}">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">{{ $meta->postfix }}</div>
                                                </div>
                                            </div>
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