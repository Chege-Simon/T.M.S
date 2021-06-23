<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Driver;
use Illuminate\Support\Facades\DB;
use Redirect;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
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
            'field' => ['in:name,phone_number,assigned_truck,allowances']
        ]);
        
        $query = Driver::query();

        if(request('search')) {
            $query->where('name','LIKE','%'.request('search').'%')
            ->orWhere('phone_number','LIKE','%'.request('search').'%')
            ->orWhere('assigned_truck','LIKE','%'.request('search').'%')
            ->orWhere('allowances','LIKE','%'.request('search').'%');
        }
        if(request()->has(['field', 'direction'])) {
            $query->orderBy(request('field'), request('direction'));
        }
        // dd($query);
        return Inertia::render('DriverViews/Drivers', [
            'drivers' => $query->paginate(4)->withQueryString()
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
        Driver::create(
            $request->validate([
                'name' => 'required|unique:drivers|max:25',
                'phone_number' => 'required|max:25',
                'assigned_truck' => 'required|max:25',
                'allowances' => 'max:25',
            ])
        );
        return Redirect::route('drivers.index')->with('message', 'Driver Registered Successfully');
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
        $driver = null;
        try{
            $driver = Driver::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return Redirect::route('drivers.index')->with('error', 'Oops...Driver Does Not exist!', );
        }
        $request->validate([
            'name' => 'required|max:25',
            'phone_number' => 'required|max:25',
            'assigned_truck' => 'required|max:25',
            'allowances' => 'max:25',
        ]);
        $driver->update($request->all());
        return Redirect::route('drivers.index')->with('message', 'Driver Details Edited Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $driver = null;
        try{
            $driver = Driver::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return Redirect::route('drivers.index')->with('error', 'Oops...Drivers Does Not exist!', );
        }
        $driver->delete();
        return Redirect::route('drivers.index')->with('message', 'Drivers has been deleted!', );
    }
}
