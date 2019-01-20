<?php

namespace App\Http\Controllers;


use App\Models\Governorate;
use Illuminate\Http\Request;

class GovernorateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Governorate::paginate(20);
        return view('governorates.index',compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('governorates.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required'
        ];
        $messages = [
            'name.required' => 'Name is required'
        ];
        $this->validate($request,$rules,$messages);
        /*$record = new Governerate;
        $record->name = $request->input('name');
        $record->save();*/
        $record = Governorate::create($request->all());
        flash()->success('<p style="text-align: center;font-weight: bolder">تــم اضــافة المحــافظة بنجــاح</p>');
        return redirect(route('governorates.index'));
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
        $model = Governorate::findOrFail($id);
        return view('governorates.edit',compact('model'));
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
        $record = Governorate::findOrFail($id);
        $record->update($request->all());
        flash()->success('<p class="text-center" style="font-size:14px; font-weight:900;font-family:"Helvetica Neue", Helvetica, Arial, sans-serif" >لقـــد تـــــــم التحــديــــــــث بنــجـــــــاح</p>');
        return redirect(route('governorates.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Governorate::findOrFail($id);
        if($record->cities()->count())
        {
            return back();
        }
        $record->delete();
        flash()->success('<p class="text-center" style="font-size:20px; font-weight:900;font-family:Arial" >تـــم الحــذف </p>');
        return back();
    }
}
