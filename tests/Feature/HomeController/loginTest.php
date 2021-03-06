<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseTransactions; 
use App\User;

class LoginTest extends TestCase
{
    use DatabaseTransactions;
    
    /**
     * Login Test
     *
     * @return void
     */
    public function testLogin()
    {
        // ログイン認証なし
        $response = $this->get('/');
        $response->assertStatus(200)
            ->assertViewIs('index')
            ->assertSee('IT技術書レビューサイト');
        
        // ログイン認証あり
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200)
            ->assertViewIs('index')
            ->assertSee('IT技術書レビューサイト');
    }
}
