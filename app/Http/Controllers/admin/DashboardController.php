<?php

namespace App\Http\Controllers\admin;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;

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
    public function invoiceChartData(Request $request)
    {
        $range = $request->get('range', 'last7days');
        $start = null;
        $end   = now();

        switch ($range) {
            case 'today':
                $start = now()->startOfDay();
                break;
            case 'last7days':
                $start = now()->subDays(6)->startOfDay();
                break;
            case 'thismonth':
                $start = now()->startOfMonth();
                break;
            case 'lastmonth':
                $start = now()->subMonth()->startOfMonth();
                $end = now()->subMonth()->endOfMonth();
                break;
            case 'thisyear':
                $start = now()->startOfYear();
                break;
            case 'lastyear':
                $start = now()->subYear()->startOfYear();
                $end = now()->subYear()->endOfYear();
                break;
            case 'custom':
                $start = $request->get('start_date') ? \Carbon\Carbon::parse($request->get('start_date'))->startOfDay() : now()->subDays(6);
                $end   = $request->get('end_date') ? \Carbon\Carbon::parse($request->get('end_date'))->endOfDay() : now();
                break;
        }

        $diffInDays = $start->diffInDays($end);
        $groupByMonth = in_array($range, ['thisyear', 'lastyear']) || $diffInDays > 60;

        $labels = [];
        $invoiceCounts = [];
        $invoiceAmounts = [];

        if ($groupByMonth) {
            $invoices = \App\Models\Invoice::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as period, COUNT(*) as total_count, SUM(grand_total) as total_amount')
                ->whereBetween('created_at', [$start, $end])
                ->groupBy('period')
                ->get()
                ->keyBy('period');

            $period = \Carbon\CarbonPeriod::create($start->copy()->startOfMonth(), '1 month', $end->copy()->endOfMonth());
            foreach ($period as $date) {
                $monthKey = $date->format('Y-m'); // key for data
                $labels[] = $date->format('M Y'); // friendly label e.g., "Sep 2025"
                $invoiceCounts[] = isset($invoices[$monthKey]) ? $invoices[$monthKey]->total_count : 0;
                $invoiceAmounts[] = isset($invoices[$monthKey]) ? $invoices[$monthKey]->total_amount : 0;
            }
        } else {
            // Daily grouping
            $invoices = \App\Models\Invoice::selectRaw('DATE(invoice_datetime) as date, COUNT(*) as total_count, SUM(grand_total) as total_amount')
                ->whereRaw("DATE(invoice_datetime) >= ?", [$start->toDateString()])
                ->whereRaw("DATE(invoice_datetime) <= ?", [$end->toDateString()])
                ->groupBy('date')
                ->get()
                ->keyBy('date');

            $current = $start->copy();
            while ($current <= $end) {
                $day = $current->format('Y-m-d'); // ISO date string
                $labels[] = $day;
                $invoiceCounts[] = isset($invoices[$day]) ? $invoices[$day]->total_count : 0;
                $invoiceAmounts[] = isset($invoices[$day]) ? $invoices[$day]->total_amount : 0;
                $current->addDay();
            }
        }

        return response()->json([
            'labels' => $labels,
            'invoiceCounts' => $invoiceCounts,
            'invoiceAmounts' => $invoiceAmounts,
        ]);
    }
    public function paymentChartData(Request $request)
    {
        $range = $request->get('range', 'last7days');
        $start = null;
        $end = now();

        switch ($range) {
            case 'today':
                $start = now()->startOfDay();
                break;
            case 'last7days':
                $start = now()->subDays(6)->startOfDay();
                break;
            case 'thismonth':
                $start = now()->startOfMonth();
                break;
            case 'lastmonth':
                $start = now()->subMonth()->startOfMonth();
                $end = now()->subMonth()->endOfMonth();
                break;
            case 'thisyear':
                $start = now()->startOfYear();
                break;
            case 'lastyear':
                $start = now()->subYear()->startOfYear();
                $end = now()->subYear()->endOfYear();
                break;
            case 'custom':
                $start = $request->get('start_date') ? \Carbon\Carbon::parse($request->get('start_date'))->startOfDay() : now()->subDays(6);
                $end = $request->get('end_date') ? \Carbon\Carbon::parse($request->get('end_date'))->endOfDay() : now();
                break;
        }

        $diffInDays = $start->diffInDays($end);
        $groupByMonth = in_array($range, ['thisyear', 'lastyear']) || $diffInDays > 60;

        if ($groupByMonth) {
            $payments = \App\Models\Payment::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as period, COUNT(*) as total_count, SUM(amount) as total_amount')
                ->whereBetween('created_at', [$start, $end])
                ->groupBy('period')
                ->get()
                ->keyBy('period');

            $labels = [];
            $paymentCounts = [];
            $paymentAmounts = [];
            $periods = \Carbon\CarbonPeriod::create($start->copy()->startOfMonth(), '1 month', $end->copy()->endOfMonth());

            foreach ($periods as $date) {
                $monthKey = $date->format('Y-m');
                $labels[] = $date->format('M Y');
                $paymentCounts[] = isset($payments[$monthKey]) ? $payments[$monthKey]->total_count : 0;
                $paymentAmounts[] = isset($payments[$monthKey]) ? $payments[$monthKey]->total_amount : 0;
            }
        } else {
            $payments = \App\Models\Payment::selectRaw('DATE(created_at) as date, COUNT(*) as total_count, SUM(amount) as total_amount')
                ->whereBetween('created_at', [$start, $end])
                ->groupBy('date')
                ->get()
                ->keyBy('date');

            $labels = [];
            $paymentCounts = [];
            $paymentAmounts = [];
            $periods = \Carbon\CarbonPeriod::create($start, $end);

            foreach ($periods as $date) {
                $day = $date->format('Y-m-d');
                $labels[] = $date->format('d M');
                $paymentCounts[] = isset($payments[$day]) ? $payments[$day]->total_count : 0;
                $paymentAmounts[] = isset($payments[$day]) ? $payments[$day]->total_amount : 0;
            }
        }

        return response()->json([
            'labels' => $labels,
            'paymentCounts' => $paymentCounts,
            'paymentAmounts' => $paymentAmounts
        ]);
    }
}
