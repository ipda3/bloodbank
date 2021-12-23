<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Governorate;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $records = City::where(function ($q) use ($request) {
            if ($request->name) {
                $q->where('name', 'LIKE', '%' . $request->name . '%');
            }
            if ($request->governorate_id) {
                $q->where('governorate_id', $request->input('governorate_id'));
            }
        })->paginate(10);
        return view('cities.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $governorates = Governorate::pluck('name', 'id')->toArray();
        return view('cities.create', compact('governorates'));
    }


    public function store(Request $request)
    {
        $rules = [
            'name'           => 'required|unique:cities,name',
            'governorate_id' => 'required'
        ];
        $message = [
            'name.required'           => 'الاسم مطلوب',
            'name.unique'             => 'اسم المدينة مستخدمة من قبل',
            'governorate_id.required' => 'المحافظة مطلوبة',
        ];
        $this->validate($request, $rules, $message);
        $record = City::create($request->all());
        flash()->success('تمت إضافة المدينة بنجاح');
        return redirect(route('cities.index'));
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
        $model = City::findOrFail($id);
        return view('cities.edit', compact('model'));
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
        $record = City::findOrFail($id);
        $record->update($request->all());
        flash()->success('تم التحديث بنجاح');
        return redirect(route('cities.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = City::find($id);
        if (!$record) {
            return response()->json([
                                        'status'  => 0,
                                        'message' => 'تعذر الحصول على البيانات'
                                    ]);
        }

        $record->delete();
        return response()->json([
                                    'status'  => 1,
                                    'message' => 'تم الحذف بنجاح',
                                    'id'      => $id
                                ]);
    }

}
