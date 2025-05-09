<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use App\Models\Order;
use App\Models\Item;



class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      
        // $customer = User::find(2)->customer();
        // $customer = Customer::find(2)->user->email;
        // $orders = Customer::find(1)->orders;
        // foreach($orders as $order){
        //     dump($order->status);
        // }
        // $customer = Order::find(72)->customer;
        // $items = Order::find(72)->items;
        // dd($items);

        // $orders = Item::find(34)->orders;
        // foreach($orders as $order){
        //         dump($order->pivot->quantity);
        //     }
        // dd($orders);
        // $orders = Order::all();
        // $orders = Order::withWhereHas(['customer', 'items'])->get();
        // $orders = Order::withWhereHas('customer')->where('status', 'delivered')->get();
        $orders = Order::withWhereHas('customer', function ($query) {
            $query->where('town', 'like', '%taguig%');
        })->get();
        // dd($orders);
        foreach($orders as $order){
            dump($order->customer->town);
        }

        // foreach($orders as $order){
        //     dump($order->customer->lname);
        //     foreach($order->items as $item){
        //         dump($item->description);
        //     }
        //     // dump($order->items->description);
        // }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = Customer::find($id);
        dd($customer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
