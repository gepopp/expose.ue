@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between"><span>Meta Daten Felder</span>
                        <span>
                            <a href="{{ route('meta.index') }}" class="btn btn-success btn-sm">zurück</a>
                        </span>
                    </div>

                    <div class="card-body">
                        <meta-list metas="{{ json_encode($metas) }}"></meta-list>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    import MetaList from "../../js/components/MetaList";
    export default {
        components: {MetaList}
    }
</script>
<script>
    import MetaList from "../../js/components/MetaList";
    export default {
        components: {MetaList}
    }
</script>