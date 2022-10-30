<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Resources\ArticleResource;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Contracts\Service\Attribute\Required;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //list article
    public function index()
    {
        //get article with pagination
        $article = Article::latest()->paginate(5);
        
         //return collection of articles as a resource
         return new ArticleResource(true, 'List Data Posts', $article);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    //create article to database
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title'     => 'required',
            'content'   => 'required',
            'category_id'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //check category_id 
        if (!(Category::where('id', $request->category_id)->exists())) {
            return response()->json([
                'message' => 'Category ID invalid',
            ], 400);
        }

        //upload image to folder public/articles
        $image = $request->file('image');
        $image->storeAs('public/article', $image->hashName());

        //create post
        $article = Article::create([
            'image'     => $image->hashName(),
            'title'     => $request->title,
            'content'   => $request->content,
            'user_id' => auth()->id(),
            'category_id'=> $request->category_id
        ]);

        //return response
        return new ArticleResource(true, 'Data Post Berhasil Ditambahkan!', $article);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    //show article
    public function show(Article $article)
    {
         //return single aricle as a resource
         return new ArticleResource(true, 'Data Article Ditemukan!', $article);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */

     //update article
    public function update(Request $request, Article $article)
    {
         //define validation rules
         $validator = Validator::make($request->all(), [
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title'     => 'required',
            'content'   => 'required',
            'category_id'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        //check category_id 
        if (!(Category::where('id', $request->category_id)->exists())) {
            return response()->json([
                'message' => 'Category ID invalid',
            ], 400);
        }
        //check if image is not empty
        if ($request->hasFile('image')) {

            //upload image
            $image = $request->file('image');
            $image->storeAs('public/article', $image->hashName());

            //delete old image
            Storage::delete('public/article/'.$article->image);

            //update post with new image
            $article->update([
                'image'     => $image->hashName(),
                'title'     => $request->title,
                'content'   => $request->content,
                'category_id'=> $request->category_id,
            ]);

        } else {

            //update post without image
            $article->update([
                'title'     => $request->title,
                'content'   => $request->content,
                'category_id'=> $request->category_id,
            ]);
        }

        //return response
        return new ArticleResource(true, 'Data Article Berhasil Diubah!', $article);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        //delete image
        Storage::delete('public/article/'.$article->image);

        //delete post
        $article->delete();

        //return response
        return new ArticleResource(true, 'Data Article Berhasil Dihapus!', null);
    }
}
