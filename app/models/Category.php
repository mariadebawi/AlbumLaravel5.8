<?php

namespace App\Models;

use App\Events\NameSaving;


use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'slug',
    ];

    
    protected $dispatchesEvents = [
        'saving' => NameSaving::class,
    ];


        /**
     * Get the images.
     */
    public function images()
    {
        return $this->hasMany (Image::class);
    }
}
