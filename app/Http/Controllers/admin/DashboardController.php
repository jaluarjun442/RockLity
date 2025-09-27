<?php

namespace App\Http\Controllers\admin;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use DataTables;

class DashboardController extends Controller
{
    public $route = 'admin/dashboard';
    public $view  = 'admin/dashboard.';
    public $moduleName = 'dashboard';

    public function index()
    {
        $moduleName = $this->moduleName;
        return view($this->view . 'index', compact('moduleName'));
    }
}
