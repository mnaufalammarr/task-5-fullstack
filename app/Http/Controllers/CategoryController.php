<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get category
        $category = Category::all();
        
         //return collection of articles as a resource
         return new ArticleResource(true, 'List Data Posts', $category);
    }

    /**
     * Store a newly created resource in storage.
     *
     *  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
        ]);
         //check if validation fails
         if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
         //create category
         $category = Category::create([
            'name'     => $request->name,
            'user_id' => auth()->id()
            
        ]);

        //return response
        return new ArticleResource(true, 'Data Category Berhasil Ditambahkan!', $category);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return new ArticleResource(true, 'Data Kategori Ditemukan!', $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        //update post without image
        $category->update([
            'name'     => $request->name,
        ]);

        return new ArticleResource(true, 'Data Kategori Diupdate!', $category);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
         //return response
         return new ArticleResource(true, 'Data Category Berhasil Dihapus!', null);
    }
}
