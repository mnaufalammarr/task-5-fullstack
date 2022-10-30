<?php

namespace Tests\Feature;

use App\Models\Category;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class CategoryTest extends TestCase
{
    

    public function test_user_create_category()
    {
        //create user
        $user =User::create([
            'name' => 'Erita',
            'email' => 'erita@gmail.com',
            'password' => Hash::make('secret9874'),
        ]);
        //Authentication middleware user
        $this->actingAs($user, 'api');

        $category = [
            "name" => "Programming",
        ];

        //test endpoint
        $this->json('POST', 'api/v1/category', $category,['Accept' => 'application/json'])
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
        Category::create([
            'name' => 'Programming',
            'user_id'=>auth()->id()
        ]);
        Category::create([
            'name' => 'Web Design',
            'user_id'=>auth()->id()
        ]);

        //test endpoint
        $this->json('GET', 'api/v1/category',  ['Accept' => 'application/json'])
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


        //test endpoint
        $this->json('GET', 'api/v1/category/'. $category->id,[]  ,['Accept' => 'application/json'])
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
        $categoryUpdate = [
            'name' => 'Web Design',
            'user_id'=>auth()->id()
        ];

        //test endpoint
        $this->json('PUT', 'api/v1/category/'. $category->id,$categoryUpdate, [],  ['Accept' => 'application/json'])
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
        //test endpoint
        $this->json('DELETE', 'api/v1/category/'. $category->id,[]  ,['Accept' => 'application/json'])
            ->assertStatus(200);
    }
}
