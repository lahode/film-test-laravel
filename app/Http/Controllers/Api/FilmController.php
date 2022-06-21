<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Film;
use App\Exceptions\ApiException;
use Illuminate\Support\Facades\Log;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Film::all();


        /*
        find()
        where()
          => first()
          => get()
        whereNull()
        delete()

        save()
        */


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = Category::find($request->input('category_id'));

        $film = new Film();
        $film->title = $request->input('title');
        $film->year = $request->input('year');
        $film->description = $request->input('description');
        $film->category_id = $category->id;

        $film->save();

        return $film;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $film = Film::find($id);
            if (!$film) {
                throw new ApiException(
                    "Film not found.",
                    404
                );
            }
            return $film;
        }
        catch(\Exception $e) {
            throw $e;
        }
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
        $category = Category::find($request->input('category_id'));

        $film = Film::find($id);
        $film->title = $request->input('title');
        $film->year = $request->input('year');
        $film->description = $request->input('description');
        $film->category_id = $category->id;

        $film->save();

        return $film;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $film = Film::find($id);
        $film->delete();
        return 'Film has been deleted';
    }
}