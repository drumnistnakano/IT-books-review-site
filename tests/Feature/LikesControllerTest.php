<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LikesControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testApplyLike()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    
    public function testClearLike()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
