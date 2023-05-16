<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Image;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(["permission:users_read"])->only("index");
        $this->middleware(["permission:users_create"])->only("create");
        $this->middleware(["permission:users_update"])->only("edit");
        $this->middleware(["permission:users_delete"])->only("destroy");

    }

    public function index(Request $request): View
    {
        $users = User::whereRoleIs("admin")->when($request->search, function ($query) use ($request) {
            return $query->where("first_name", "like", "%" . $request->search . "%")
                ->orWhere("last_name", "like", "%" . $request->search . "%");
        })->latest()->paginate(15);
        return view("dashboard.users.index", ["users" => $users]);
    }

    public function edit(User $user): View
    {
        return view("dashboard.users.edit", compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            "first_name" => "min:4",
            "last_name" => "min:4",
            "email" => ["required", Rule::unique("users")->ignore($user->id)],
            "permissions" => "required",

        ]);
        !empty($request->password) ? $request->validate([
            "password" => "min:4|confirmed"
        ]) : null;
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            Image::make($request->file('image'))->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $path = $request->file('image')->store("/user_images", 'public_uploads');
            !str_contains($user->image, "default") ? File::delete("uploads/$user->image") : null;
            $user->update(["image" => $path]);
        }
        $user->update([
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "email" => $request->email,
        ]);
        $request->password ? $user->update(["password" => Hash::make($request->password)]) : null;
        $user->syncPermissions($request->permissions);
        return redirect()->route("dash.users.index")->with("success", __("site.success_E_user"));
    }

    public function store(Request $request): RedirectResponse
    {
        // return gettype($request->permissions);
        $request->validate([
            "first_name" => "required|min:4",
            "last_name" => "required|min:4",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:4|confirmed",
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            "permissions" => "required",
        ]);
        if ($request->hasFile('image')) {
            Image::make($request->file('image'))->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $path = $request->file('image')->store("/user_images", 'public_uploads');
        }
        $user = User::create([
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);
        $request->hasFile('image') ? $user->image = $path : null;
        $user->save();
        $user->attachRole("admin");
        $user->syncPermissions($request->permissions);
        return redirect()->route("dash.users.index")->with("success", __("site.success_C_user"));
    }

    public function create(): View
    {
        return view("dashboard.users.create");
    }

    public function destroy(Request $request, $user): RedirectResponse
    {
        User::destroy($user);
        return redirect()->route("dash.users.index")->with("success", __("site.success_D_user"));
    }
}
