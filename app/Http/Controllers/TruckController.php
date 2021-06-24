<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Truck;
use Illuminate\Support\Facades\DB;
use Redirect;
use Illuminate\Support\Facades\Validator;

class TruckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $trucks = Truck::all();

        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:number_plate,manufacturer,model']
        ]);
        
        $query = Truck::query();

        if(request('search')) {
            $query->where('number_plate','LIKE','%'.request('search').'%')
            ->orWhere('model','LIKE','%'.request('search').'%')
            ->orWhere('manufacturer','LIKE','%'.request('search').'%');
        }
        if(request()->has(['field', 'direction'])) {
            $query->orderBy(request('field'), request('direction'));
        }
        // dd($query);
        return Inertia::render('TruckViews/Trucks', [
            'trucks' => $query->paginate(4)->withQueryString()
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
        Truck::create(
            $request->validate([
                'number_plate' => 'required|unique:trucks|max:25',
                'manufacturer' => 'required|max:25',
                'model' => 'required|max:25',
                'color' => 'required|max:25',
            ])
        );
        return Redirect::route('trucks.index')->with('message', 'Truck Registered Successfully');
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
        $truck = null;
        try{
            $truck = Truck::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return Redirect::route('trucks.index')->with('error', 'Oops...Truck Does Not exist!', );
        }
        $request->validate([
            'number_plate' => 'required|exists:trucks',
            'manufacturer' => 'required|max:25',
            'model' => 'required|max:25',
            'color' => 'required|max:25',
        ]);
        $truck->update($request->all());
        return Redirect::route('trucks.index')->with('message', 'Truck Details Edited Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $truck = null;
        try{
            $truck = Truck::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return Redirect::route('trucks.index')->with('error', 'Oops...Truck Does Not exist!', );
        }
        $truck->delete();
        return Redirect::route('trucks.index')->with('message', 'Truck has been deleted!', );
    }
}
