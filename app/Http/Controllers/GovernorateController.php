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
    public function index(Request $request)
    {
        $records = Governorate::where(function ($q)use($request){
            $q->where('name','LIKE', '%' . $request->name . '%');
        })->paginate(10);
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


    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:governorates,name'
        ];
        $messages = [
            'name.required' => 'اسم المحافظة مطلوب',
            'name.unique' => 'هذا الاسم مستخدم بالفعل',
        ];
        $this->validate($request,$rules,$messages);

//        $record = new Governorate;
//        $record->name = $request->input('name');
//        $record->save();

        $record = Governorate::create($request->all());

        flash()->success("تم إضافة المدينة بنجاح");
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
        flash()->success("تم تعديل المدينة بنجاح");
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
        $record = Governorate::find($id);
        if (!$record) {
            return response()->json([
                'status'  => 0,
                'message' => 'تعذر الحصول على البيانات'
            ]);
        }
        if($record->cities()->count())
        {
            return response()->json([
                    'status' => 0,
                    'message' => 'لا يمكن الحذف, يوجد مدن مرتبطة بالمحافظة',
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
