<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponser;
use App\Models\Sale;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Models\Potion;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    use ApiResponser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $client_id = $request->has('client_id') ? $request->query('client_id') : null;
        $potion_id = $request->query('potion_id');
        $sales = Sale::with('client', 'potion')
            ->where('active', 1)
            ->when($client_id, function ($q) use ($client_id) {
                return $q->where('client_id', $client_id);
            })
            ->when($potion_id, function ($q) use ($potion_id) {
                return $q->where('potion_id', $potion_id);
            })
            ->get();

        return $this->success($sales);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSaleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSaleRequest $request)
    {
        $data = $request->all();

        $potion = Potion::with('ingredients')->find($data['potion_id']);

        $data['total'] = 0;

        foreach ($potion->ingredients as $ingredient) {
            if ($ingredient->stock < ($ingredient->pivot->quantity * $data['quantity'])) {
                return $this->error('No es posible realizar la venta por falta de stock ', 406, $potion);
            }

            $data['total'] = $data['total'] + (($ingredient->pivot->quantity * $ingredient->price) * $data['quantity']);
        }

        $sale = Sale::create($data);

        foreach ($potion->ingredients as $ingredient) {
            $ingredient->stock = $ingredient->stock - ($ingredient->pivot->quantity * $data['quantity']);
            $ingredient->save();
        }

        return $this->success($sale, 'Venta creada con éxito.', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        $sale->load('client', 'potion');
        return $this->success($sale);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSaleRequest  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSaleRequest $request, Sale $sale)
    {

        $data = $request->all();

        $potion = Potion::with('ingredients')->find($data['potion_id']);

        foreach ($potion->ingredients as $index => $ingredient) {
            /* print_r([
                $ingredient->pivot->quantity,
                $data['quantity'],
                $ingredient->pivot->quantity * $data['quantity'],
                $ingredient->stock
            ]); */
            $potion->ingredients[$index]->stock = $ingredient->stock + ($sale->quantity * $ingredient->pivot->quantity);
        }

        $data['total'] = 0;

        foreach ($potion->ingredients as $ingredient) {
            if ($ingredient->stock <  ($ingredient->pivot->quantity * $data['quantity'])) {
                return $this->error('No es posible actualizar la venta por falta de stock ', 406, $potion);
            }

            $data['total'] = $data['total'] + (($ingredient->pivot->quantity * $ingredient->price) * $data['quantity']);
        }

        $sale->fill($data);
        if ($sale->isDirty()) {
            $sale->save();
        }

        foreach ($potion->ingredients as $ingredient) {
            $ingredient->stock = $ingredient->stock - ($ingredient->pivot->quantity * $data['quantity']);
            // $ingredient->stock = $ingredient->stock - $ingredient->pivot->quantity;
            $ingredient->save();
        }

        return $this->success($sale, 'Venta actualizada con éxito.', 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        $sale->active = 0;
        $sale->save();
        return $this->success([], 'Venta eliminada con éxito.', 202);
    }
}