<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseTransactions; 
use App\User;
use App\Review;

class ReviewControllerTest extends TestCase
{
    use DatabaseTransactions;
    
    private $attributes;
    
    /**
     * レビュー投稿処理：正常系
     *
     * @return void
     */
    public function testCreateReview()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        
        $this->attributes = [
            'title' => 'ほげほげ',
            'category_id' => 1,
            'body' => 'ほげほげです。テストです。',
        ];
        
        $response = $this->post('/review/save', $this->attributes);

        // リダイレクトされるか
        $response->assertStatus(302)->assertRedirect('/');
        // DBに登録されているか
        $this->assertDatabaseHas('reviews', $this->attributes);
    }
    
    /**
     * TODO : レビュー投稿処理：異常系
     *
     * @return void
     */
    // public function testCreateReview()
    // {

    // }
}
