<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Album;
use App\Http\Requests\AlbumRequest;
use App\Repositories\AlbumRepository;

class AlbumController extends Controller
{

    protected $repositoryAlbum;

    public function __construct(AlbumRepository $repository)
    {
        $this->repositoryAlbum = $repository;
        $this->middleware('ajax')->only('destroy');

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userAlbums = $this->repositoryAlbum->getAlbums($request->user());
        return view('albums.index', compact('userAlbums'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('albums.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store(AlbumRequest $request)
    {
        $this->repositoryAlbum->create($request->user(), $request->all());
        return back()->with('ok', __("L'album a bien été enregistré"));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Album $album)
    {
        return view ('albums.edit', compact ('album'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AlbumRequest $request, Album $album)
    {
        $this->authorize('manage', $album);
        $album->update($request->all());
        return redirect()->route('album.index')->with('ok', __("L'album a bien été modifié"));
    }
        /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Album $album)
    {
        $this->authorize('manage', $album);
        $album->delete();
        return response()->json();

    }
}
