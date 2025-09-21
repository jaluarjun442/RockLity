<?php

namespace App\Http\Controllers\admin;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Product;
use Carbon\Carbon;
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
            ->editColumn('invoice_datetime', function ($row) {
                return $row->invoice_datetime
                    ? Carbon::parse($row->invoice_datetime)->format('d-m-Y')
                    : '-';
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
            ->filterColumn('customer_name', function ($query, $keyword) {
                $query->whereHas('customer', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('customer_mobile', function ($query, $keyword) {
                $query->whereHas('customer', function ($q) use ($keyword) {
                    $q->where('mobile', 'like', "%{$keyword}%");
                });
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
        $customers = Customer::where('is_active', 1)->orderBy('name')->get();
        $products = Product::where('status', 1)->orderBy('name')->get();

        return view($this->view . 'form', compact('moduleName', 'customers', 'products'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id'     => 'required',
            'invoice_datetime' => 'required|date',
            'product_id'      => 'required|array|min:1',
            'product_id.*'    => 'required',
            'quantity.*'      => 'required|numeric|min:1',
            'price.*'         => 'required|numeric|min:0',
            'total.*'         => 'required|numeric|min:0',
            'sub_total'       => 'required|numeric|min:0',
            'total_discount'  => 'nullable|numeric|min:0',
            'total_charge'    => 'nullable|numeric|min:0',
            'grand_total'     => 'required|numeric|min:0',
            'payment_type'    => 'required|string',
            'is_paid'         => 'required|boolean',
        ]);

        $lastId = Invoice::max('id');
        $lastIdPadded = str_pad(($lastId + 1), 6, '0', STR_PAD_LEFT);
        $invoiceNumber = Helper::settings()['invoice_prefix'] . $lastIdPadded;
        $invoice = Invoice::create([
            'invoice_number'  => $invoiceNumber,
            'customer_id'     => $validated['customer_id'],
            'user_id'         => auth()->id(),
            'sub_total'       => $validated['sub_total'],
            'total_discount'  => $validated['total_discount'] ?? 0,
            'total_charge'    => $validated['total_charge'] ?? 0,
            'grand_total'     => $validated['grand_total'],
            'is_paid'         => $validated['is_paid'],
            'payment_type'    => $validated['payment_type'],
            'invoice_datetime' => $validated['invoice_datetime'],
            'created_by'      => auth()->id(),
        ]);

        foreach ($validated['product_id'] as $key => $productId) {
            $product = Product::find($productId);
            InvoiceProduct::create([
                'invoice_id'   => $invoice->id,
                'product_id'   => $productId,
                'product_name' => $product->name,
                'quantity'     => $validated['quantity'][$key],
                'price'        => $validated['price'][$key],
                'total'        => $validated['total'][$key],
            ]);
        }

        return redirect()->route('invoice')
            ->with('success', 'Invoice added successfully!');
    }

    public function edit($id)
    {
        $moduleName = $this->moduleName;
        $invoice = Invoice::with('invoice_product')->findOrFail($id);
        return view($this->view . '_form', compact('invoice', 'moduleName'));
    }

    public function update(Request $request, $id)
    {
        $invoice = Invoice::with('invoice_product')->findOrFail($id);

        $validated = $request->validate([
            'customer_id'     => 'required',
            'invoice_datetime' => 'required|date',
            'product_id'      => 'required|array|min:1',
            'product_id.*'    => 'required',
            'quantity.*'      => 'required|numeric|min:1',
            'price.*'         => 'required|numeric|min:0',
            'total.*'         => 'required|numeric|min:0',
            'sub_total'       => 'required|numeric|min:0',
            'total_discount'  => 'nullable|numeric|min:0',
            'total_charge'    => 'nullable|numeric|min:0',
            'grand_total'     => 'required|numeric|min:0',
            'payment_type'    => 'required|string',
            'is_paid'         => 'required|boolean',
        ]);

        $invoice->update([
            'customer_id'     => $validated['customer_id'],
            'sub_total'       => $validated['sub_total'],
            'total_discount'  => $validated['total_discount'] ?? 0,
            'total_charge'    => $validated['total_charge'] ?? 0,
            'grand_total'     => $validated['grand_total'],
            'is_paid'         => $validated['is_paid'],
            'payment_type'    => $validated['payment_type'],
            'invoice_datetime' => $validated['invoice_datetime'],
            'created_by'      => auth()->id(),
        ]);

        $invoice->invoice_product()->delete();

        foreach ($validated['product_id'] as $key => $productId) {
            $product = Product::find($productId);
            $invoice->invoice_product()->create([
                'product_id'   => $productId,
                'product_name' => $product->name,
                'quantity'     => $validated['quantity'][$key],
                'price'        => $validated['price'][$key],
                'total'        => $validated['total'][$key],
            ]);
        }

        return redirect($this->route)->with('success', $this->moduleName . ' updated successfully!');
    }


    public function delete($id)
    {
        Invoice::find($id)->delete();
        return redirect($this->route)->with('success', $this->moduleName . ' deleted successfully!');;
    }
}
