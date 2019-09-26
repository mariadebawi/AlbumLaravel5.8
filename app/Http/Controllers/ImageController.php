<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ {User, Image};



use App\Repositories\ {

    ImageRepository, AlbumRepository, CategoryRepository
};

class ImageController extends Controller
{
    protected  $imageRepository;

    protected $categoryRepository;
    protected $albumRepository;


    public function __construct( ImageRepository $imageRepository,
                                 CategoryRepository $categoryRepository ,
                                 AlbumRepository $albumRepository)
     {
       $this->imageRepository = $imageRepository;
        $this->categoryRepository = $categoryRepository;
         $this->albumRepository = $albumRepository;

     }


     public function category($slug)
     {
         $category = $this->categoryRepository->getBySlug ($slug);
         $images = $this->imageRepository->getImagesForCategory ($slug);
         return view ('home', compact ('category', 'images'));
     }


     public function user(User $user)
   {
         $images = $this->imageRepository->getImagesForUser ($user->id);

        return view ('home', compact ('user', 'images'));
    }


    public function album($slug)
    {
        $album = $this->albumRepository->getBySlug ($slug);
        $images = $this->imageRepository->getImagesForAlbum ($slug);
        return view ('home', compact ('album', 'images'));
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('images.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2000',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string|max:255',
        ]);
        $this->imageRepository->store($request);
        return back()->with('ok', __("L'image a bien été enregistrée"));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        $this->authorize ('manage', $image);

        $image->category_id = $request->category_id;
        $image->save();
        return back()->with('updated', __('La catégorie a bien été changée !'));
    }


    public function descriptionUpdate(Request $request, Image $image)
    {
        $this->authorize ('manage', $image);

        $request->validate ([
            'description' => 'nullable|string|max:255'
        ]);
        $image->description = $request->description;
        $image->save();
        return $image;
    }


    public function adultUpdate(Request $request, Image $image)
    {
        $image->adult = $request->adult == 'true';
        $image->save();
        return response()->json();
    }

        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Image $image)
    {
        $this->authorize('manage', $image);
        $image->delete ();
        return back ();
    }





}
