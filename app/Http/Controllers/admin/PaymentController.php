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

class PaymentController extends Controller
{
    public $route = 'admin/payment';
    public $view  = 'admin/payment.';
    public $moduleName = 'payment';

    public function index()
    {
        $moduleName = $this->moduleName;
        return view($this->view . 'index', compact('moduleName'));
    }

    public function getData(Request $request)
    {
        $query = Payment::with('invoice', 'customer');

        // Filter by invoice date
        if ($request->payment_datetime) {
            $dates = explode(' to ', $request->payment_datetime);

            if (count($dates) === 2) {
                // Range filter
                $start = Carbon::parse($dates[0])->startOfDay(); // 00:00:00
                $end = Carbon::parse($dates[1])->endOfDay();     // 23:59:59
                $query->whereBetween('payment_datetime', [$start, $end]);
            } else {
                // Single day filter
                $date = Carbon::parse($dates[0]);
                $query->where('payment_datetime', '>=', $date->copy()->startOfDay())
                    ->where('payment_datetime', '<=', $date->copy()->endOfDay());
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
        // Filter by payment_type
        if ($request->payment_type) {
            $query->where('payment_type', $request->payment_type);
        }

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('invoice_number', function ($row) {
                return $row->invoice ? $row->invoice->invoice_number : '-';
            })
            ->addColumn('customer_name', function ($row) {
                return $row->invoice && $row->invoice->customer ? $row->invoice->customer->name : '-';
            })
            ->addColumn('customer_mobile', function ($row) {
                return $row->invoice && $row->invoice->customer ? $row->invoice->customer->mobile : '-';
            })
            ->editColumn('payment_datetime', function ($row) {
                return $row->payment_datetime
                    ? Carbon::parse($row->payment_datetime)->format('d-m-Y H:i:s')
                    : '-';
            })
            ->addColumn('amount', function ($row) {
                return $row->amount;
            })
            ->addColumn('payment_type', function ($row) {
                return ucfirst($row->payment_type);
            })
            ->addColumn('remarks', function ($row) {
                return $row->remarks ?? '-';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('payment.edit', $row->id);
                $deleteUrl = route('payment.delete', $row->id);
                $btn = '';
                $btn .= '<button type="button" class="edit btn btn-primary btn-sm edit-payment-btn" 
                            data-id="' . $row->id . '">
                            <i class="ri-edit-line"></i> Edit
                        </button>';
                $btn .= '<button type="button" data-delete_url="' . $deleteUrl . '" class="edit btn btn-danger btn-sm" id="delete_model_btn" style="margin-left:5px;">
                        <i class="ri-delete-bin-line"></i> Delete
                     </button>';
                return $btn;
            })
            ->filterColumn('invoice_number', function ($query, $keyword) {
                $query->whereHas('invoice', function ($q) use ($keyword) {
                    $q->where('invoice_number', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('customer_name', function ($query, $keyword) {
                $query->whereHas('invoice.customer', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('customer_mobile', function ($query, $keyword) {
                $query->whereHas('invoice.customer', function ($q) use ($keyword) {
                    $q->where('mobile', 'like', "%{$keyword}%");
                });
            })
            ->rawColumns(['action'])
            ->order(function ($query) {
                $query->orderBy('id', 'desc');
            })
            ->make(true);
    }
    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        return response()->json($payment);
    }

    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->amount = $request->amount;
        $payment->payment_type = $request->payment_type;
        $payment->remarks = $request->remarks;
        $payment->save();

        return response()->json(['success' => true, 'message' => $this->moduleName . ' updated successfully!']);
    }

    public function delete($id)
    {
        Payment::find($id)->delete();
        return redirect($this->route)->with('success', $this->moduleName . ' deleted successfully!');;
    }
}
