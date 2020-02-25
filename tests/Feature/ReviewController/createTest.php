<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseTransactions; 
use App\User;
use App\Review;

class ReviewCreateTest extends TestCase
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
            'title' => 'ほげほげ',
            'category_id' => 1,
            'body' => 'ほげほげです。テストです。',
        ];
    }
    
    /**
     * レビュー投稿処理：正常系
     *
     * @return void
     */
    public function testNormalCreate()
    {
        // レビュー投稿
        $response = $this->post('/review/save', $this->attributes);

        // リダイレクトされるか
        $response->assertStatus(302)->assertRedirect('/');
        
        /**
        * 画面観点
        */
        // ホーム画面に登録したデータが存在するか
        $this->get('/')
            ->assertSee($this->attributes['title'])
            ->assertSee($this->attributes['body']);
        
        /**
        *　データ観点
        */
        // DBに登録されているか
        $this->assertDatabaseHas('reviews', $this->attributes);
    }
    
    /**
     * TODO : レビュー投稿処理：異常系
     *
     * @return void
     */
    // public function testAbnormalCreate()
    // {

    // }
}
