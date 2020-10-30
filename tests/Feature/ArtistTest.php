<?php

namespace Tests\Feature;

use App\Models\Artist as Artist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArtistTest extends TestCase
{

    private $base_url = 'api/artists/';
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPostArtist()
    {
        $artist = Artist::factory()->make();
        $this->json('POST', $this->base_url, $artist->toArray(), ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJson($artist->toArray());
    }

    public function testGetArtist()
    {
        $artist = Artist::factory()->create();
        $this->json('GET', $this->base_url . $artist->id, [], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson($artist->toArray());
    }

    public function testDestroyArtist()
    {
        $artist = Artist::factory()->create();
        $this->json('DELETE', $this->base_url . $artist->id, $artist->toArray(), ['Accept' => 'application/json'])
            ->assertStatus(200);
        $deletedArtist = Artist::find($artist->id);
        $this->assertNull($deletedArtist);
    }
}
