<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreAlbum;
use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $albums = Album::paginate(10);
        return response()->json($albums, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAlbum $request)
    {
        $artist = Album::create([
            "artist_id" => $request->input('artist_id'),
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
        $album = Album::findOrFail($id);
        return response()->json($album, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAlbum $request, $id)
    {
        $artist = Album::findOrFail($id);
        $artist->update([
            "name" => $request->has("name") ? $request->input("name") : $artist->name,
            "artist_id" => $request->has("artist_id") ? $request->input("artist_id") : $artist->artist_id,
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
        Album::destroy($id);
        return response()->json([], 200);
    }
}
