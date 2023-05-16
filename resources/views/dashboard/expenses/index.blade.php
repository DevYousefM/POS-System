@extends('layouts.dashboard.app')
@section('title')
    <title>@lang('site.expenses') {{ isset($dailyExpenses) ? "| " . __("site.dailyExpenses") : null}}{{ isset($monthlyExpenses) ? "| " . __("site.monthlyExpenses") : null}}</title>
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
                        <h1>@lang('site.expenses')
                            {{ isset($dailyExpenses) ? "| " . __("site.dailyExpenses") : null}}
                            {{ isset($monthlyExpenses) ? "| " . __("site.monthlyExpenses") : null}}


                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dash.index') }}">@lang('site.home')</a></li>
                            <li class="breadcrumb-item active">@lang('site.expenses')</li>
                        </ol>
                    </div>
                </div>
            </div>

        </section>
        <div class="container">
            @include("components.dashboard.includes.success")
            @include("components.dashboard.includes.message")
            @include("components.dashboard.includes.error")
        </div>

        <section class="content-header">
            <div class="container-fluid">
                <form class="row flex-row-reverse" action="{{route('dash.expenses.index')}}" method="get">
                    <div class="col-md-4 col-6">
                        <input type="text" name="search" value="{{request()->search}}"
                               class="form-control">
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
                <div class="ordersPage" style="flex-direction: row-reverse">
                    <div class="card card-info card-outline p-1" id="expensesT">
                        <div class="card-header">
                            <h3 class="card-title float-none mb-0">@lang('site.expenses')</h3>
                        </div>

                        <table id="expensesTable"
                               class="table table-bordered"
                               style="font-size: 15px;width: 100%;text-align: center;padding-right: 10px;padding-left: 10px;"
                        >
                            <thead>
                            <tr>
                                <th>@lang('site.reason')</th>
                                <th>@lang('site.value')</th>
                                <th>@lang('site.theDate')</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($expenses as $expense)
                                <tr>
                                    <td style="text-transform: capitalize">
                                        {{$expense->reason}}
                                    </td>
                                    <td>
                                        {{number_format($expense->value,2)}}
                                    </td>
                                    <td>
                                        {{$expense->created_at->toFormattedDateString()}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">

                            {{ $expenses->appends(request()->query())->links() }}
                        </div>
                    </div>
                    <div class="card card-info card-outline p-1" id="expensesT">
                        <div class="card-header">
                            <h3 class="card-title float-none mb-0">@lang('site.add')</h3>
                        </div>
                        <div class="box-body ">
                            <form role="form" action="{{route("dash.expenses.store")}}"
                                  method="post">
                                @method("post")
                                @csrf
                                <div class="card-body pb-0">
                                    <div class="form-group">
                                        <label for="exampleInputFName">@lang("site.value")</label>
                                        <input type="number" class="form-control" id="exampleInputFName"
                                               name="value"
                                               value="{{old("value")}}">
                                    </div>
                                    @foreach(config("translatable.locales") as $locale)
                                        <div class="form-group">
                                            <label for="exampleInputFName">@lang("site.".$locale.".reason")</label>
                                            <input type="text" class="form-control" id="exampleInputFName"
                                                   name="{{$locale}}[reason]"
                                                   value="{{old($locale.".reason")}}">
                                        </div>
                                    @endforeach
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">@lang("site.add") <i
                                            class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </form>
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
            <script src="{{ asset('$dashboard/dist/js/expense.js') }}"></script>
            <!-- jQuery Print Plugin -->

            <script src="{{ asset('dashboard/plugins/jquery-print/jquery.print.js') }}"></script>
            <script>
                $(function () {
                    $('#expensesTable').DataTable({
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
