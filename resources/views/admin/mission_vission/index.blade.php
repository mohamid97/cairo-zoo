@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.missions_and_visions') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.missions_and_visions') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.our_mission_and_vision') }}</h3>
                </div>

                <form role="form" method="post" action="{{ route('admin.mission_vission.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        {{-- Mission --}}
                        <div class="border p-3">
                            <div class="row">
                                @foreach($langs as $lang)
                                    <div class="form-group col-md-6">
                                        <label for="mission">{{ __('main.mission') }} ({{ $lang->name }})</label>
                                        <textarea name="mission[{{$lang->code}}]" class="form-control ckeditor" id="mission" placeholder="{{ __('main.enter_mission') }}">{{ isset($mission) && isset($mission->translate($lang->code)->mission) ? $mission->translate($lang->code)->mission : '' }}</textarea>
                                        @error('mission.' . $lang->code)
                                        <div class="text-danger">{{ $errors->first('mission.' . $lang->code) }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <br>

                        {{-- Vision --}}
                        <div class="border p-3">
                            <div class="row">
                                @foreach($langs as $lang)
                                    <div class="form-group col-md-6">
                                        <label for="vission">{{ __('main.vision') }} ({{ $lang->name }})</label>
                                        <textarea name="vission[{{$lang->code}}]" class="form-control ckeditor" id="vission" placeholder="{{ __('main.enter_vision') }}">{{ isset($mission) && isset($mission->translate($lang->code)->vission) ? $mission->translate($lang->code)->vission : '' }}</textarea>
                                        @error('vission.' . $lang->code)
                                        <div class="text-danger">{{ $errors->first('vission.' . $lang->code) }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <br>

                        {{-- Services --}}
                        <div class="border p-3">
                            <div class="row">
                                @foreach($langs as $lang)
                                    <div class="form-group col-md-6">
                                        <label for="services">{{ __('main.services') }} ({{ $lang->name }})</label>
                                        <textarea name="services[{{$lang->code}}]" class="form-control ckeditor" id="services" placeholder="{{ __('main.enter_services') }}">{{ isset($mission) && isset($mission->translate($lang->code)->services) ? $mission->translate($lang->code)->services : '' }}</textarea>
                                        @error('services.' . $lang->code)
                                        <div class="text-danger">{{ $errors->first('services.' . $lang->code) }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <br>

                        {{-- Brief --}}
                        <div class="border p-3">
                            <div class="row">
                                @foreach($langs as $lang)
                                    <div class="form-group col-md-6">
                                        <label for="breif">{{ __('main.brief') }} ({{ $lang->name }})</label>
                                        <textarea name="breif[{{$lang->code}}]" class="form-control ckeditor" id="breif" placeholder="{{ __('main.enter_brief') }}">{{ isset($mission) && isset($mission->translate($lang->code)->breif) ? $mission->translate($lang->code)->breif : '' }}</textarea>
                                        @error('breif.' . $lang->code)
                                        <div class="text-danger">{{ $errors->first('breif.' . $lang->code) }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <br>

                        {{-- About --}}
                        <div class="border p-3">
                            <div class="row">
                                @foreach($langs as $lang)
                                    <div class="form-group col-md-6">
                                        <label for="about">{{ __('main.about') }} ({{ $lang->name }})</label>
                                        <textarea name="about[{{$lang->code}}]" class="form-control ckeditor" id="about" placeholder="{{ __('main.enter_about') }}">{{ isset($mission) && isset($mission->translate($lang->code)->about) ? $mission->translate($lang->code)->about : '' }}</textarea>
                                        @error('about.' . $lang->code)
                                        <div class="text-danger">{{ $errors->first('about.' . $lang->code) }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <br>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">
                            <i class="nav-icon fas fa-paper-plane"></i> {{ __('main.update') }}
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </section>
@endsection


