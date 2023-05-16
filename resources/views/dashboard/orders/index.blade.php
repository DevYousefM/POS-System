@extends('layouts.dashboard.app')
@section('title')
    <title>@lang('site.orders')</title>
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
                        <h1>@lang('site.orders') ({{$orders->total()}})
                            {{ isset($dailyInvoice) ? "| " . __("site.dailyInvoice") : null}}
                            {{ isset($yearlyInvoice) ? "| " . __("site.yearlyOrders") : null}}
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dash.index') }}">@lang('site.home')</a></li>
                            <li class="breadcrumb-item active">@lang('site.orders')</li>
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
            $read = auth()->user()->hasPermission("orders_read");
            $edit = auth()->user()->hasPermission("orders_update");
            $delete = auth()->user()->hasPermission("orders_delete");
            $create = auth()->user()->hasPermission("orders_create");
        @endphp
        <section class="content-header">
            <div class="container-fluid">
                <form class="row flex-row-reverse" action="{{route('dash.orders.index')}}" method="get">
                    <div class="col-md-4 col-6">
                        <input type="text" name="search" value="{{request()->search}}"
                               placeholder="@lang("site.searchAboutOr")" class="form-control">
                    </div>
                    <div class="d-flex">

                        <button type="submit" class="btn btn-info mx-1"
                        >@lang("site.search") <i
                                class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
        </section>
        <div class="content">
            <div class="container-fluid">
                <div class="ordersPage">
                    <div class="card card-info card-outline p-1" id="ordersT">
                        <div class="card-header">
                            <h3 class="card-title float-none mb-0">@lang('site.orders')</h3>
                        </div>

                        <table id="ordersTable"

                               style="font-size: 15px;width: 100%;text-align: center;padding-right: 10px;padding-left: 10px;"
                        >
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.clientName')</th>
                                <th>@lang('site.price')</th>
                                <th>@lang('site.discount')</th>
                                <th>@lang('site.created_at')</th>
                                <th>@lang('site.action')</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php $count = 1; ?>
                            @foreach ($orders as $order)
                                <tr>
                                    <td><?= $count ?></td>
                                    <td style="text-transform: capitalize">
                                        {{$order->client->name}}
                                    </td>
                                    <td>
                                        {{number_format($order->total_price,2)}}
                                    </td>
                                    <td>
                                        {{$order->discount != null ?$order->discount : 0 }}
                                    </td>
                                    <td>
                                        {{$order->created_at->toFormattedDateString()}}
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <button
                                                data-url="{{route("dash.orders.products",$order->id)}}"
                                                data-method="get"
                                                class="btn btn-info mr-1  show-products-btn {{$read ? "" : 'disabled'}}"
                                            >
                                                {{--                                        @lang("site.show")--}}
                                                <i class="fa fa-eye"></i>
                                            </button>
                                            <a href="{{ $edit ? route("dash.clients.orders.edit",["client"=>$order->client->id,"order"=> $order]) : "#" }}"
                                               class="btn btn-info mr-1 {{$edit ? "" : 'disabled'}}">
                                                {{--                                        @lang("site.edit")--}}
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <form class="formDelete"
                                                  onsubmit="return confirm('@lang("site.delete_confirm_order")');"
                                                  action="{{$delete ? route("dash.orders.destroy",$order) : "#" }}"
                                                  method="post">
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

                            {{ $orders->appends(request()->query())->links() }}
                        </div>
                    </div>
                    <div class="card card-info card-outline p-1" id="ordersT">
                        <div class="card-header">
                            <h3 class="card-title float-none mb-0">@lang('site.show') @lang('site.products')</h3>
                        </div>
                        <div class="box-body">
                            <div id="order-product-list">
                            </div>
                        </div>
                    </div>
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
            <!-- Order Js Code -->
            <script src="{{ asset('dashboard/dist/js/order.js') }}"></script>
            <!-- jQuery Print Plugin -->

            <script src="{{ asset('dashboard/plugins/jquery-print/jquery.print.js') }}"></script>
            <script>
                $(function () {
                    $('#ordersTable').DataTable({
                        "paging": false,
                        "searching": false,
                        "info": false,
                        "ordering": true,
                        "language": {
                            "infoEmpty": "@lang('site.emptyTable')",
                            "zeroRecords": "@lang('site.emptyTable')",
                        }
                    });
                });
            </script>
    </section>
@endsection
