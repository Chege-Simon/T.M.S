<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Capital;
use Illuminate\Support\Facades\DB;
use Redirect;
use Illuminate\Support\Facades\Validator;

class CapitalController extends Controller
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
            'field' => ['in:asset_type,description,amount,date']
        ]);
        
        $query = Capital::query();

        if(request('search')) {
            $searchTerm = request('search');
            $query->where('asset_type','LIKE','%'.$searchTerm.'%')
            ->orWhere('description','LIKE','%'.$searchTerm.'%')
            ->orWhere('date','LIKE','%'.$searchTerm.'%')
            ->orWhere('amount','LIKE','%'.$searchTerm.'%');
        }
        if(request()->has(['field', 'direction'])) {
            $query->orderBy(request('field'), request('direction'));
        }
        // dd($query);
        return Inertia::render('CapitalViews/Capital', [
            'capitals' => $query->paginate(4)->withQueryString()
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
        Capital::create(
            $request->validate([
                'asset_type' => 'required|max:50',
                'description' => 'required|max:200',
                'date' => 'required',
                'amount' => 'required|integer',
            ])
        );
        return Redirect::route('capital.index')->with('message', 'Capital Added Successfully');
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
        $capital = null;
        try{
            $capital = Capital::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return Redirect::route('capital.index')->with('error', 'Oops...Capital Does Not exist!', );
        }
        $request->validate([
            'asset_type' => 'required|max:50',
            'description' => 'required|max:200',
            'date' => 'required',
            'amount' => 'required|integer',
        ]);
        $capital->update($request->all());
        return Redirect::route('capital.index')->with('message', 'Capital Details Edited Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $capital = null;
        try{
            $capital = Capital::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return Redirect::route('capital.index')->with('error', 'Oops...Captial Does Not exist!', );
        }
        $capital->delete();
        return Redirect::route('capital.index')->with('message', 'Captial has been deleted!', );
    }
}
