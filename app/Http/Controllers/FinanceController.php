<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Bill;
use App\Models\Capital;
use App\Models\TrackRecord;
use Illuminate\Support\Facades\DB;
use Redirect;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class FinanceController extends Controller
{
    public function index()
    {
        date_default_timezone_set('Africa/Nairobi');
        $capitals = Capital::all();
        $track_records = TrackRecord::all();
        $bills = Bill::with('expense')->get();
        // $now = date('Y-m-d');
        $date = Carbon::now();
        $invoices = Invoice::whereYear('end',$date->year)
                            ->where('status','=','Paid')->get();

        // dd($invoices);
        return Inertia::render('FinancesViews/Reports',[
            'invoices' => $invoices,
            'capitals' => $capitals,
            'bills' => $bills,
            'track_records' => $track_records,
        ]);
    }
}
