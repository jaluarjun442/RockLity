<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public $route = 'admin/invoice';
    public $view  = 'admin/invoice.';
    public $moduleName = 'invoice';

    public function index()
    {
        $moduleName = $this->moduleName;
        return view($this->view . 'index', compact('moduleName'));
    }

    public function getData()
    {
        $query = Invoice::with('customer');
        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('customer_name', function ($row) {
                return $row->customer ? $row->customer->name : '-';
            })
            ->addColumn('customer_mobile', function ($row) {
                return $row->customer ? $row->customer->mobile : '-';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('invoice.edit', $row->id);
                $deleteUrl = route('invoice.delete', $row->id);
                $btn = '';
                $btn .= '<a href="' . $editUrl . '" class="edit btn btn-primary btn-sm" style="margin-left:5px;"><i class="ri-edit-line"></i> Edit</a>';
                $btn .= '<button type="button" data-delete_url="' . $deleteUrl . '" class="edit btn btn-danger btn-sm" id="delete_model_btn" name="delete_model_btn" style="margin-left:5px;"> <i class="ri-delete-bin-line"></i> Delete</button>';
                return $btn;
            })
            ->editColumn('is_paid', function ($row) {
                return $row->is_paid == 1 ? 'Yes' : 'No';
            })
            ->rawColumns(['action'])
            ->order(function ($query) {
                $query->orderBy('id', 'desc');
            })
            ->make(true);
    }
    public function ajaxCustomers(Request $request)
    {
        $search = $request->search;
        $query = Customer::query()
            ->where('is_active', 1)
            ->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->limit(10)
            ->get(['id', 'name', 'mobile']);
        return response()->json($query);
    }

    public function ajaxProducts(Request $request)
    {
        $search = $request->search;
        $query = Product::query()
            ->where('status', 1)
            ->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            })
            ->limit(10)
            ->get(['id', 'name', 'price']);
        return response()->json($query);
    }

    public function create()
    {
        $moduleName = $this->moduleName;
        $customers = \App\Models\Customer::where('is_active', 1)->orderBy('name')->get();
        $products = \App\Models\Product::where('status', 1)->orderBy('name')->get();

        return view($this->view . 'form', compact('moduleName', 'customers', 'products'));
    }


    public function store(Request $request)
    {
        dd($request->all());

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
