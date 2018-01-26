@extends('layouts.app')

@section('content')

    業種(まとめ)：<br>

    <table>
            <td>
                @foreach($datas as $data)
                    {{$data->company_name}}<br>
                @endforeach
            </td>
            <td>
                @foreach($datas as $data)
                    {{$data->phone_number}}<br>
                @endforeach
            </td>
    </table>


@endsection