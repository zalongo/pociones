<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponser;
use App\Models\Ingredient;
use App\Http\Requests\StoreIngredientRequest;
use App\Http\Requests\UpdateIngredientRequest;

class IngredientController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ingredient = Ingredient::where('active', 1)->get();
        return $this->success($ingredient);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreIngredientRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIngredientRequest $request)
    {
        $ingredient = Ingredient::create($request->all());

        return $this->success($ingredient, 'Ingrediente creado con éxito.', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function show(Ingredient $ingredient)
    {
        return $this->success($ingredient);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateIngredientRequest  $request
     * @param  \App\Models\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIngredientRequest $request, Ingredient $ingredient)
    {
        $ingredient->fill($request->all());
        if ($ingredient->isDirty()) {
            $ingredient->save();
        }
        return $this->success($ingredient, 'Ingrediente actualizado con éxito.', 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ingredient $ingredient)
    {
        $ingredient->active = 0;
        $ingredient->save();
        return $this->success([], 'Ingrediente eliminado con éxito.', 202);
    }
}