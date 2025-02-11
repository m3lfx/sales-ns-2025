@extends('layouts.base')

@section('body')

    <div class="container">
        {!! Form::model($item, ['route' => ['items.update', $item->item_id], 'method' => 'PUT']) !!}
        
        {!! Form::label('desc', 'item name', ['class' => 'form-label']) !!}
        {!! Form::text('description', null, ['class' => 'form-control', 'id' => 'desc']) !!}
        
        {!! Form::label('cost', 'cost price', ['class' => 'form-label']) !!}
        {!! Form::number('cost_price', null, ['min' => 0.00, 'step' => 0.01, 'class' => 'form-control', 'id' => 'cost' ]) !!}

        {!! Form::label('sell', 'sell price', ['class' => 'form-label']) !!}
        {!! Form::number('sell_price', null, ['min' => 0.00, 'step' => 0.01, 'class' => 'form-control', 'id' => 'sell' ]) !!}

        {!! Form::label('qty', 'quantity', ['class' => 'form-label']) !!}
        {!! Form::number('quantity', $stock->quantity, ['class' => 'form-control', 'id' => 'qty' ]) !!}

        {!! Form::submit('Add item',  ['class'=> "btn btn-primary"]) !!}
        {!! Form::close() !!}
    </div>
@endsection
