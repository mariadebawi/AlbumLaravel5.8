<?php
namespace App\Repositories;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as InterventionImage;




class ImageRepository
{
    public function store($request)
    {
        // Save image
        $path = basename($request->image->store('images'));
        // Save thumb
        $image = InterventionImage::make($request->image)->widen(500)->encode();
        Storage::put('thumbs/' . $path, $image);
        // Save in base
        $image = new Image;
        $image->description = $request->description;
        $image->category_id = $request->category_id;
        $image->adult = isset($request->adult);
        $image->name = $path;
        $request->user()->images()->save($image);
    }


        public function getAllImages()
    {
      return Image::latestWithUser()->paginate(config ('app.pagination'));
    }


    public function getImagesForCategory($slug)
   {
       return Image::latestWithUser()->whereHas('category', function ($query) use ($slug) {
        $query->whereSlug($slug);
       })->paginate(config('app.pagination'));

   }

   public function getImagesForUser($id)
    {
      return Image::latestWithUser ()->whereHas ('user', function ($query) use ($id) {
        $query->whereId ($id);
     })->paginate(config('app.pagination'));
    }


    public function getImagesForAlbum($slug)
    {
        return Image::latestWithUser ()->whereHas ('albums', function ($query) use ($slug) {
            $query->whereSlug ($slug);
        })->paginate(config('app.pagination'));
    }
}

