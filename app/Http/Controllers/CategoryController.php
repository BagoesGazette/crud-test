<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lists = Category::searchable($request->search)->orderBy('id', 'desc')->paginate(10);

        return view('category.index', compact('lists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|min:5|max:150|unique:categories,name',
            'is_publish'    => 'required'
        ]);

        try{

            Category::create([
                'name'          => $validated['name'],
                'is_publish'    => $validated['is_publish'],
            ]);

            $notification = array(
                'success'   => 'Berhasil tambah category '.$validated['name']
            );

            return redirect()->route('category.index')->with($notification);

        } catch (\Throwable $e) {
            return redirect()->route('category.index')->with(['error' => 'Tambah data gagal! ' . $e->getMessage()]);
        }
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
        $detail = Category::find($id);

        return view('category.edit', compact('detail'));
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
        $validated = $request->validate([
            "name"          => "required|min:5|max:150|unique:categories,name,{$id}",
            "is_publish"    => "required"
        ]);

        try{

            $detail = Category::find($id);
            $detail->update([
                'name'          => $validated['name'],
                'is_publish'    => $validated['is_publish'],
            ]);

            $notification = array(
                'success'   => 'Berhasil update category '.$validated['name']
            );

            return redirect()->route('category.index')->with($notification);

        } catch (\Throwable $e) {
            return redirect()->route('category.index')->with(['error' => 'Update data gagal! ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Category::find($id)->delete();

            return response()->json(['status' => 'success']);
        } catch (\Throwable $e) {

            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
