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
                        <h1>@lang('site.createProductTitle')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dash.index') }}">@lang('site.home')</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dash.products.index') }}">@lang('site.products')</a></li>
                            <li class="breadcrumb-item active">@lang('site.titleProductCreate')</li>
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
                        <h3 class="card-title float-none mb-0">@lang('site.titleProductCreate')</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    @include("components.dashboard.includes.error")
                    @include("components.dashboard.includes.success")
                    @include("components.dashboard.includes.message")
                    <form role="form" action="{{route("dash.products.store")}}"
                          method="post" enctype="multipart/form-data">
                        @method("post")
                        @csrf
                        <div class="card-body pb-0">
                            <div class="form-group uploadImage">
                                <label for="imageField">@lang("site.ProImage")</label>
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
                            <div class="d-flex flex-row justify-content-between flex-wrap">
                                <div class="form-group col-md-4 col-sm-5 p-0">
                                    <label for="purchase_price">@lang("site.purchase_price")</label>
                                    <input type="number" class="form-control" id="purchase_price"
                                           placeholder="@lang("site.purchase_price")" value="{{old("purchase_price")}}"
                                           name="purchase_price"
                                    >
                                </div>
                                <div class="form-group col-md-4 px-md-3 col-sm-5 px-0">
                                    <label for="sell_price">@lang("site.sell_price")</label>
                                    <input type="number" class="form-control" id="sell_price"
                                           placeholder="@lang("site.sell_price")" value="{{old("sell_price")}}"
                                           name="sell_price"
                                    >
                                </div>
                                <div class="form-group col-md-4 col-12 p-0">
                                    <label for="stock">@lang("site.stock")</label>
                                    <input type="number" class="form-control" id="stock"
                                           placeholder="@lang("site.stock")" value="{{old("stock")}}" name="stock"
                                    >
                                </div>
                            </div>
                            <div class="form-group">
                                <label>@lang("site.category")</label>
                                <select class="custom-select" name="category">
                                    @if(count($categories) > 0)
                                        <option>@lang("site.select_cat")</option>
                                    @endif
                                    @foreach($categories as $category)
                                        <option
                                            value="{{$category->id}}" {{old("category") == $category->id ? "selected" : null}}>{{$category->name." ( ".$category->products->count()." )"}}</option>
                                    @endforeach
                                </select>

                            </div>
                            @foreach(config("translatable.locales") as $locale)
                                <div class="form-group">
                                    <label for="exampleInputFName">@lang("site.".$locale.".name")</label>
                                    <input type="text" class="form-control" id="exampleInputFName"
                                           name="{{$locale}}[name]"
                                           placeholder="@lang("site.ProName")"
                                           value="{{old($locale.".name")}}">
                                </div>
                            @endforeach
                            @foreach(config("translatable.locales") as $locale)
                                <div class="form-group">
                                    <label>@lang("site.".$locale.".desc")</label>
                                    <textarea class="form-control ckeditor" name="{{$locale}}[desc]" rows="3"
                                              placeholder="@lang("site.ProDesc")">{{old($locale.".desc")}}</textarea>
                                </div>
                            @endforeach
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
    <!-- ckeditor5 -->
    <script src="{{ asset('dashboard/plugins/ckeditor5/ckeditor.js') }}"></script>
    @if(App::getLocale() !== "en")
        <script src="{{ asset('dashboard/plugins/ckeditor5/translations/'.App::getlocale().'.js') }}"></script>
    @endif

    <script>
        imageField.onchange = evt => {
            const [file] = imageField.files
            if (file) {
                imagePlace.src = URL.createObjectURL(file)
            }
        }
        document.querySelectorAll(".ckeditor").forEach((x) => {
            ClassicEditor
                .create(x, {
                    language: "{{App::getLocale()}}"
                })
                .then(editor => {
                    console.log(editor);
                })
                .catch(error => {
                    console.error(error);
                });
        })
    </script>
@endsection
