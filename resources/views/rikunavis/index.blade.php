@extends('layouts.app')

@section('content')

    @foreach($data as $item)
        <div>
            <div>{{{ $item->company_name }}}</div>
            <div>{{{ $item->ceo }}}</div>
            <div>{{{ $item->sales }}}</div>
        </div>
        <hr>
    @endforeach

@endsection