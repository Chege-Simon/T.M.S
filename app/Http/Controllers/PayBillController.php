<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Bill;
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
            'field' => ['in:expense_type,truck,date,amount']
        ]);
        
        $query = Bill::query();

        if(request('search')) {
            $query->Where('expense_type','LIKE','%'.request('search').'%')
            ->orWhere('truck','LIKE','%'.request('search').'%')
            ->orWhere('date','LIKE','%'.request('search').'%')
            ->orWhere('amount','LIKE','%'.request('search').'%');
        }
        if(request()->has(['field', 'direction'])) {
            $query->orderBy(request('field'), request('direction'));
        }
        // dd($query);
        return Inertia::render('BillsViews/Bills', [
            'bills' => $query->paginate(4)->withQueryString()
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
                'expense_type' => 'required|unique:bills|max:50',
                'truck' => 'required|max:50',
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
            'expense_type' => 'required|exists:bills',
            'truck' => 'required|max:50',
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
}
