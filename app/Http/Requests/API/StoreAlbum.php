<?php

namespace App\Http\Requests\API;

use App\Rules\API\UniqueArtistAlbumNameRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAlbum extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:50',
            'artist_id' => [
                'required',
                'exists:artists,id',
                new UniqueArtistAlbumNameRule($this->route("album"), $this->artist_id, $this->name)
            ]
        ];
    }
}
