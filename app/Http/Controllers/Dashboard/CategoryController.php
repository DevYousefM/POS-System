<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;


class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(["permission:categories_read"])->only("index");
        $this->middleware(["permission:categories_create"])->only("create");
        $this->middleware(["permission:categories_update"])->only("edit");
        $this->middleware(["permission:categories_delete"])->only("destroy");

    }

    public function index(Request $request): View
    {
        $categories = Category::when($request->search, function ($q) use ($request) {
            return $q->whereTranslationLike("name", "%" . $request->search . "%");
        })->paginate(15);

        return view("dashboard.categories.index", ["categories" => $categories]);

    }

    public function store(Request $request): RedirectResponse
    {

        $data = [];
        $rules = [];
        foreach (config("translatable.locales") as $locale) {
            $data[$locale] = $request->$locale;
            $rules[$locale . ".*"] = "required|unique:category_translations,name";
        };
        $request->validate($rules);
        Category::create($data);
        return redirect()->route("dash.categories.index")->with("success", __("site.success_C_category"));
    }

    public function create(): View
    {
        return view("dashboard.categories.create");
    }

    public function edit(Category $category): View
    {
        return view("dashboard.categories.edit", compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $rules = [];
        $data = [];
        foreach (config("translatable.locales") as $locale) {
            $rules[$locale . ".name"] = ["required", Rule::unique("category_translations", "name")->ignore($category->id, "category_id")];
            $data[$locale] = $request->$locale;
        };
        $request->validate($rules);

        $category->update($data);
        return redirect()->route("dash.categories.index")->with("success", __("site.success_E_category"));
    }

    public function destroy(Request $request, $category): RedirectResponse
    {
        Category::destroy($category);
        return redirect()->route("dash.categories.index")->with("success", __("site.success_D_category"));
    }
}
