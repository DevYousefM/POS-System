<div class="card mt-1 p-1 pt-0">
    <div class="print-area">
        <table class="table table-bordered orderProductTable">
            <thead>
            <tr>
                <th>@lang("site.name")</th>
                <th>@lang("site.quantity")</th>
                <th>@lang("site.price")</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{$product->name}}</td>
                    <td>{{$product->pivot->quantity}}</td>
                    <td>{{number_format($product->pivot->quantity * $product->sell_price , 2)}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex flex-wrap justify-content-between">
            <h5>@lang("site.clientName") : <span>{{$order->client->name}}</span></h5>
            <h5>@lang("site.created_at") : <span>{{$order->created_at->toFormattedDateString()}}</span></h5>
            @if($order->discount > 0)
                <h3>@lang("site.discount") : <span>{{$order->discount}} جنية</span></h3>
                <h3>@lang("site.totalAfterDis") :
                    <span>{{number_format($order->total_price - $order->discount , 2)}} جنية</span></h3>
            @else
                <h3>@lang("site.total") : <span>{{number_format($order->total_price , 2)}} جنية</span></h3>
            @endif

        </div>

    </div>
    <button class="btn btn-block btn-primary print-btn"><i class="fa fa-print"></i> @lang("site.print") </button>
</div>
<script>
    $(".print-btn").on("click", function () {
        $(this).prev().print();
    })
</script>
