@extends('layouts.dashboard.app')
@section('title')
    <title>@lang('site.createClientTitle')</title>
@endsection
@section('css')
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dashboard/dist/css/adminlte.min.css') }}">
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>@lang('site.editClientTitle')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dash.index') }}">@lang('site.home')</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dash.clients.index') }}">@lang('site.clients')</a></li>
                            <li class="breadcrumb-item active">@lang('site.editClientTitle')</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <div class="container-fluid">

                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title float-none mb-0">@lang('site.editClientTitle')</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    @include("components.dashboard.includes.error")
                    @include("components.dashboard.includes.success")
                    @include("components.dashboard.includes.message")
                    <form role="form" action="{{route("dash.clients.update",$client)}}"
                          enctype="multipart/form-data"
                          method="post">
                        @method("PUT")
                        @csrf
                        <div class="card-body pb-0">
                            <div class="form-group">
                                <label for="name">@lang("site.name")</label>
                                <input type="text" class="form-control" id="name"
                                       name="name"
                                       value="{{$client->name}}">
                            </div>
                            <div class="form-group">
                                <label for="national_id">@lang("site.national_id")</label>
                                <input type="number" class="form-control" id="national_id"
                                       name="national_id"
                                       value="{{$client->national_id}}">
                            </div>
                            <div class="form-group">
                                <label for="phone">@lang("site.phone")</label>
                                <input type="tel" class="form-control" id="phone"
                                       name="phone"
                                       value="{{$client->phone}}">
                            </div>
                            <div class="form-group">
                                <label for="address">@lang("site.address")</label>
                                <input type="text" class="form-control" id="address"
                                       name="address"
                                       value="{{$client->address}}">
                            </div>
                            <div class="card-footer pr-0">
                                <button type="submit" class="btn btn-primary">@lang("site.edit")<i
                                        class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </section>
    </div>
@endsection
@section('script')
    <!-- jQuery -->
    <script src="{{ asset('dashboard/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        imageField.onchange = evt => {
            const [file] = imageField.files
            if (file) {
                imagePlace.src = URL.createObjectURL(file)
            }
        }
    </script>
@endsection
