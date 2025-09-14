<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Helper\Helper;
use App\Models\User;
use Illuminate\Http\Request;


class ProfileController extends Controller
{
    public $route = 'admin/profile';
    public $view  = 'admin/profile.';
    public $moduleName = 'profile';

    public function index()
    {
        $moduleName = $this->moduleName;
        $user = User::find(1);
        return view($this->view . 'index', compact('user', 'moduleName'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // 'mobile' => 'required|string|max:255',
            // 'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = auth()->user();
        $user->name = $request->name;
        // $user->mobile = $request->mobile;
        // $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect($this->route)->with('success', $this->moduleName . ' Updated successfully!');
    }
}
