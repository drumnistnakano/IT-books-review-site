<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentsControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateComment()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    
    public function testHiddenComment()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
