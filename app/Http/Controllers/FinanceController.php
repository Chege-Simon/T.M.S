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
        $date = Carbon::now();
        $capitals = Capital::where('date', 'LIKE', Carbon::today()->year."%")->get();
        $track_records = TrackRecord::with('truck')->with('region')->with('client')->where('date', 'LIKE', Carbon::today()->year."%")->get();
        $bills = Bill::with('expense')->with('truck')->where('date', 'LIKE', Carbon::today()->year."%")->get();
        // $now = date('Y-m-d');
        $invoices = Invoice::where('end', 'LIKE', Carbon::today()->year."%")
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
