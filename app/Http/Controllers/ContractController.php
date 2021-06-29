<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Contract;
use App\Models\MyCompany;
use Illuminate\Support\Facades\DB;
use Redirect;
use Illuminate\Support\Facades\Validator;


class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Contract::query()->with('company');
        return Inertia::render('ContractViews/Contracts', [
            'contracts' => $query->paginate(30)->withQueryString(),
            'companies' => MyCompany::all()
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
        // dd($request);
        Contract::create(
            $request->validate([
                'name' => 'required|unique:contracts|max:255',
                'description' => 'required|max:255',
                'company_id' => 'required|exists:my_companies,id',
                'date' => 'required',
                'period' => 'max:220',
                'terms' => 'required',
            ])
        );
        // dd($request);
        // Contract::create($request->all());
        return Redirect::route('contracts.index')->with('message', 'Contract Registered Successfully');
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
        $contract = null;
        try{
            $contract = Contract::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return Redirect::route('contracts.index')->with('error', 'Oops...Contract Does Not exist!', );
        }
        $request->validate([
            'name' => 'required|exists:contracts',
            'description' => 'required|max:255',
            'company_id' => 'required|exists:my_companies,id',
            'date' => 'required',
            'period' => 'max:220',
            'terms' => 'required',
        ]);
        $contract->update($request->all());
        return Redirect::route('contracts.index')->with('message', 'Contract Details Edited Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contract = null;
        try{
            $contract = Contract::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return Redirect::route('contracts.index')->with('error', 'Oops...Contract Does Not exist!', );
        }
        $contract->delete();
        return Redirect::route('contracts.index')->with('message', 'Contract has been deleted!', );
    }
}
