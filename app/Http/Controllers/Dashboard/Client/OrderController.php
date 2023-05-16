<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware(["permission:orders_read"])->only("index");
        $this->middleware(["permission:orders_create"])->only("create");
        $this->middleware(["permission:orders_update"])->only("edit");
        $this->middleware(["permission:orders_delete"])->only("destroy");

    }

    public function store(Request $request, Client $client)
    {
        $request->validate([
            "products" => "required|array",
            "discount" => "integer ",
        ]);
        $productsNotEnough = [];
        foreach ($request->products as $id => $quantity) {
            $product = Product::findOrFail($id);
            if ($product->stock < $quantity["quantity"]) {
                $productsNotEnough[] = $product->name;
            }
        }
        if (count($productsNotEnough) > 0) {
            return redirect()->back()->with("message", "( " . implode("/", $productsNotEnough) . " )" . __("site.stockNotEnough"));
        }
        $this->attach_order($request, $client);
        return redirect()->route("dash.orders.index")->with("success", __("site.success_C_order"));
    }

    private function attach_order($request, $client)
    {

        $total = 0;
        $order = $client->orders()->create();
        $order->products()->attach($request->products);
        foreach ($request->products as $id => $quantity) {
            $product = Product::findOrFail($id);
            $total += $product->sell_price * $quantity["quantity"];

            $product->update([
                "stock" => $product->stock - $quantity["quantity"],
            ]);
        }
        $order->update(["total_price" => $total, "discount" => $request->discount]);
    }

    public function create(Client $client): View
    {
        $categories = Category::with("products")->get();
        return view("dashboard.clients.orders.create", compact("client", "categories"));
    }

    public function update(Request $request, Client $client, Order $order)
    {
        $request->validate([
            "products" => "required|array",
        ]);
        $productsNotEnough = [];
        foreach ($request->products as $id => $quantity) {
            $product = Product::findOrFail($id);
            if ($order->products()->find($id)) {
                if ($product->stock + $order->products()->find($id)->pivot->quantity < $quantity["quantity"]) {
                    $productsNotEnough[] = $product->name;
                }
            }
        }
        if (count($productsNotEnough) > 0) {
            return redirect()->back()->with("message", "( " . implode("/", $productsNotEnough) . " )" . __("site.stockNotEnough"));
        }

        $this->delete_order($order);


        $this->attach_order($request, $client);
        return redirect()->route("dash.orders.index")->with("success", __("site.success_E_order"));
    }

    private function delete_order($order)
    {
        foreach ($order->products as $product) {
            $product->update([
                "stock" => $product->stock + $product->pivot->quantity
            ]);
        }
        $order->delete();

    }

    public function edit(Client $client, Order $order): View
    {
        $categories = Category::with("products")->get();
        return view("dashboard.clients.orders.edit", compact("client", "order", "categories"));
    }
}
