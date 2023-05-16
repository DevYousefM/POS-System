<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index()
    {
        $orders = Order::whereDate("created_at", Carbon::today())->count();
        $clients = Client::all()->count();
        $products = Product::all()->count();
        $categories = Category::all()->count();

        $sales_data_m = Order::select(DB::raw("SUM(total_price) as total_price"), DB::raw("MONTHNAME(created_at) as month"))
            ->whereYear("created_at", date("Y"))
            ->groupBy(DB::raw("month"))
            ->get();
        return view("dashboard.home", compact("sales_data_m", "orders", "products", "clients", "categories"));
    }

    public function trash()
    {
        $categories = Category::onlyTrashed()
            ->get();
        $products = Product::onlyTrashed()
            ->get();
        $clients = Client::onlyTrashed()
            ->get();
        return view("dashboard.trash.index", compact("categories", "clients", "products"));
    }

    public function restoreData($table, $id)
    {
        switch ($table) {
            case "categories":
                $category = Category::withTrashed()->findOrFail($id);
                $category->restore();
            case "products":
                $product = Product::withTrashed()->findOrFail($id);
                $product->restore();
            case "clients":
                $client = Client::withTrashed()->findOrFail($id);
                $client->restore();
        }
        return redirect()->back()->with("success", __("site.restored"));
    }

    public function forceDelete($table, $id)
    {
        switch ($table) {
            case "categories":
                $category = Category::withTrashed()->findOrFail($id);
                $category->forceDelete();
            case "products":
                $product = Product::withTrashed()->findOrFail($id);
                $product->forceDelete();
            case "clients":
                $client = Client::withTrashed()->findOrFail($id);
                $client->forceDelete();
        }
        return redirect()->back()->with("success", __("site.deleted"));
    }

    public function dailyInvoice(Request $request)
    {
        $orders = Order::whereDate("created_at", Carbon::today())->whereHas("client", function ($q) use ($request) {
            return $q->where("name", "like", "%" . $request->search . "%");
        })->latest()->paginate(15);
        $dailyInvoice = true;
        return view("dashboard.orders.index", compact("orders", "dailyInvoice"));
    }

    public function yearlyInvoice(Request $request)
    {
        $preYear = date("Y") - 1;
        $orders = Order::where('created_at', '>=', Carbon::now()->subdays(366))->whereHas("client", function ($q) use ($request) {
            return $q->where("name", "like", "%" . $request->search . "%");
        })->latest()->paginate(15);
        $yearlyInvoice = true;
        return view("dashboard.orders.index", compact("orders", "yearlyInvoice"));
    }
}
