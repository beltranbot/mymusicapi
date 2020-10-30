<?php

namespace App\Rules\API;

use App\Models\Album;
use Illuminate\Contracts\Validation\Rule;

class UniqueArtistAlbumNameRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($album_id, $artist_id, $name)
    {
        $this->album_id = $album_id;
        $this->artist_id = $artist_id;
        $this->name = $name;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!$this->album_id) {
            $album = Album::where("artist_id", $this->artist_id)
                ->where("name", $this->name)->first();
            return !$album;
        }
        
        $album = Album::findOrFail($this->album_id);
        $album_unique = Album::where("id", "!=", $album->id)
            ->where("name", $this->name ?: $album->name)
            ->where("artist_id", $this->artist_id ?: $album->artist_id)->first();
        return !$album_unique;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The same album is only allowed once per artist.';
    }
}
