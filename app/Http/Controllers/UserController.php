<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    public $route = 'users';
    public $view  = 'users.';
    public $moduleName = 'Users';
    public $datatableUrl = 'users/usersData';

    public function index(){

        $moduleName = $this->moduleName;
        return view($this->view.'index',compact('moduleName'));
    }

    public function create(){
        $moduleName = $this->moduleName;
        return view($this->view.'form',compact('moduleName'));
    }

    public function store(Request $request) {
        $user = new User();

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        //$user->status = $request->status;
        $user->save();

        return redirect($this->route);
    }
}
