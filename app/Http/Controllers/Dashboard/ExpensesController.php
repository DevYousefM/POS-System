<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Expense;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    public function index(Request $request)
    {
        $expenses = Expense::when($request->search, function ($q) use ($request) {
            return $q->whereTranslationLike("name", "%" . $request->search . "%");
        })->paginate(15);
        return view("dashboard.expenses.index", compact("expenses"));
    }

    public function store(Request $request)
    {
        $data = ["value" => $request->value];
        $rules = ["value" => "required|integer"];

        foreach (config("translatable.locales") as $locale) {
            $data[$locale] = $request->$locale;
            $rules[$locale . ".reason"] = "required|string|min:5";
        };
        $request->validate($rules);
        Expense::create($data);
        return redirect()->back();
    }

    public function dailyExpenses()
    {
        $expenses = Expense::whereDate("created_at", Carbon::today())->latest()->paginate(15);
        $dailyExpenses = true;
        return view("dashboard.expenses.index", compact("expenses", "dailyExpenses"));
    }

    public function monthlyExpenses()
    {
        $expenses = Expense::whereMonth("created_at", Carbon::now()->month)->latest()->paginate(15);
        $monthlyExpenses = true;
        return view("dashboard.expenses.index", compact("expenses", "monthlyExpenses"));
    }
}
