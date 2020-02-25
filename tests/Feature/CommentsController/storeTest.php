<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Review;

class CommentsStoreTest extends TestCase
{
    use DatabaseTransactions;
    
    private $attributes;
    private $publisher;
    private $commenter;
    private $review_id;
    private $comment;

    public function setUp(): void
    {
        parent::setUp();
        
        $this->publisher = factory(User::class)->create();
        $this->commenter = factory(User::class)->create();
        $this->actingAs($this->publisher);
        
        $this->attributes = [
            'user_id' => $this->publisher->id,
            'title' => 'ほげほげ',
            'category_id' => 1,
            'body' => 'ほげほげです。テストです。',
        ];
        
        // レビュー投稿
        $this->review_id = Review::insertGetId($this->attributes);
        
        // 別ユーザでコメントを投稿
        $this->post('logout');
        $this->actingAs($this->commenter);
        
        $this->comment = [
            'review_id' => $this->review_id,
            'body' => 'コメントです。テストです。',
            'user_id' => $this->commenter->id,
        ];
    }    
    
    /**
     * コメント投稿：正常系
     *
     * @return void
     */
    public function testNormalStore()
    {
        $response = $this->post('/comment', $this->comment);

        // リダイレクトされるか
        $response->assertStatus(302)->assertRedirect('/show/'.$this->review_id);
        
        /**
        * 画面観点
        */
        // コメントが投稿されているか
        $this->get('/show/'.$this->review_id)
            ->assertSee($this->comment['body']);

        /**
        *　データ観点
        */
        // DBに登録されているか
        $this->assertDatabaseHas('comments', $this->comment);
    }
}
