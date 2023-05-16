@extends('layouts.dashboard.app')
@section('title')
    <title>@lang('site.createCategoryTitle')</title>
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
                        <h1>@lang('site.createCategoryTitle')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dash.index') }}">@lang('site.home')</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dash.categories.index') }}">@lang('site.categories')</a></li>
                            <li class="breadcrumb-item active">@lang('site.titleCategoryCreate')</li>
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
                        <h3 class="card-title float-none mb-0">@lang('site.titleCategoryCreate')</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    @include("components.dashboard.includes.error")
                    @include("components.dashboard.includes.success")
                    @include("components.dashboard.includes.message")
                    <form role="form" action="{{route("dash.categories.store")}}"
                          method="post">
                        @method("post")
                        @csrf
                        @foreach(config("translatable.locales") as $locale)
                            <div class="card-body pb-0">
                                <div class="form-group">
                                    <label for="exampleInputFName">@lang("site.".$locale.".name")</label>
                                    <input type="text" class="form-control" id="exampleInputFName"
                                           name="{{$locale}}[name]"
                                           value="{{old($locale.".name")}}">
                                </div>
                            </div>
                        @endforeach
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
@endsection
