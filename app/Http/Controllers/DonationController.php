<?php

namespace App\Http\Controllers;

use App\Models\BloodType;
use App\Models\City;
use App\Models\DonationRequest;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = DonationRequest::paginate(20);
        return view('donations.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bloodtypes = BloodType::pluck('name', 'id')->toArray();
        $cities = City::pluck('name', 'id')->toArray();
        return view('donations.create', compact('bloodtypes', 'cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bloodtypes = BloodType::pluck('name', 'id')->toArray();
        $cities = City::pluck('name', 'id')->toArray();
        $model = DonationRequest::findOrFail($id);
        return view('donations.edit', compact('model', 'bloodtypes', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'patient_name'     => 'required',
            'patient_age'      => 'required',
            'hospital_name'    => 'required',
            'hospital_address' => 'required',
            'blood_bags'       => 'required',
            'phone'            => 'required',
            'blood_type_id'    => 'required',
            'city_id'          => 'required',
            'notes'            => 'required',
        ];
        $this->validate($request, $rules);
        $record = DonationRequest::findOrFail($id);
        $record->update($request->all());
        flash()->success('<p style="text-align: center;font-weight: bolder">تــم التحديث</p>');
        return redirect(route('donations.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = DonationRequest::findOrFail($id);
        $record->delete();
        flash()->error('<p style="text-align: center;font-weight: bolder">تم الحــذف</p>');
        return back();
    }
}
