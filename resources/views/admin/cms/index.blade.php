@extends('admin.layout.master')
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
                    <h1>{{ __('main.blog') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">{{ __('main.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.blog') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">


            <div class="row">
                <div class="col-md-6">
                    <a href="{{ route('admin.cms.add') }}" style="color: #FFF">
                        <button class="btn btn-info">
                            <i class="nav-icon fas fa-plus"></i> {{ __('main.add_new_blog') }}
                        </button>
                    </a>
                </div>
                <div class="col-md-6">
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('admin.cms.index') }}" class="mb-3">
                        <div class="input-group">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="{{ __('main.search_by_name') }}"> <!-- Use translation key -->
                            <div class="input-group-append">
                                <button class="btn btn-info" type="submit">
                                    <i class="fas fa-search"></i> {{ __('main.search') }} <!-- Use translation key -->
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>



            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.all_articles') }}</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('main.image') }}</th>
                            <th>{{ __('main.title') }}</th>
                            <th>{{ __('main.slug') }}</th>
                            <th>{{ __('main.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($cms as $index => $blog)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>

                                <a href="{{ asset('uploads/images/cms/'. $blog->image) }}" target="_blank">
                                        <img class="img-circle" src="{{ asset('uploads/images/cms/'. $blog->image) }}" width="40px" height="40px" alt="{{ __('main.user_avatar') }}">
                                    </a>
                                    
                              
                                </td>
                                <td>{{ $blog->translate(app()->getLocale())->name }}</td>
                                <td>{{ $blog->translate(app()->getLocale())->slug }}</td>
                                <td>

                                <div class="d-flex align-items-center justify-content-center gap-2">
                                <a href="{{ route('admin.cms.edit', ['id' => $blog->id]) }}">
                                        <button class="btn btn-sm btn-info"><i class="nav-icon fas fa-edit"></i> </button>
                                    </a>
                                    @if($blog->deleted_at == null)
                                        <a href="{{ route('admin.cms.soft_delete', ['id' => $blog->id]) }}">
                                            <button class="btn btn-sm btn-info"><i class="nav-icon fas fa-trash"></i> </button>
                                        </a>
                                    @else
                                        <a href="{{ route('admin.cms.restore', ['id' => $blog->id]) }}">
                                            <button class="btn btn-sm btn-success"><i class="nav-icon fas fa-trash-restore"></i> </button>
                                        </a>
                                    @endif


                                    <button class="btn btn-sm btn-danger" onclick="showDeleteCmsModal({{ $blog->id }})">
                                            <i class="nav-icon fas fa-trash"></i>
                                    </button>



                                    <!-- <a href="{{ route('admin.cms.destroy', ['id' => $blog->id]) }}">
                                        <button class="btn btn-sm btn-danger"><i class="nav-icon fas fa-trash"></i> {{ __('main.remove') }}</button>
                                    </a> -->
                                </div>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">{{ __('main.no_data') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center" style="margin-top: 50px;">
                        <!-- Pagination Links -->
                        {{ $cms->links() }}
                    </div>


                </div>
            </div>
        </div>
    </section>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="confirmDeleteCmsModal" tabindex="-1" role="dialog" aria-labelledby="confirmCmsDeleteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content border-danger">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmCmsDeleteLabel">{{ __('main.confirm_delete') }}</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ __('main.delete_cms_warning') ?? 'Are you sure you want to delete this Articel? All related data will be removed.' }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('main.cancel') }}</button>
                    <a id="confirmDeleteCmsBtn" href="#" class="btn btn-danger">{{ __('main.confirm') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        function showDeleteCmsModal(cmsId) {
            const url = `{{ url('admin/cms/destroy') }}/${cmsId}`;
            document.getElementById('confirmDeleteCmsBtn').setAttribute('href', url);
            $('#confirmDeleteCmsModal').modal('show');
        }
    </script>
@endsection
