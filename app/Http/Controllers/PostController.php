<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $records = Post::where(function ($q) use ($request) {
            if ($request->name) {
                $q->where('name', 'LIKE', '%' . $request->name . '%');
            }
            if ($request->category_id) {
                $q->where('category_id', $request->input('category_id'));
            }
        })->paginate(10);
        return view('posts.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id')->toArray();
        return view('posts.create', compact('categories'));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
            'title'        => 'required',
            'content'      => 'required',
            'thumbnail'    => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id'  => 'required',
            'publish_date' => 'required',
        ));
        $post = new Post;
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->category_id = $request->input('category_id');
        $post->publish_date = $request->input('publish_date');

        if ($request->hasFile('thumbnail')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/posts/'; // upload path
            $logo = $request->file('thumbnail');
            $extension = $logo->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $logo->move($destinationPath, $name); // uploading file to given path
            $post->thumbnail = 'uploads/posts/' . $name;
            $post->save();
        }


        return redirect()->route('posts.index')
                         ->with('success', 'Item created successfully');
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
        $model = Post::findOrFail($id);
        return view('posts.edit', compact('model'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, array(
            'title'        => 'required',
            'content'      => 'required',
            'thumbnail'    => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id'  => 'required',
            'publish_date' => 'required',
        ));
        $record = Post::findOrFail($id);
        $record->update($request->except('thumbnail'));

        if ($request->hasFile('thumbnail')) {
            if(file_exists($record->thumbnail))
                unlink($record->thumbnail);
            $path = public_path();
            $destinationPath = $path . '/uploads/posts/'; // upload path
            $logo = $request->file('thumbnail');
            $extension = $logo->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $logo->move($destinationPath, $name); // uploading file to given path
            $record->thumbnail = 'uploads/posts/' . $name;
            $record->save();
        }


        flash()->success('تم التحديث بنجاح');
        return redirect('admin/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Post::find($id);
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
