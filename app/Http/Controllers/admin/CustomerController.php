<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public $route = 'admin/customer';
    public $view  = 'admin/customer.';
    public $moduleName = 'customer';

    public function index()
    {
        $moduleName = $this->moduleName;
        return view($this->view . 'index', compact('moduleName'));
    }

    public function getData()
    {
        $query = Customer::query();
        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('image', function ($row) {
                if ($row->image) {
                    $url = asset('public/uploads/customer/' . $row->image);
                    return '<img src="' . $url . '" alt="Image" width="100" height="100">';
                }
                return '';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('customer.edit', $row->id);
                $deleteUrl = route('customer.delete', $row->id);
                $btn = '';
                $btn .= '<a href="' . $editUrl . '" class="edit btn btn-primary btn-sm" style="margin-left:5px;"><i class="ri-edit-line"></i> Edit</a>';
                $btn .= '<button type="button" data-delete_url="' . $deleteUrl . '" class="edit btn btn-danger btn-sm" id="delete_model_btn" name="delete_model_btn" style="margin-left:5px;"> <i class="ri-delete-bin-line"></i> Delete</button>';

                return $btn;
            })
            ->editColumn('status', function ($row) {
                return $row->status == 1 ? 'Active' : 'InActive';
            })
            ->rawColumns(['action', 'image'])
            ->order(function ($query) {
                $query->orderBy('id', 'desc');
            })
            ->make(true);
    }

    public function create()
    {
        $moduleName = $this->moduleName;
        return view($this->view . 'form', compact('moduleName'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'mobile'  => 'nullable|string|max:15',
            'email'   => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'gst'     => 'nullable|string|max:20',
            'pan'     => 'nullable|string|max:20',
            'is_active' => 'required|in:1,0',
        ]);
        $data = [
            'name'      => $request->name,
            'mobile'    => $request->mobile,
            'email'     => $request->email,
            'address'   => $request->address,
            'gst'       => $request->gst,
            'pan'       => $request->pan,
            'is_active' => $request->is_active,
            'created_by' => Auth::id(),
        ];

        Customer::create($data);

        return redirect($this->route)->with('success', $this->moduleName . ' added successfully!');
    }



    public function edit($id)
    {
        $moduleName = $this->moduleName;
        $customer = Customer::find($id);
        return view($this->view . '_form', compact('customer', 'moduleName'));
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        // Validation
        $request->validate([
            'name'    => 'required|string|max:255',
            'mobile'  => 'nullable|string|max:20',
            'email'   => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'gst'     => 'nullable|string|max:50',
            'pan'     => 'nullable|string|max:20',
            'is_active' => 'required|in:1,0',
        ]);

        $data = [
            'name'    => $request->name,
            'mobile'  => $request->mobile,
            'email'   => $request->email,
            'address' => $request->address,
            'gst'     => $request->gst,
            'pan'     => $request->pan,
            'is_active' => $request->is_active,
            'updated_by' => Auth::id(),
        ];

        $customer->update($data);

        return redirect($this->route)->with('success', $this->moduleName . ' updated successfully!');
    }


    public function delete($id)
    {
        Customer::find($id)->delete();
        return redirect($this->route)->with('success', $this->moduleName . ' deleted successfully!');;
    }
}
