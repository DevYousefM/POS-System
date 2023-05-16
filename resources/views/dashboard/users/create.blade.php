@extends('layouts.dashboard.app')
@section('title')
    <title>@lang('site.createUserTitle')</title>
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
                        <h1>@lang('site.createUserTitle')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dash.index') }}">@lang('site.home')</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dash.users.index') }}">@lang('site.users')</a></li>
                            <li class="breadcrumb-item active">@lang('site.titleFormCreate')</li>
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
                        <h3 class="card-title float-none mb-0">@lang('site.titleFormCreate')</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    @include("components.dashboard.includes.error")
                    @include("components.dashboard.includes.success")
                    @include("components.dashboard.includes.message")
                    <form role="form" action="{{route("dash.users.store")}}" enctype="multipart/form-data"
                          method="post">
                        @method("post")
                        @csrf
                        <div class="card-body pb-0">
                            <div class="form-group">
                                <label for="exampleInputFName">@lang("site.FName")</label>
                                <input type="text" class="form-control" id="exampleInputFName"
                                       placeholder="@lang("site.ExFName")" name="first_name"
                                       value="{{old("first_name")}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputLName">@lang("site.LName")</label>
                                <input type="text" class="form-control" id="exampleInputLName"
                                       placeholder="@lang("site.ExLName")" name="last_name"
                                       value="{{old("last_name")}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">@lang("site.email")</label>
                                <input type="email" class="form-control" id="exampleInputEmail1"
                                       placeholder="@lang("site.ExEnterEmail")" name="email" value="{{old("email")}}">
                            </div>
                            <div class="form-group uploadImage">
                                <label for="imageField">@lang("site.profileImage")</label>
                                <div class="input-group">
                                    <div>
                                        <img id="imagePlace" src="{{asset("uploads/user_images/default.png")}}"
                                             style="height:  38px"
                                             class="img-thumbnail"/>

                                    </div>
                                    <div class="custom-file">
                                        <input type="file" accept="image/*" name="image" class="custom-file-input"
                                               id="imageField">
                                        <label class="custom-file-label"
                                               for="imageField">@lang("site.chooseFile")</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="">@lang("site.upload")</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword">@lang("site.password")</label>
                                <input type="password" class="form-control" id="exampleInputPassword"
                                       placeholder="@lang("site.ExPassword")" name="password"
                                >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPasswordC">@lang("site.ConfirmationPassword")</label>
                                <input type="password" class="form-control" id="exampleInputPasswordC"
                                       placeholder="@lang("site._ConPassword")" name="password_confirmation"
                                >
                            </div>
                        </div>
                        @php
                            $modals = ["users" , "categories" ,"products","clients","orders"];
                            $maps = ["create" , "read" , "update" , "delete"];
                        @endphp

                        <div class="row card-body pt-0 pb-1">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header d-flex p-0">
                                        <ul class="nav nav-pills  p-2">
                                            @foreach($modals as $i => $modal)
                                                <li class="nav-item"><a class="nav-link {{$i == 0 ? 'active' : ''}}"
                                                                        href="#{{$modal}}"
                                                                        data-toggle="tab">@lang("site.".$modal)</a></li>
                                            @endforeach
                                        </ul>
                                    </div><!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="tab-content">
                                            @foreach($modals as $i => $modal)
                                                <div class="tab-pane  {{$i == 0 ? 'active' : ''}}"
                                                     id="{{$modal}}">
                                                    <div class="d-flex flex-wrap">

                                                        @foreach($maps as $i=> $map)
                                                            <div class="form-check">
                                                                <label class="form-check-label" for="Check{{$i}}">
                                                                    <input type="checkbox" name="permissions[]"
                                                                           value="{{$modal.'_'.$map}}"
                                                                           class="form-check-input"
                                                                           id="Check{{$i}}">
                                                                    @lang("site.".$map)</label>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                </div>
                                            @endforeach
                                        </div>
                                        <!-- /.tab-content -->
                                    </div><!-- /.card-body -->
                                </div>
                                <!-- ./card -->
                            </div>
                            <!-- /.col -->
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">@lang("site.add") <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </section>
    </div>

@endsection
<style>
    .uploadImage .custom-file-label::after {
        content: "@lang("site.browse")"
    }
</style>
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
