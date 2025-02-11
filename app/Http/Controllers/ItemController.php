<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Stock;
use DB;
class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('item.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $item = Item::create([
            'description' => trim($request->description),
            'cost_price' => $request->cost_price,
            'sell_price' => $request->sell_price
        ]);

        $stock = New Stock();
        $stock->item_id = $item->item_id;
        $stock->quantity = $request->quantity;
        $stock->save();

        return view('item.create');


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Item::find($id);
        $stock = Stock::find($id);
        // $item = DB::table('item')->join('stock', 'item.item_id', '=', 'stock.item_id')
                    // ->where('item.item_id', $id)->first();
                    // dd($item->quantity);
        return view('item.edit', compact('item', 'stock'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
