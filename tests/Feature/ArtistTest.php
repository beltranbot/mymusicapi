<?php

namespace Tests\Feature;

use App\Models\Artist as Artist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArtistTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPostArtist()
    {
        $artist = Artist::factory()->make();
        $this->json('POST', 'api/artists', $artist->toArray(), ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJson($artist->toArray());
    }

    public function testGetArtist()
    {
        $artist = Artist::factory()->create();
        $databaseArtist = Artist::find(1);
        $this->assertJson($artist->toJson(), $databaseArtist->toJson());
    }
}
