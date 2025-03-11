@extends('layouts.base')
@section('body')
    @include('layouts.flash-messages')
    <div class="row">

        <div class="container">
            {{ Auth::check() ? Auth::user()->name : '' }}

            <div class="container">
                <hr>
                <h2>monthly sales</h2>
                {!! $salesChart->container() !!}

            </div>
            <div class="container">
                <hr>
                <h2>customer chart</h2>
                {!! $customerChart->container() !!}

            </div>
            <div class="container">
                <hr>
                <h2>item sold chart</h2>
                {!! $itemChart->container() !!}

            </div>
            {!! $salesChart->script() !!}
            {!! $customerChart->script() !!}
            {!! $itemChart->script() !!}
        
        </div>
    @endsection
