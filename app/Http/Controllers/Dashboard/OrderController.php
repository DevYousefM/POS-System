<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware(["permission:orders_read"])->only("index");
        $this->middleware(["permission:orders_create"])->only("create");
        $this->middleware(["permission:orders_update"])->only("edit");
        $this->middleware(["permission:orders_delete"])->only("destroy");

    }

    public function index(Request $request)
    {
        $orders = Order::whereHas("client", function ($q) use ($request) {
            return $q->where("name", "like", "%" . $request->search . "%");
        })->latest()->paginate(15);
        return view("dashboard.orders.index", compact("orders"));
    }

    public function products(Order $order)
    {
        $products = $order->products;
        return view("dashboard.orders._products", compact("products", "order"));
    }

    public function destroy(Order $order)
    {

        foreach ($order->products as $product) {
            $product->update([
                "stock" => $product->stock + $product->pivot->quantity
            ]);
        }
        $order->delete();
        return redirect()->route("dash.orders.index")->with("success", __("site.success_D_order"));

    }
}
