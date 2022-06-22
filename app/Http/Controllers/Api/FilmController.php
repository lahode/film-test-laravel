<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Film;
use App\Models\Category;
use App\Exceptions\ApiException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\ValidateException;

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
        try {
            $validatorRules = [
                'title' => 'required|string|max:256',
                'year' => 'required|digits:4|integer|min:1900|max:'.(date('Y')+1),
                'description' => 'nullable|string',
                'category_id' => 'integer|digits_between:1,20|required'
            ];

            // Validate fields.
            $validator = Validator::make($request->all(), $validatorRules);

            // If validation fails
            // Return error messages and exit.
            if ($validator->fails()) {
                throw (new ValidateException(
                    $validator->errors()
                ));
            }



            $category = Category::find($request->input('category_id'));

            $film = new Film();
            $film->title = $request->input('title');
            $film->year = $request->input('year');
            $film->description = $request->input('description');
            $film->category_id = $category->id;

            $film->save();

            return $film;
        }
        catch(\Exception $e) {
            throw $e;
        }
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
