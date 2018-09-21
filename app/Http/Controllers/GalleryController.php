<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gallery;
use App\User;
use App\Image;


class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Gallery::with('images', 'user')->orderBy('created_at','desc')->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'gallery_name' => 'required|min:2|max:255',
            'description' => 'max:1000',
            'images' => 'required',
            'images.*' => ['regex:/^(http)?s?:?(\/\/[^\']*\.(?:png|jpg|jpeg))/']
        ]); 

        $gallery = new Gallery();
        $gallery->gallery_name = $request['gallery_name'];
        $gallery->description = $request['description'];
        $gallery->user_id = Auth()->user()->id;
        $gallery->save();

        $images = [];
        foreach ($request->images as $image) {
           array_push($images, new Image([
               'image_url' => $image,
               'gallery_id' => $gallery->id
               ]));
        }
        $gallery->images()->saveMany($images);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Gallery::with('images', 'user', 'comments.user')->findOrFail($id);
    }

    public function AuthorGalleries($id)
    {
        return Gallery::where('user_id', $id)->with('images', 'user')->orderBy('created_at','desc')->get();
    }

    public function UserGalleries()
    {
        $id= Auth()->user()->id;
        return Gallery::where('user_id', $id)->with('images', 'user')->orderBy('created_at','desc')->get();
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Gallery::destroy($id);
    }
}
