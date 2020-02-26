<?php

namespace Tests\Feature\ReviewController;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Review;

class ReviewUpdateTest extends TestCase
{
    use DatabaseTransactions;
    
    private $attributes;
    private $updateAttributes;
    private $user;
    
    // TODO : 画像ありの場合のテスト
    public function setUp(): void
    {
        parent::setUp();
        
        $this->user = factory(User::class)->create();
        $this->actingAs($this->user);
        
        // 更新前データ
        $this->attributes = [
            'user_id' => $this->user->id,
            'title' => 'ほげほげ',
            'category_id' => 1,
            'body' => 'ほげほげです。テストです。',
        ];
        
        // 更新後データ
        $this->updateAttributes = [
            'user_id' => $this->user->id,
            'title' => '更新データだよ',
            'category_id' => 2,
            'body' => '更新データだよ。テストです。',
        ];
    }
    
    /**
     * レビュー更新：正常系
     *
     * @return void
     */
    public function testNormalUpdate()
    {
        // レビュー投稿
        $review_id = Review::insertGetId($this->attributes);
        // レビュー更新
        $response = $this->post('/review/edit/'.$review_id, $this->updateAttributes);

        // リダイレクトされるか
        $response->assertStatus(302)->assertRedirect('/show/'.$review_id);
        
        /**
        * 画面観点
        */
        // 詳細画面の文言は更新後データになっているか
        $this->get('/show/'.$review_id)
            ->assertSee('レビュー詳細')
            ->assertSee($this->updateAttributes['title'])
            ->assertSee($this->attributes['body']);
        // 詳細画面の文言は更新後データになっているか
        $this->get('/show/'.$review_id)
            ->assertSee('レビュー詳細')
            ->assertDontSee($this->attributes['title'])
            ->assertDontSee($this->attributes['body']);
        
        /**
        * データ観点
        */
        // DBは更新されているか
        $this->assertDatabaseHas('reviews', $this->updateAttributes);
        // 更新前のデータは存在しないか
        $this->assertDatabaseMissing('reviews', $this->attributes);
    }
}
