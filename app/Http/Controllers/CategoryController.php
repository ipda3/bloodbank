<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $records = Category::where(function ($q)use($request){
           if($request->name){
               $q->where('name', 'LIKE', '%' . $request->name . '%');
           }
        })->paginate(10);


        return view('categories.index',compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }


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
        $record = Category::create($request->all());
        flash()->success('تــم اضــافة القسم بنجــاح');
        return redirect(route('categories.index'));
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
        $model = Category::findOrFail($id);
        return view('categories.edit',compact('model'));
    }


    public function update(Request $request, $id)
    {
        $rules = [
                 'name' => 'required'
        ];
        $message = [
                  'name.required' => 'Name is required'
        ];
        $this->validate($request,$rules,$message);
        $record = Category::findOrFail($id);
        $record->update($request->all());
        flash()->success('تم التحديث بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Category::find($id);
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
