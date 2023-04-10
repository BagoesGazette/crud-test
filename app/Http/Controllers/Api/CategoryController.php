<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\ReturnResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    use ReturnResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lists = Category::searchable($request->search)->orderBy('id', 'desc')->paginate(10);

        if ($lists->isNotEmpty()) {
            return $this->success($lists, 'List Category berhasil ditampilkan');
        }else{
            return $this->notfound($lists, 'List Category gagal ditemukan');
        }
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
        $validate = Validator::make($request->all(), [
            'name'          => 'required|min:5|max:150|unique:categories,name',
            'is_publish'    => 'required'
        ]);

        if ($validate->fails()) {
            return $this->failed(null, $validate->errors());
        }else{
            $data = $request->all();
            $result = Category::create($data);

            if ($result) {
                return $this->success($data, 'Data category berhasil ditambahkan');
            }else{
                return $this->failed($data, 'Data category gagal ditambahkan');
            }
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
        $validate = Validator::make($request->all(), [
            "name"          => "required|min:5|max:150|unique:categories,name,{$id}",
            "is_publish"    => "required"
        ]);

        if ($validate->fails()) {
            return $this->failed(null, $validate->errors());
        }else{
            $data = $request->all();
            $detail = Category::find($id);
            if ($detail) {
                $result = $detail->update($data);

                if ($result) {
                    return $this->success($data, 'Data category berhasil diupdate');  
                }else{
                    return $this->failed($data, 'Data category gagal diupdate');  
                }
            }else{
                return $this->failed($data, 'Detail category gagal ditemukan');
            }
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
        $detail = Category::find($id);
        
        if ($detail) {
            $detail->delete();
            return $this->success($detail, 'Data category berhasil dihapus');  
        }else{
            return $this->failed($detail, 'Data category tidak ditemukan');  
        }
    }
}
