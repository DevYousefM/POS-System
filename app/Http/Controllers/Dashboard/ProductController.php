<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Image;


class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(["permission:products_read"])->only("index");
        $this->middleware(["permission:products_create"])->only("create");
        $this->middleware(["permission:products_update"])->only("edit");
        $this->middleware(["permission:products_delete"])->only("destroy");

    }

    public function index(Request $request): View
    {
        $categories = Category::all();
        $products = Product::when($request->search, function ($query) use ($request) {
            return $query->whereTranslationLike("name", "%" . $request->search . "%");
        })->when($request->category, function ($query) use ($request) {
            if (is_numeric($request->category)) {
                return $query->where("category_id", $request->category);
            } else {
                return $query;
            }
        })->paginate(15);
        return view("dashboard.products.index", compact("products", "categories"));
    }

    public function edit(Product $product): View
    {
        $categories = Category::all();
        return view("dashboard.products.edit", compact("product", "categories"));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = [
            "purchase_price" => $request->purchase_price,
            "sell_price" => $request->sell_price,
            "stock" => $request->stock,
            "category_id" => $request->category,
        ];
        $rules = [
            'purchase_price' => "required|integer",
            "sell_price" => "required|integer",
            "stock" => "required|integer",
            "image" => "mimes:jpeg,png,jpg,gif,svg|max:2048",
            "category" => "required|exists:categories,id",
        ];
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            Image::make($request->file('image'))->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $path = $request->file('image')->store("/products", 'public_uploads');
            !str_contains($product->image, "default") ? File::delete("uploads/$product->image") : null;
            $data["image"] = $path;
        }
        foreach (config("translatable.locales") as $locale) {
            $rules[$locale . ".name"] = ["required", Rule::unique("product_translations", "name")->ignore($product->id, "product_id")];
            $rules[$locale . ".desc"] = "required";

            $data[$locale]["name"] = $request[$locale]["name"];
            $data[$locale]["desc"] = $request[$locale]["desc"];
        }
        $request->validate($rules);

        $product->update($data);
        return redirect()->route("dash.products.index")->with("success", __("site.success_E_product"));

    }

    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'purchase_price' => "required|integer",
            "sell_price" => "required|integer",
            "stock" => "required|integer",
            "image" => "mimes:jpeg,png,jpg,gif,svg|max:2048",
            "category" => "required|exists:categories,id",
        ];
        $data = [
            "purchase_price" => $request->purchase_price,
            "sell_price" => $request->sell_price,
            "stock" => $request->stock,
            "category_id" => $request->category
        ];

        foreach (config("translatable.locales") as $locale) {
            $rules[$locale . ".name"] = "required|unique:product_translations,name";
            $rules[$locale . ".desc"] = "required";

            $data[$locale]["name"] = $request[$locale]["name"];
            $data[$locale]["desc"] = $request[$locale]["desc"];
        };
        $request->validate($rules);

        if ($request->hasFile('image')) {
            Image::make($request->file('image'))->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $path = $request->file('image')->store("/products", 'public_uploads');
            $data["image"] = $path;
        }
        Product::create($data);
        return redirect()->route("dash.products.index")->with("success", __("site.success_C_product"));
    }

    public function create(): View
    {
        $categories = Category::all();
        return view("dashboard.products.create", compact("categories"));
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        Product::destroy($product->id);
        return redirect()->route("dash.products.index")->with("success", __("site.success_D_product"));
    }
}
