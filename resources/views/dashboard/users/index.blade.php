@extends('layouts.dashboard.app')
@section('title')
    <title>@lang('site.users')</title>
@endsection
@section('css')
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dashboard/dist/css/adminlte.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
@endsection
@section('content')
    <section class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>@lang('site.users') ({{$users->total()}})</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dash.index') }}">@lang('site.home')</a></li>
                            <li class="breadcrumb-item active">@lang('site.users')</li>
                        </ol>
                    </div>
                </div>
            </div>

        </section>
        <div class="container">
            @include("components.dashboard.includes.success")
            @include("components.dashboard.includes.message")
        </div>

        @php
            $edit = auth()->user()->hasPermission("users_update");
            $delete = auth()->user()->hasPermission("users_delete");
        @endphp
        <section class="content-header">
            <div class="container-fluid">
                <form class="row flex-row-reverse" action="{{route('dash.users.index')}}" method="get">
                    <div class="col-md-4">
                        <input type="text" name="search" value="{{request()->search
                        }}"
                               placeholder="@lang("site.searchAbout")" class="form-control">
                    </div>
                    <div class="d-flex">
                        @if(auth()->user()->hasPermission("users_create"))
                            <a class="btn btn-info" href="{{route("dash.users.create")}}">@lang("site.add") <i
                                    class="fa fa-plus"></i> </a>
                        @endif
                        <button type="submit" class="btn btn-info mx-1"
                        >@lang("site.search") <i
                                class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
        </section>
        <div class="content">
            <div class="container-fluid" id="usersT">
                <table id="usersTable" class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>@lang('site.image')</th>
                        <th>@lang('site.firstName')</th>
                        <th>@lang('site.lastName')</th>
                        <th>@lang('site.email')</th>
                        <th>@lang('site.action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $count = 1; ?>
                    @foreach ($users as $user)
                        <tr>
                            <td><?= $count ?></td>
                            <td>
                                <div>

                                    <img style="width: 50px" src="{{ $user->image_path }}"
                                         alt="user img">
                                </div>
                            </td>
                            <td>{{ $user->first_name }}</td>
                            <td>{{ $user->last_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ $edit ? route("dash.users.edit",$user) : "#" }}"
                                       class="btn btn-info mr-1 {{$edit ? "" : 'disabled'}}">
                                        {{--                                        @lang("site.edit")--}}
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form class="formDelete"
                                          onsubmit="return confirm('@lang("site.delete_confirm_user")');"
                                          action="{{$delete ? route("dash.users.destroy",$user) : "#" }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-danger {{$delete ? "" : 'disabled'}}"
                                                style="{{$delete ? "" : "cursor: not-allowed"}}"
                                        >
                                            {{--                                            @lang("site.delete")--}}
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                            <?php $count++; ?>
                    @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">

                    {{ $users->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
        @endsection
        @section('script')
            <!-- jQuery -->
            <script src="{{ asset('dashboard/plugins/jquery/jquery.min.js') }}"></script>
            <!-- Bootstrap 4 rtl -->
            <script src="https://cdn.rtlcss.com/bootstrap/v4.2.1/js/bootstrap.min.js"></script>
            <!-- Bootstrap 4 -->
            <script src="{{ asset('dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
            <!-- DataTables -->
            <script src="{{ asset('dashboard/plugins/datatables/jquery.dataTables.js') }}"></script>
            <script src="{{ asset('dashboard/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
            <script>
                $(function () {
                    $('#usersTable').DataTable({
                        "paging": false,
                        "scrollY": '50vh',
                        "scrollCollapse": true,
                        "scrollX": true,
                        "lengthChange": true,
                        "searching": false,
                        "ordering": true,
                        "info": false,
                        "autoWidth": false,
                        "language": {
                            "lengthMenu": " _MENU_ ",
                            "zeroRecords": "@lang('site.emptyTable')",
                            "info": "@lang('site.infoS') (_PAGE_) @lang('site.page') @lang('site.of') (_PAGES_) @lang('site.pages')",
                            "infoEmpty": "@lang('site.emptyTable')",
                            "search": "@lang('site.search') : ",
                        }
                    });
                });
            </script>
    </section>
@endsection
