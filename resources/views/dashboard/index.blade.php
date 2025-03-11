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
            {!! $salesChart->script() !!}
        </div>
    @endsection
