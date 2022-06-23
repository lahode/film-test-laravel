<?php

namespace App\Http\Services;

class FilmService {

    public function storeFilm($id) {
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

            $film = null;
            // Update film.
            if ($id) {
                $film = Film::find($id);
                if (!$film) {
                    throw new ApiException(
                        "Film not found.",
                        404
                    );
                }
            // Create film.
            } else {
                $film = new Film();
            }

            $film->title = $request->input('title');
            $film->year = $request->input('year');
            $film->description = $request->input('description');
            $film->category_id = $category->id;

            $film->save();
        }
        catch(\Exception $e) {
            throw $e;
        }
    }

}
