<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HelloWorldTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGet()
    {
        $this->json('GET', 'api/hello-world', [], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "message" => "Hello, World"
            ]);
    }

}
