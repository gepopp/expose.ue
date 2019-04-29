@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span>Deine Einstellungen</span>
                    </div>


                    <div class="card-body">
                        <h3>Snippetseiten Seitenleiste</h3>
                        <form method="post" action="{{ route('userSetting.store') }}">
                            @csrf
                            <input type="hidden" name="name" value="sidebar-text">
                            <w-y-s-i-w-y-g name="setting" content="{{ old('setting') ?: isset($settings['sidebar-text']) ? $settings['sidebar-text'] : '' }}"></w-y-s-i-w-y-g>
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
