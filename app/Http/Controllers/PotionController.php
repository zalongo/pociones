<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponser;
use App\Models\Potion;
use App\Http\Requests\StorePotionRequest;
use App\Http\Requests\UpdatePotionRequest;

class PotionController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $potions = Potion::with('ingredients')->get();
        return $this->success($potions);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePotionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePotionRequest $request)
    {
        return $this->success($potion, 'Poción creada con éxito.', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Potion  $potion
     * @return \Illuminate\Http\Response
     */
    public function show(Potion $potion)
    {
        return $this->success($potion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePotionRequest  $request
     * @param  \App\Models\Potion  $potion
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePotionRequest $request, Potion $potion)
    {
        return $this->success($potion, 'Poción actualizada con éxito.', 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Potion  $potion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Potion $potion)
    {
        $potion->delete();
        return $this->success([], null, 202);
    }
}
