<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseTransactions; 
use App\User;

class ReviewControllerTest extends TestCase
{
    use DatabaseTransactions;
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateReview()
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
    
    public function testUpdateReview()
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
    
    public function testDeleteReview()
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
