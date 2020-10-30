<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreArtist;
use App\Models\Album;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $artists = Artist::paginate(10);
        return response()->json($artists, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArtist $request)
    {
        $artist = Artist::create([
            "name" => $request->input('name')
        ]);
        return response()->json($artist, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $artist = Artist::findOrFail($id);
        return response()->json($artist, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreArtist $request, $id)
    {
        $artist = Artist::findOrFail($id);
        $artist->update([
            "name" => $request->input("name")
        ]);
        return response()->json($artist, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $artist = Artist::findOrFail($id);
        $albums = Album::where('artist_id', $artist->id)->get();
        if ($albums->count() > 0) {
            return response()->json(
                [
                    "message" => "The given data was invalid.",
                    "errors" => [
                        "album_id" => [
                            "Can not delete artist with albums attached to them."
                        ]
                    ]
                ],
                422
            );
        }
        Artist::destroy($id);
        return response()->json([], 200);
    }
}
