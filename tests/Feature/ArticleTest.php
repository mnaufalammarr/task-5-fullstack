<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ArticleTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_create_article()
    {
        //create user
        $user =User::create([
            'name' => 'Erita',
            'email' => 'erita@gmail.com',
            'password' => Hash::make('secret9874'),
        ]);
        //Authentication middleware user
        $this->actingAs($user, 'api');
        //create category
        $category = Category::create([
            'name' => 'Programming',
            'user_id'=>auth()->id()
        ]);
        Storage::fake('local');
        $file = UploadedFile::fake()->create('avatar.jpg');
        
        $article = [
            'title' => 'Article Programming',
            'content' => 'Programming Content',
            'image' => $file,
            'category_id' => $category->id,
        ];
        //test endpoint
        $this->json('POST', '/api/v1/article', $article,['Accept' => 'application/json'])
            ->assertStatus(201);
    }
    public function test_user_list_category()
    {
        //create user
        $user =User::create([
            'name' => 'Erita',
            'email' => 'erita@gmail.com',
            'password' => Hash::make('secret9874'),
        ]);
        //Authentication middleware user
        $this->actingAs($user, 'api');
        //create category
        $category = Category::create([
            'name' => 'Programming',
            'user_id'=>auth()->id()
        ]);
        Storage::fake('local');
        $file = UploadedFile::fake()->create('avatar.jpg');
        Article::create([
            "title" => "Article Programming",
            "content" => "Programming Content",
            "image" => $file,
            "category_id" => $category->id,
            "user_id" => auth()->id(),
        ]);

        //test endpoint
        $this->json('GET', 'api/v1/article',   ['Accept' => 'application/json'])
            ->assertStatus(200);
    }
    public function test_user_read_category()
    {
         //create user
         $user =User::create([
            'name' => 'Erita',
            'email' => 'erita@gmail.com',
            'password' => Hash::make('secret9874'),
        ]);
        //Authentication middleware user
        $this->actingAs($user, 'api');
        //create category
        $category = Category::create([
            'name' => 'Programming',
            'user_id'=>auth()->id()
        ]);
        Storage::fake('local');
        $file = UploadedFile::fake()->create('avatar.jpg');
        
        $article = Article::create([
            "title" => "Article Programming",
            "content" => "Programming Content",
            "image" => $file,
            "category_id" => $category->id,
            'user_id'=>auth()->id()
        ]);
        //test endpoint
        $this->json('GET', 'api/v1/article/'. $article->id  ,['Accept' => 'application/json'])
            ->assertStatus(200);
    }
    public function test_user_update_category()
    {
         //create user
         $user =User::create([
            'name' => 'Erita',
            'email' => 'erita@gmail.com',
            'password' => Hash::make('secret9874'),
        ]);
        //Authentication middleware user
        $this->actingAs($user, 'api');

        //create category
        $category = Category::create([
            'name' => 'Programming',
            'user_id'=>auth()->id()
        ]);

        Storage::fake('local');
        $file = UploadedFile::fake()->create('avatar.jpg');
        
        $article = Article::create([
            "title" => "Article Programming",
            "content" => "Programming Content",
            "image" => $file,
            "category_id" => $category->id,
            'user_id'=>auth()->id()
        ]);
        $articleUpdate =[
            "title" => "Update Article Programming",
            "content" => "Programming Content",
            "image" => $file,
            "category_id" => $category->id,
            'user_id'=>auth()->id()
        ];

        //test endpoint
        $this->json('PUT', 'api/v1/article/'. $article->id,$articleUpdate, [],  ['Accept' => 'application/json'])
            ->assertStatus(200);
    }
    public function test_user_delete_category()
    {
        //create user
        $user =User::create([
            'name' => 'Erita',
            'email' => 'erita@gmail.com',
            'password' => Hash::make('secret9874'),
        ]);
        //Authentication middleware user
        $this->actingAs($user, 'api');

        //create category
        $category = Category::create([
            'name' => 'Programming',
            'user_id'=>auth()->id()
        ]);
        Storage::fake('local');
        $file = UploadedFile::fake()->create('avatar.jpg');
        
        $article = Article::create([
            "title" => "Article Programming",
            "content" => "Programming Content",
            "image" => $file,
            "category_id" => $category->id,
            'user_id'=>auth()->id()
        ]);
        //test endpoint
        $this->json('DELETE', 'api/v1/article/'. $article->id,[]  ,['Accept' => 'application/json'])
            ->assertStatus(200);
    }
}
