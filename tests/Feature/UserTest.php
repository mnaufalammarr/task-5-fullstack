<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_register()
    {
        $response = $this->json('POST', '/api/v1/register', [
            'name'  =>  $name = 'Test',
            'email'  =>  $email = time().'test@example.com',
            'password'  =>  $password = '123456789',
        ]);

        //Write the response in laravel.log
        Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);

        // Receive our token
        $this->assertArrayHasKey('token',$response->json());

    }

    public function test_login()
    {
       // Creating Users
       User::create([
        'name' => 'Test',
        'email'=> $email = time().'@example.com',
        'password' => $password = bcrypt('123456789')
        ]);
        // Simulated landing
        $response = $this->json('POST','/api/v1/login',[
            'email' => $email,
            'password' => $password,
        ]);

        //Write the response in laravel.log
        Log::info(1, [$response->getContent()]);

        // Determine whether the login is successful and receive token 
        $response->assertStatus(200); 
        // Delete users
        User::where('email','test@gmail.com')->delete();
    }
}
