<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlbumRequest extends FormRequest
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


    public function rules()
    {
        $id = $this->album ? ',' . $this->album->id : '';
        return $rules = [
            'name' => 'required|string|max:255|unique:albums,name' . $id,
        ];
    }
}
