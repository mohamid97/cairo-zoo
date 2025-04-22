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
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.our_mission_and_vision') }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{ route('admin.mission_vission.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <div class="border p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="mission">{{ __('main.mission') }} ({{ $lang->name }}) </label>
                                    <input type="text" name="mission[{{$lang->code}}]" class="form-control" id="mission" placeholder="{{ __('main.enter_mission') }}" value="{{ isset($mission) && isset($mission->translate($lang->code)->mission) ? $mission->translate($lang->code)->mission : '' }}">
                                    @error('mission.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('mission.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <br>

                        <div class="border p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="vission">{{ __('main.vision') }} ({{ $lang->name }}) </label>
                                    <input type="text" name="vission[{{$lang->code}}]" class="form-control" id="vission" placeholder="{{ __('main.enter_vision') }}" value="{{ isset($mission) && isset($mission->translate($lang->code)->vission) ? $mission->translate($lang->code)->vission : '' }}">
                                    @error('vission.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('vission.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <br>

                        <div class="border p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="services">{{ __('main.services') }} ({{ $lang->name }}) </label>
                                    <input type="text" name="services[{{$lang->code}}]" class="form-control" id="services" placeholder="{{ __('main.enter_services') }}" value="{{ isset($mission) && isset($mission->translate($lang->code)->services) ? $mission->translate($lang->code)->services : '' }}">
                                    @error('services.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('services.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <br>

                        <div class="border p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="breif">{{ __('main.brief') }} ({{ $lang->name }}) </label>
                                    <input type="text" name="breif[{{$lang->code}}]" class="form-control" id="breif" placeholder="{{ __('main.enter_brief') }}" value="{{ isset($mission) && isset($mission->translate($lang->code)->breif) ? $mission->translate($lang->code)->breif : '' }}">
                                    @error('breif.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('breif.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <br>

                        <div class="border p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="about">{{ __('main.about') }} ({{ $lang->name }}) </label>
                                    <input type="text" name="about[{{$lang->code}}]" class="form-control" id="about" placeholder="{{ __('main.enter_about') }}" value="{{ isset($mission) && isset($mission->translate($lang->code)->about) ? $mission->translate($lang->code)->about : '' }}">
                                    @error('about.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('about.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <br>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-info"> <i class="nav-icon fas fa-paper-plane"></i> {{ __('main.update') }}</button>
                    </div>
                </form>
            </div>

        </div>
    </section>
@endsection
