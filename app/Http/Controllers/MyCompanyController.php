<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\MyCompany;
use Illuminate\Support\Facades\DB;
use Redirect;
use Illuminate\Support\Facades\Validator;

class MyCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = MyCompany::query();
        return Inertia::render('CompanyViews/MyCompanies', [
            'companies' => $query->paginate(30)->withQueryString()
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
        MyCompany::create(
            $request->validate([
                'name' => 'required|unique:my_companies|max:25',
                'phone_number' => 'required|max:25',
                'email' => 'required|email',
                'address' => 'required|max:150',
                'bank_account' => 'max:220',
            ])
        );
        return Redirect::route('my-companies.index')->with('message', 'Company Registered Successfully');
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
        $company = null;
        try{
            $company = MyCompany::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return Redirect::route('my-companies.index')->with('error', 'Oops...Company Does Not exist!', );
        }
        $request->validate([
            'name' => 'required|exists:my_companies',
            'phone_number' => 'required|max:25',
            'email' => 'required|email',
            'address' => 'required|max:150',
            'bank_account' => 'max:220',
        ]);
        $company->update($request->all());
        return Redirect::route('my-companies.index')->with('message', 'Company Details Edited Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = null;
        try{
            $company = MyCompany::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return Redirect::route('my-companies.index')->with('error', 'Oops...Company Does Not exist!', );
        }
        $company->delete();
        return Redirect::route('my-companies.index')->with('message', 'Company has been deleted!', );
    }
}
