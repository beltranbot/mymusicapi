<?php

namespace Tests\Feature;

use App\Models\Album;
use App\Models\Artist as Artist;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArtistTest extends TestCase
{
    use WithFaker;

    private $base_url = 'api/artists/';

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

    public function testPutArtist()
    {
        $artist = Artist::factory()->create();
        $updatedArtist = Artist::factory()->make();
        $response = $this->json('PUT', $this->base_url . $artist->id, $updatedArtist->toArray(), ['Accept' => 'application/json'])
            ->assertStatus(200);
        $this->assertEquals($updatedArtist->name, $response["name"]);
    }

    public function testShouldBeAbleToUpdateTheSameIdData()
    {
        $artist = Artist::factory()->create();
        $response = $this->json('PUT', $this->base_url . $artist->id, $artist->toArray(), ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson($artist->toArray());
    }

    public function testArtistNameisRequiredValidation()
    {
        $artist = [];
        $this->json('POST', $this->base_url, $artist, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "name" => [
                        "The name field is required."
                    ]
                ]
            ]);
    }

    public function testArtistNameMustBeUnique()
    {
        $artist = Artist::factory()->create();
        $this->json('POST', $this->base_url, $artist->toArray(), ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "name" => [
                        "The name has already been taken."
                    ]
                ]
            ]);
    }

    public function testArtistNameLengthMustAtLeast2()
    {
        $artist = ['name' => 'a'];
        $this->json('POST', $this->base_url, $artist, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "name" => [
                        "The name must be at least 2 characters."
                    ]
                ]
            ]);
    }

    public function testArtistNameLengthMustNotBeGreaterThan50()
    {
        $artist = ['name' => $this->faker->regexify('[A-Za-z0-9]{51}')];
        $this->json('POST', $this->base_url, $artist, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "name" => [
                        "The name may not be greater than 50 characters."
                    ]
                ]
            ]);
    }

    public function testPutNonExistingArtistShouldReturn404()
    {
        $artist = Artist::factory()->make();
        $id = 1;
        $this->json('PUT', $this->base_url . $id, $artist->toArray(), ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJson([
                "message" => "NOT FOUND"
            ]);
    }

    public function testGetNonExistingArtistShouldReturn404()
    {
        $id = 1;
        $this->json('GET', $this->base_url . $id, [], ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJson([
                "message" => "NOT FOUND"
            ]);
    }

    public function testDeleteNonExistingArtistShouldReturn404()
    {
        $id = 1;
        $this->json('GET', $this->base_url . $id, [], ['Accept' => 'application/json'])
            ->assertStatus(404)
            ->assertJson([
                "message" => "NOT FOUND"
            ]);
    }

    public function testCanDestroyArtistWithAlbums()
    {
        $artist = Artist::factory()->create();
        $album = Album::factory()->create(['artist_id' => $artist->id]);
        $db_album = Album::find(1);
        $this->json('DELETE', $this->base_url . $artist->id, $artist->toArray(), ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "album_id" => [
                        "Can not delete artist with albums attached to them."
                    ]
                ]
            ]);
    }

    public function testGetAllArtist()
    {
        $artists = Artist::factory()->count(10)->create();
        $response = $this->json('GET', $this->base_url, [], ['Accept' => 'application/json'])
            ->assertStatus(200);
        $this->assertSame($artists->count(), count(json_decode($response->getContent())->data));
    }
}
