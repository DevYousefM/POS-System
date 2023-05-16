@extends('layouts.dashboard.app')
@section('title')
    <title>@lang('site.trash')</title>
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
                        <h1>@lang('site.trash')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dash.index') }}">@lang('site.home')</a></li>
                            <li class="breadcrumb-item active">@lang('site.trash')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                @include("components.dashboard.includes.message")
                <div class="col-12">
                    <div class="card card-info card-outline p-1" style="height: fit-content;">
                        <div class="card-header">
                            <h3 class="card-title float-none mb-0">@lang('site.recycles')</h3>
                        </div>
                        {{-- Categories --}}
                        @if(count($categories) > 0)
                            <div class="accordion mt-3" id="categories">
                                <div class="card">
                                    <div class="card-header p-0" id="headingOne">
                                        <h2 class="mb-0">
                                            <button class="btn btn-info btn-block text-left" type="button"
                                                    data-toggle="collapse" data-target="#collapseCategory"
                                                    aria-expanded="true"
                                                    aria-controls="collapseOne">
                                                @lang("site.categories")
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="collapseCategory" class="collapse"
                                         aria-labelledby="headingOne"
                                         data-parent="#categories">
                                            <?php $count = 0 ?>
                                        <table class="table table-striped">
                                            <tbody>
                                            @foreach($categories as $category)
                                                    <?php $count++ ?>
                                                <tr>
                                                    <td>{{$count}}.</td>
                                                    <td>{{$category->name}}</td>
                                                    <td>
                                                        <a href="{{route("dash.trash.restore",["table"=>"categories","id"=>$category->id])}}"
                                                           class="btn btn-info mr-1">
                                                            @lang("site.restore")
                                                            <i class="fa fa-undo"></i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="{{route("dash.trash.forceDelete",["table"=>"categories","id"=>$category->id])}}"
                                                           class="btn btn-danger mr-1">
                                                            @lang("site.deletePer")
                                                            <i class="fa fa-trash-alt"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        @endif
                        {{-- Products --}}
                        @if( isset($products) && count($products) > 0)
                            <div class="accordion mt-3" id="products">
                                <div class="card">
                                    <div class="card-header p-0" id="headingOne">
                                        <h2 class="mb-0">
                                            <button class="btn btn-info btn-block text-left" type="button"
                                                    data-toggle="collapse" data-target="#collapseProduct"
                                                    aria-expanded="true"
                                                    aria-controls="collapseOne">
                                                @lang("site.products")
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="collapseProduct" class="collapse"
                                         aria-labelledby="headingOne"
                                         data-parent="#products">
                                            <?php $count = 0 ?>
                                        <table class="table table-striped">
                                            <tbody>
                                            @foreach($products as $product)
                                                    <?php $count++ ?>
                                                <tr>
                                                    <td>{{$count}}.</td>
                                                    <td>{{$product->name}}</td>
                                                    <td>
                                                        <a href="{{route("dash.trash.restore",["table"=>"products","id"=>$product->id])}}"
                                                           class="btn btn-info mr-1">
                                                            @lang("site.restore")
                                                            <i class="fa fa-undo"></i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="{{route("dash.trash.forceDelete",["table"=>"products","id"=>$category->id])}}"
                                                           class="btn btn-danger mr-1">
                                                            @lang("site.deletePer")
                                                            <i class="fa fa-trash-alt"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(isset($clients) && count($clients) > 0)
                            <div class="accordion mt-3" id="clients">
                                <div class="card">
                                    <div class="card-header p-0" id="headingOne">
                                        <h2 class="mb-0">
                                            <button class="btn btn-info btn-block text-left" type="button"
                                                    data-toggle="collapse" data-target="#collapseClient"
                                                    aria-expanded="true"
                                                    aria-controls="collapseOne">
                                                @lang("site.clients")
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="collapseClient" class="collapse"
                                         aria-labelledby="headingOne"
                                         data-parent="#clients">
                                            <?php $count = 0 ?>
                                        <table class="table table-striped">
                                            <tbody>
                                            @foreach($clients as $client)
                                                    <?php $count++ ?>
                                                <tr>
                                                    <td>{{$count}}.</td>
                                                    <td>{{$client->name}}</td>
                                                    <td>
                                                        <a href="{{route("dash.trash.restore",["table"=>"clients","id"=>$client->id])}}"
                                                           class="btn btn-info mr-1">
                                                            @lang("site.restore")
                                                            <i class="fa fa-undo"></i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="{{route("dash.trash.forceDelete",["table"=>"clients","id"=>$client->id])}}"
                                                           class="btn btn-danger mr-1">
                                                            @lang("site.deletePer")
                                                            <i class="fa fa-trash-alt"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
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
    <!-- Order Js Code -->
    <script src="{{ asset('dashboard/dist/js/order.js') }}"></script>
    <!-- Number Jquery Plugin -->
    <script src="{{ asset('dashboard/plugins/jquery-number/jquery.number.min.js') }}"></script>
@endsection
