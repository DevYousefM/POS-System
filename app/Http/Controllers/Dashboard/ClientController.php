<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{

    public function __construct()
    {
        $this->middleware(["permission:clients_read"])->only("index");
        $this->middleware(["permission:clients_create"])->only("create");
        $this->middleware(["permission:clients_update"])->only("edit");
        $this->middleware(["permission:clients_delete"])->only("destroy");

    }

    public function index(Request $request): View
    {
        $clients = Client::when($request->search, function ($q) use ($request) {
            return $q->where("name", "like", "%" . $request->search . "%")
                ->orWhere("national_id", "like", "%" . $request->search . "%")
                ->orWhere("phone", "like", "%" . $request->search . "%");
        })->latest()->paginate(15);

        return view("dashboard.clients.index", ["clients" => $clients]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            "name" => "required|string",
            "national_id" => "required|unique:clients",
            "phone" => "required|numeric|min:10",
            "address" => "required",
        ]);
        Client::create([
            "name" => $request->name,
            "national_id" => $request->national_id,
            "phone" => $request->phone,
            "address" => $request->address,
        ]);
        return redirect()->route("dash.clients.index")->with("success", __("site.success_C_client"));
    }

    public function create(): View
    {
        return view("dashboard.clients.create");
    }

    public function edit(Client $client): View
    {
        return view("dashboard.clients.edit", compact('client'));
    }


    public function update(Request $request, Client $client): RedirectResponse
    {
        $request->validate([
            "name" => "required|string",
            "national_id" => ["required", Rule::unique("clients", "national_id")->ignore($client->national_id, "national_id")],
            "phone" => "required|numeric|min:10",
            "address" => "required",
        ]);
        $client->update([
            "name" => $request->name,
            "national_id" => $request->national_id,
            "phone" => $request->phone,
            "address" => $request->address,
        ]);
        return redirect()->route("dash.clients.index")->with("success", __("site.success_E_client"));
    }

    public function destroy(Request $request, $client): RedirectResponse
    {
        Client::destroy($client);
        return redirect()->route("dash.clients.index")->with("success", __("site.success_D_client"));
    }
}
