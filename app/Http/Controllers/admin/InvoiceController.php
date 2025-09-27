<?php

namespace App\Http\Controllers\admin;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Payment;
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

    public function getData(Request $request)
    {
        $query = Invoice::with('customer');
        if ($request->due_date) {
            $date = Carbon::createFromFormat('Y-m-d', $request->due_date);
            $query->whereDate('due_date', $date);
        }
        if ($request->invoice_datetime) {
            $dates = explode(' to ', $request->invoice_datetime);
            if (count($dates) === 2) {
                $start = Carbon::createFromFormat('Y-m-d', $dates[0])->startOfDay();
                $end = Carbon::createFromFormat('Y-m-d', $dates[1])->endOfDay();
                $query->whereBetween('invoice_datetime', [$start, $end]);
            } else {
                $date = Carbon::createFromFormat('Y-m-d', $dates[0]);
                $query->whereDate('invoice_datetime', $date);
            }
        }

        if ($request->customer_id) {
            $query->where('customer_id', $request->customer_id);
        }

        if ($request->mobile) {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('mobile', 'like', "%{$request->mobile}%");
            });
        }

        if ($request->is_paid !== null && $request->is_paid !== '') {
            $query->where('is_paid', $request->is_paid);
        }

        if ($request->payment_type) {
            $query->where('payment_type', $request->payment_type);
        }
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
            ->editColumn('due_date', function ($row) {
                return $row->due_date
                    ? Carbon::parse($row->due_date)->format('d-m-Y')
                    : '-';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('invoice.edit', $row->id);
                $deleteUrl = route('invoice.delete', $row->id);
                $btn = '';
                $btn .= '<button type="button" class="btn btn-info btn-sm view-payment" data-id="' . $row->id . '">
                            <i class="ri-currency-line"></i> Payment
                        </button>';
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
            'due_date'        => 'nullable',
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
            'due_date'        => $validated['due_date'],
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
        if ($validated['is_paid'] == true) {
            Payment::create([
                'customer_id'           => $validated['customer_id'],
                'invoice_id'            => $invoice->id,
                'amount'                => $validated['grand_total'],
                'payment_datetime'      => Carbon::now(),
                'remarks'               => 'Payment Received On Invoice Create.',
                'payment_type'          => $validated['payment_type'],
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
            'due_date'        => 'nullable',
            'grand_total'     => 'required|numeric|min:0',
            'payment_type'    => 'required|string',
            'is_paid'         => 'required|boolean',
        ]);
        $is_paid = $validated['is_paid'];
        if ($is_paid == false) {
            $due_date = $validated['due_date'];
        } else {
            $due_date = null;
        }
        $invoice->update([
            'customer_id'     => $validated['customer_id'],
            'sub_total'       => $validated['sub_total'],
            'total_discount'  => $validated['total_discount'] ?? 0,
            'total_charge'    => $validated['total_charge'] ?? 0,
            'grand_total'     => $validated['grand_total'],
            'is_paid'         => $is_paid,
            'due_date'        => $due_date,
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

    // Load payment form with existing payments
    public function ajaxPaymentsData(Request $request)
    {
        $invoice = Invoice::with('payment')->findOrFail($request->invoice_id);
        $payments = $invoice->payment;
        return view($this->view . 'payment_form', compact('invoice', 'payments'));
    }

    // Add a new payment
    public function addPayment(Request $request)
    {
        $request->validate([
            'invoice_id' => 'required|exists:invoice,id',
            'amount' => 'required|numeric',
            'payment_type' => 'required|string'
        ]);
        $invoice = Invoice::findOrFail($request->invoice_id);

        $invoice->payment()->create([
            'customer_id'           => $invoice->customer_id,
            'invoice_id'            => $invoice->id,
            'amount'                => $request->amount,
            'payment_datetime'      => Carbon::now(),
            'remarks'               => $request->remarks,
            'payment_type'          => $request->payment_type,
        ]);
        if ($request->has('is_full_payment') && $request->is_full_payment == 1) {
            $invoice->update(['is_paid' => 1]);
            $invoice->update(['due_date' => null]);
        }
        return response()->json(['success' => true]);
    }

    public function delete($id)
    {
        Invoice::find($id)->delete();
        return redirect($this->route)->with('success', $this->moduleName . ' deleted successfully!');;
    }
}
