<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Review;

class ReviewDeleteTest extends TestCase
{
    use DatabaseTransactions;
    
    private $attributes;
    private $user;
    
    public function setUp(): void
    {
        parent::setUp();
        
        $this->user = factory(User::class)->create();
        $this->actingAs($this->user);
        
        $this->attributes = [
            'user_id' => $this->user->id,
            'title' => 'ほげほげ',
            'category_id' => 1,
            'body' => 'ほげほげです。テストです。',
        ];
    }
    
    /**
     * レビュー削除：正常系
     *
     * @return void
     */
    public function testNormalDelete()
    {
        // レビュー投稿
        $review_id = Review::insertGetId($this->attributes);
        // レビュー削除
        $response = $this->post('/review/remove/'.$review_id);

        // リダイレクトされるか
        $response->assertStatus(302)->assertRedirect('/');
        
        /**
        * 画面観点
        */
        // ホーム画面に削除したデータが存在しないか
        $this->get('/')
            ->assertDontSee($this->attributes['title'])
            ->assertDontSee($this->attributes['body']);
        
        /**
        * データ観点
        */
        // DBから削除されているか
        $this->assertDatabaseMissing('reviews', $this->attributes);
    }
}
