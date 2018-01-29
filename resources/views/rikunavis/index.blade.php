@extends('layouts.app')

@section('content')

    <form method="POST" action="/contact">
        <dl>
            <dt>業種(まとめ)：</dt>
            <dd>
                <select name="largeIndustries">
                    @foreach($datas as $data)
                        <option type = "checkbox" value = "{{$data->large_industries_id}}">{{$data->large_industries_name}}</option>
                    @endforeach
                </select>
            </dd>
        </dl>
        <dl>
            <dt>詳細業種：</dt>
            <dd>
                <select name="smallIndustries">
                    @foreach($datas2 as $data)
                        <option value = "{{$data->small_industries_id}}">{{$data->small_industries_name}}</option>
                    @endforeach
                </select>
            </dd>
        </dl>
        <dl>
            <dt>職種(まとめ)：</dt>
            <dd>
                <select name="largeJob">
                    @foreach($datas3 as $data)
                        <option value = "{{$data->large_job_category_id}}">{{$data->large_job_category_name}}</option>
                    @endforeach
                </select>
            </dd>
        </dl>
        <dl>
            <dt>詳細職種：</dt>
            <dd>
                <select name="smallJob">
                    @foreach($datas4 as $data)
                        <option value = "{{$data->small_job_category_id}}">{{$data->small_job_category_name}}</option>
                    @endforeach
                </select>
            </dd>
        </dl>
        <dl>
            <dt>地域：</dt>
            <dd>
                <select name="region">
                    @foreach($datas5 as $data)
                        <option value = "{{$data->region_id}}">{{$data->region_name}}</option>
                    @endforeach
                </select>
            </dd>
        </dl>
        <dl>
            <dt>都道府県：</dt>
            <dd>
                <select name="prefecture">
                    @foreach($datas6 as $data)
                        <option value = "{{$data->prefecture_id}}">{{$data->prefecture_name}}</option>
                    @endforeach
                </select>
            </dd>
        </dl>
        <input type="submit" value="CSV出力">
        <input type="hidden"  name="_token" value="{{ csrf_token() }}">
    </form>




@endsection