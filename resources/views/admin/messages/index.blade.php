@extends('admin.layout.master')

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
                            <th>{{ __('main.name') }}</th> <!-- Translation key for "Name" -->
                            <th>{{ __('main.phone') }}</th> <!-- Translation key for "Phone" -->
                            <th>{{ __('main.email') }}</th> <!-- Translation key for "Email" -->
                            <th>{{ __('main.subject') }}</th> <!-- Translation key for "Subject" -->
                            <th>{{ __('main.date') }}</th> <!-- Translation key for "Created At" -->
                            <th>{{ __('main.action') }}</th> <!-- Translation key for "Action" -->
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
                                    <a href="{{ route('admin.messages.show', ['id' => $msg->id]) }}">
                                        <button class="btn btn-sm btn-info"> <i class="nav-icon fas fa-edit"></i> {{ __('main.show') }}</button> <!-- Translation key for "Show" -->
                                    </a>

                                    <a href="{{ route('admin.messages.destroy', ['id' => $msg->id]) }}">
                                        <button class="btn btn-sm btn-danger"><i class="nav-icon fas fa-trash"></i> {{ __('main.remove') }}</button> <!-- Translation key for "Remove" -->
                                    </a>
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

@endsection
