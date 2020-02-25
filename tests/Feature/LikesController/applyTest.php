<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Review;
use App\Like;

class LikesApplyTest extends TestCase
{
    use DatabaseTransactions;
    
    private $attributes;
    private $user;
    private $like;
    private $review_id;

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

        // レビュー投稿
        $this->review_id = Review::insertGetId($this->attributes);

        $this->like = [
            'user_id' => $this->user->id,
            'review_id' => $this->review_id,
        ];
    }
    
    /**
     * いいね有効化：正常系
     *
     * @return void
     */
    public function testNormalApply()
    {
        $response = $this->post('/show/'.$this->review_id.'/likes');

        // リダイレクトされるか
        $response->assertStatus(302)->assertRedirect('/show/'.$this->review_id);
        
        /**
        * 画面観点
        */
        // いいねが有効かされているか

        /**
        *　データ観点
        */
        // DBに登録されているか
        $this->assertDatabaseHas('likes', $this->like);
    }
}
