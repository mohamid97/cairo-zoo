@extends('data_entry.layout.master')

@section('styles')
    <style>
        svg {
            font-size: 5px;
            width: 28px;
        }
        .text-sm {
            margin-top: 26px;
            font-size: .875rem !important;
        }
        .gap-2{
            gap: 10px;
        }
    </style>
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('main.sliders') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('data_entry.home.index') }}">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.sliders') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="mb-3">
                <div>
                    <a href="{{ route('data_entry.sliders.add') }}" class="btn btn-info ml-2">
                        <i class="nav-icon fas fa-plus"></i> {{ __('main.add_new_image') }}
                    </a>
                </div>
                <br>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <!-- Search Form -->
                        <form method="GET" action="{{ route('data_entry.sliders.index') }}" class="input-group">
                            <input type="text" name="search" value="{{ $searchTerm }}" class="form-control" placeholder="{{ __('main.search_by_name') }}" aria-label="{{ __('main.search_by_name') }}">
                            <div class="input-group-append">
                                <button class="btn btn-info" type="submit">
                                    <i class="fas fa-search"></i> {{ __('main.search') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.all_sliders') }}</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>{{ __('main.index') }}</th>
                            <th style="width: 100px">{{ __('main.image') }}</th>
                            <th>{{ __('main.name') }}</th>
                            <th>{{ __('main.small_des') }}</th>
                            <th>{{ __('main.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($sliders as $index => $slider)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <a href="{{ asset('uploads/images/sliders/' . $slider->image) }}" target="__blank">
                                        <img src="{{ asset('uploads/images/sliders/' . $slider->image) }}" width="40px" height="40px" alt="{{ $slider->translate($langs[0]->code)->name }}">

                                    </a>
                                </td>
                                <td>{{ $slider->name }}</td>
                                <td>{{ $slider->small_des }}</td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <a href="{{ route('data_entry.sliders.edit', ['id' => $slider->id]) }}" class="btn btn-sm btn-info">
                                            <i class="nav-icon fas fa-edit"></i>
                                        </a>
                                        @if($slider->deleted_at == null)
                                            <a href="{{ route('data_entry.sliders.soft_delete', ['id' => $slider->id]) }}" class="btn btn-sm btn-info">
                                                <i class="nav-icon fas fa-trash"></i> 
                                            </a>
                                        @else
                                            <a href="{{ route('data_entry.sliders.restore', ['id' => $slider->id]) }}" class="btn btn-sm btn-success">
                                                <i class="nav-icon fas fa-trash-restore"></i> 
                                            </a>
                                        @endif


                                        <button class="btn btn-sm btn-danger" onclick="showDeleteSliderModal({{ $slider->id }})">
                                            <i class="nav-icon fas fa-trash"></i>
                                        </button>
                                        {{-- <a href="{{ route('data_entry.sliders.destroy', ['id' => $slider->id]) }}" class="btn btn-sm btn-danger">
                                            <i class="nav-icon fas fa-trash"></i> 
                                        </a> --}}
                                    </div>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">{{ __('main.no_data_found') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-center" style="margin-top: 50px;">
                        {{ $sliders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>


        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="confirmDeleteSliderModal" tabindex="-1" role="dialog" aria-labelledby="confirmSliderDeleteLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content border-danger">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="confirmSliderDeleteLabel">{{ __('main.confirm_delete') }}</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>   
                    </div>
                    <div class="modal-body">
                        {{ __('main.delete_Slider_warning') ?? 'Are you sure you want to delete this Slider? All related data will be removed.' }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('main.cancel') }}</button>
                        <a id="confirmDeleteSliderBtn" href="#" class="btn btn-danger">{{ __('main.confirm') }}</a>
                    </div>
                </div>
            </div>
        </div>



@endsection


@section('scripts')
    <script>
        function showDeleteSliderModal(sliderId) {
            const url = `{{ url('data_entry/slider/destroy') }}/${sliderId}`;
            document.getElementById('confirmDeleteSliderBtn').setAttribute('href', url);
            $('#confirmDeleteSliderModal').modal('show');
        }
    </script>
@endsection



