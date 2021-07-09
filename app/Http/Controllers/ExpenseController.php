<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;
use Redirect;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
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
            'field' => ['in:expense_type,account']
        ]);
        
        $query = Expense::query();

        if(request('search')) {
            $query->Where('expense_type','LIKE','%'.request('search').'%')
            ->orWhere('account','LIKE','%'.request('search').'%');
        }
        if(request()->has(['field', 'direction'])) {
            $query->orderBy(request('field'), request('direction'));
        }
        // dd($query);
        return Inertia::render('ExpenseViews/Expenses', [
            'expenses' => $query->paginate(30)->withQueryString()
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
        Expense::create(
            $request->validate([
                'expense_type' => 'required|unique:expenses',
                'account' => 'required|max:50',
            ])
        );
        return Redirect::route('expenses.index')->with('message', 'Expense Registered Successfully');
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
        $expense = null;
        try{
            $expense = Expense::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return Redirect::route('expenses.index')->with('error', 'Oops...Expense Does Not exist!', );
        }
        $request->validate([
            'expense_type' => 'required',
            'account' => 'required|max:50',
        ]);
        $expense->update($request->all());
        return Redirect::route('expenses.index')->with('message', 'Expense Details Edited Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense = null;
        try{
            $expense = Expense::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return Redirect::route('expenses.index')->with('error', 'Oops...Expense Does Not exist!', );
        }
        $expense->delete();
        return Redirect::route('expenses.index')->with('message', 'Expense has been deleted!', );
    }
}
