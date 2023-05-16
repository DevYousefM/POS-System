@extends('layouts.dashboard.app')
@section('title')
    <title>@lang('site.createOrderTitle')</title>
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
                        <h1>@lang('site.createOrderTitle')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dash.index') }}">@lang('site.home')</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dash.clients.index') }}">@lang('site.clients')</a></li>
                            <li class="breadcrumb-item active">@lang('site.titleOrderCreate')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                @include("components.dashboard.includes.message")
                <div class="orderCreate">

                    <div class="card card-info card-outline p-1" style="height: fit-content;">
                        <div class="card-header">
                            <h3 class="card-title float-none mb-0">@lang('site.categories')</h3>
                        </div>

                        <div class="accordion mt-3" id="categories">
                            @foreach($categories as $category)
                                @if($category->products->count() > 0)
                                    <div class="card">
                                        <div class="card-header p-0" id="headingOne">
                                            <h2 class="mb-0">
                                                <button class="btn btn-info btn-block text-left" type="button"
                                                        data-toggle="collapse" data-target="#collapse{{$category->id}}"
                                                        aria-expanded="true"
                                                        aria-controls="collapseOne">
                                                    {{$category->name}}
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="collapse{{$category->id}}" class="collapse"
                                             aria-labelledby="headingOne"
                                             data-parent="#categories">

                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th>@lang("site.name")</th>
                                                    <th>@lang("site.stock")</th>
                                                    <th>@lang("site.price")</th>
                                                    <th>@lang("site.add")</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @foreach($category->products as $product)
                                                    <tr>
                                                        <td>{{$product->name}}</td>
                                                        <td>
                                                            {{$product->stock}}
                                                        </td>
                                                        <td>
                                                            {{$product->sell_price}}
                                                        </td>
                                                        <td>
                                                            <button
                                                                class="btn btn-success add-product-btn"
                                                                id="product-{{$product->id}}"
                                                                data-name="{{$product->name}}"
                                                                data-price="{{$product->sell_price}}"
                                                                data-id="{{$product->id}}"
                                                            ><i
                                                                    class="fas fa-plus"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    {{--                                        @else--}}
                                    {{--                                            <div--}}
                                    {{--                                                class="p-2 text-bold text-center text-danger">@lang("site.cat_empty")</div>--}}
                                @endif
                            @endforeach

                        </div>
                    </div>

                    <div>
                        <div class="card card-info card-outline p-1">
                            @include("components.dashboard.includes.error")
                            <form method="POST" action="{{route("dash.clients.orders.store",$client->id)}}">
                                @csrf
                                @method("POST")
                                <div class="card-header">
                                    <h3 class="card-title float-none mb-0">@lang('site.orders')</h3>
                                </div>

                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>@lang("site.product")</th>
                                        <th>@lang("site.quantity")</th>
                                        <th>@lang("site.price")</th>
                                    </tr>
                                    </thead>
                                    <tbody class="order-list">

                                    </tbody>
                                </table>
                                <div class="d-flex flex-wrap justify-content-around">
                                    <label style="font-size: 20px;font-weight: 400;"
                                           class="d-flex">@lang("site.discount") :
                                        <span>
                                        <input type="number" name="discount" id="discount" min="0" value="0"
                                               class="form-control text-center" style="width: 60px">
                                        </span>
                                    </label>
                                    <label style="font-size: 20px;font-weight: 400">@lang("site.total") : <span
                                            id="total">0</span></label>
                                </div>
                                <button class="btn btn-info btn-block disabled" id="add-order"
                                        style="cursor: not-allowed">@lang("site.add") <i
                                        class="fas fa-plus"></i></button>
                            </form>
                        </div>
                        @if($client->orders()->count() > 0)
                            <div class="card card-info card-outline p-1">


                                <div class="card-header">
                                    <h3 class="card-title float-none mb-0">@lang('site.previous_orders') {{$client->orders()->count()}} </h3>
                                </div>


                                <div class="accordion mt-3" id="categories">
                                    @foreach($client->orders as $order)
                                        <div class="card">
                                            <div class="card-header p-0" id="headingOne">
                                                <h2 class="mb-0">
                                                    <button class="btn btn-info btn-block text-left" type="button"
                                                            data-toggle="collapse"
                                                            data-target="#collapseOrder{{$order->id}}"
                                                            aria-expanded="true"
                                                            aria-controls="collapseOne">
                                                        {{$order->created_at->format("d-m-Y")}}
                                                    </button>
                                                </h2>
                                            </div>
                                            <div id="collapseOrder{{$order->id}}" class="collapse"
                                                 aria-labelledby="headingOne"
                                                 data-parent="#categories">

                                                <table class="table table-striped table-borderless mb-0"
                                                       style="font-size: 15px">
                                                    @foreach($order->products as $product)

                                                        <thead>
                                                        <tr>
                                                            <th>@lang("site.product")</th>
                                                            <th>@lang("site.quantity")</th>
                                                            <th>@lang("site.product_price")</th>
                                                        </tr>

                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td>{{$product->name}}</td>
                                                            <td>
                                                                {{$product->pivot->quantity}}
                                                            </td>
                                                            <td>
                                                                {{$product->sell_price}}
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                        <thead>


                                                        <tr>
                                                            <th>
                                                                @lang("site.total") :

                                                            </th>
                                                            <th>
                                                                {{$product->sell_price * $product->pivot->quantity}}
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                    @endforeach

                                                </table>
                                            </div>
                                        </div>
                                    @endforeach


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
