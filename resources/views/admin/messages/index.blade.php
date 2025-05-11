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
                    <h1>{{ __('main.messages_from_contacts') }}</h1> <!-- Translation key for "Messages From Contacts" -->
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{ __('main.home') }}</a></li> <!-- Translation key for "Home" -->
                        <li class="breadcrumb-item active">{{ __('main.messages') }}</li> <!-- Translation key for "Messages" -->
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-info">

                <div class="card-header">
                    <h3 class="card-title">{{ __('main.all_messages') }}</h3> <!-- Translation key for "All Messages" -->

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('main.name') }}</th> 
                            <th>{{ __('main.phone') }}</th> 
                            <th>{{ __('main.subject') }}</th> 
                            <th>{{ __('main.date') }}</th> 
                            <th>{{ __('main.action') }}</th> 
                        </tr>
                        </thead>
                        <tbody>

                        @forelse($msgs as $index => $msg)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                {{ isset($msg->name) ? $msg->name : __('main.no_data') }} <!-- Translation key for "No Data" -->
                                </td>
                                <td>
                                    {{ isset($msg->phone) ? $msg->phone : __('main.no_data') }}
                                </td>
                                <td>
                                    {{ isset($msg->email) ? $msg->email : __('main.no_data') }}
                                </td>
                                <td>
                                    {{ isset($msg->subject) ? $msg->subject : __('main.no_data') }}
                                </td>
                                <td>
                                    {{ isset($msg->created_at) ? $msg->created_at : __('main.no_data') }}
                                </td>
                                <td>

                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <a href="{{ route('admin.messages.show', ['id' => $msg->id]) }}">
                                            <button class="btn btn-sm btn-info"> <i class="nav-icon fas fa-edit"></i> </button> 
                                        </a>



                                        <button class="btn btn-sm btn-danger" onclick="showDeleteMessageModal({{ $msg->id }})">
                                            <i class="nav-icon fas fa-trash"></i>
                                        </button>
    
                                        {{-- <a href="{{ route('admin.messages.destroy', ['id' => $msg->id]) }}">
                                            <button class="btn btn-sm btn-danger"><i class="nav-icon fas fa-trash"></i> </button> 
                                        </a> --}}

                                    </div>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">{{ __('main.no_data') }}</td> <!-- Translation key for "No Data" -->
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>



        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="confirmDeleteMessageModal" tabindex="-1" role="dialog" aria-labelledby="confirmMessageDeleteLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content border-danger">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="confirmSliderDeleteLabel">{{ __('main.confirm_delete') }}</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>   
                    </div>
                    <div class="modal-body">
                        {{ __('main.delete_Message_warning') ?? 'Are you sure you want to delete this Message? All related data will be removed.' }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('main.cancel') }}</button>
                        <a id="confirmDeleteMessageBtn" href="#" class="btn btn-danger">{{ __('main.confirm') }}</a>
                    </div>
                </div>
            </div>
        </div>



@endsection


@section('scripts')

<script>
    function showDeleteMessageModal(messageId) {
        const url = `{{ url('admin/messages/destroy') }}/${messageId}`;
        document.getElementById('confirmDeleteMessageBtn').setAttribute('href', url);
        $('#confirmDeleteMessageModal').modal('show');
    }
</script>
@endsection
