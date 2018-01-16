@extends('layouts.app')

@section('content')

    {!! Form::model($rikunavis, ['route' => 'rikunavis.store']) !!}

        {!! Form::label('content', '業種:') !!}
        {!! Form::text('content') !!}<br>

        {!! Form::label('content', '職種:') !!}
        {!! Form::text('content') !!}<br>

        {!! Form::label('content', '勤務地:') !!}
        {!! Form::text('content') !!}<br>

    {!! Form::close() !!}

    {!! link_to_route('rikunavis.show', '選択する') !!}



@endsection