<?php

namespace Tests\Feature;

use App\Models\Album as Album;
use App\Models\Artist;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AlbumTest extends TestCase
{
    use WithFaker;

    private $base_url = 'api/albums/';

    public function testPostArtist()
    {
        $artist = Artist::factory()->create();
        $album = Album::factory()->make(["artist_id" => $artist->id]);
        $this->json('POST', $this->base_url, $album->toArray(), ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJson($album->toArray());
    }

    public function testGetArtist()
    {
        $artist = Artist::factory()->create();
        $album = Album::factory()->create(["artist_id" => $artist->id]);
        $this->json('GET', $this->base_url . $album->id, [], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson($album->toArray());
    }

    // public function testDestroyArtist()
    // {
    //     $album = Album::factory()->create();
    //     $this->json('DELETE', $this->base_url . $album->id, $album->toArray(), ['Accept' => 'application/json'])
    //         ->assertStatus(200);
    //     $deletedArtist = Album::find($album->id);
    //     $this->assertNull($deletedArtist);
    // }

    // public function testPutArtist()
    // {
    //     $album = Album::factory()->create();
    //     $updatedArtist = Album::factory()->make();
    //     $response = $this->json('PUT', $this->base_url . $album->id, $updatedArtist->toArray(), ['Accept' => 'application/json'])
    //         ->assertStatus(200);
    //     $this->assertEquals($updatedArtist->name, $response["name"]);
    // }

    // public function testShouldBeAbleToUpdateTheSameIdData()
    // {
    //     $album = Album::factory()->create();
    //     $response = $this->json('PUT', $this->base_url . $album->id, $album->toArray(), ['Accept' => 'application/json'])
    //         ->assertStatus(200)
    //         ->assertJson($album->toArray());
    // }

    // public function testArtistNameisRequiredValidation()
    // {
    //     $album = [];
    //     $this->json('POST', $this->base_url, $album, ['Accept' => 'application/json'])
    //         ->assertStatus(422)
    //         ->assertJson([
    //             "message" => "The given data was invalid.",
    //             "errors" => [
    //                 "name" => [
    //                     "The name field is required."
    //                 ]
    //             ]
    //         ]);
    // }

    // public function testArtistNameMustBeUnique()
    // {
    //     $album = Album::factory()->create();
    //     $this->json('POST', $this->base_url, $album->toArray(), ['Accept' => 'application/json'])
    //         ->assertStatus(422)
    //         ->assertJson([
    //             "message" => "The given data was invalid.",
    //             "errors" => [
    //                 "name" => [
    //                     "The name has already been taken."
    //                 ]
    //             ]
    //         ]);
    // }

    // public function testArtistNameLengthMustAtLeast2()
    // {
    //     $album = ['name' => 'a'];
    //     $this->json('POST', $this->base_url, $album, ['Accept' => 'application/json'])
    //         ->assertStatus(422)
    //         ->assertJson([
    //             "message" => "The given data was invalid.",
    //             "errors" => [
    //                 "name" => [
    //                     "The name must be at least 2 characters."
    //                 ]
    //             ]
    //         ]);
    // }

    // public function testArtistNameLengthMustNotBeGreaterThan50()
    // {
    //     $album = ['name' => $this->faker->regexify('[A-Za-z0-9]{51}')];
    //     $this->json('POST', $this->base_url, $album, ['Accept' => 'application/json'])
    //         ->assertStatus(422)
    //         ->assertJson([
    //             "message" => "The given data was invalid.",
    //             "errors" => [
    //                 "name" => [
    //                     "The name may not be greater than 50 characters."
    //                 ]
    //             ]
    //         ]);
    // }

    // public function testPutNonExistingArtistShouldReturn404()
    // {
    //     $album = Album::factory()->make();
    //     $id = 1;
    //     $this->json('PUT', $this->base_url . $id, $album->toArray(), ['Accept' => 'application/json'])
    //         ->assertStatus(404)
    //         ->assertJson([
    //             "message" => "NOT FOUND"
    //         ]);
    // }

    // public function testGetNonExistingArtistShouldReturn404()
    // {
    //     $id = 1;
    //     $this->json('GET', $this->base_url . $id, [], ['Accept' => 'application/json'])
    //         ->assertStatus(404)
    //         ->assertJson([
    //             "message" => "NOT FOUND"
    //         ]);
    // }

    // public function testDeleteNonExistingArtistShouldReturn404()
    // {
    //     $id = 1;
    //     $this->json('GET', $this->base_url . $id, [], ['Accept' => 'application/json'])
    //         ->assertStatus(404)
    //         ->assertJson([
    //             "message" => "NOT FOUND"
    //         ]);
    // }
}
