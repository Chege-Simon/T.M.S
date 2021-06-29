<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\Expense;
use App\Models\Truck;
use Illuminate\Support\Facades\DB;
use Redirect;;

class PayBillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:expense_id,truck_id,date,amount']
        ]);
        
        $query = Bill::query()->with('expense')->with('truck');
        $expenses = Expense::all();
        $trucks = Truck::all();

        if(request('search')) {
            $searchTerm = request('search');
            $query->Where('expense_id','LIKE',$this->searchExpense($searchTerm))
            ->orWhere('truck_id','LIKE',$this->searchTruck($searchTerm))
            ->orWhere('date','LIKE','%'.$searchTerm.'%')
            ->orWhere('amount','LIKE','%'.$searchTerm.'%');
        }
        if(request()->has(['field', 'direction'])) {
            $query->orderBy(request('field'), request('direction'));
        }
        // dd($query);
        return Inertia::render('BillsViews/Bills', [
            'bills' => $query->paginate(30)->withQueryString(),
            'trucks' => $trucks,
            'expenses' => $expenses,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Bill::create(
            $request->validate([
                'expense_id' => 'required|exists:expenses,id',
                'truck_id' => 'required|exists:trucks,id',
                'date' => 'required',
                'amount' => 'required|integer',
            ])
        );
        return Redirect::route('bills.index')->with('message', 'Bill Registered Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bill = null;
        try{
            $bill = Bill::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return Redirect::route('bills.index')->with('error', 'Oops...Bill Does Not exist!', );
        }
        $request->validate([
            'expense_type_id' => 'required|exists:expenses,id',
            'truck_id' => 'required|exists:trucks,id',
            'date' => 'required',
            'amount' => 'required|integer',
        ]);
        $bill->update($request->all());
        return Redirect::route('bills.index')->with('message', 'Bill Details Edited Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bill = null;
        try{
            $bill = Bill::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return Redirect::route('bills.index')->with('error', 'Oops...Bill Does Not exist!', );
        }
        $bill->delete();
        return Redirect::route('bills.index')->with('message', 'Bill has been deleted!', );
    }
    // custom functions
    public function searchTruck($number_plate)
    {
        $truck = Truck::where('number_plate','LIKE','%'.$number_plate.'%')->first();
        $id = '';
        if($truck != null){
            $id = $truck->id;
        }
        return $id;
    }
    public function searchExpense($name)
    {
        $expense = Expense::where('expense_type','LIKE','%'.$name.'%')->first();
        $id = '';
        if($expense != null){
            $id = $expense->id;
        }
        return $id;
    }
}
