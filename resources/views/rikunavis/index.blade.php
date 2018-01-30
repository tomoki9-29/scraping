<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Company Data</title>
    <script src="//code.jquery.com/jquery-1.12.1.min.js"></script>
    <script>
        $(function() {
            //各業種のチェックボックスの引数指定し、関数を呼び出す
            checkbox('#all_maker','.check_maker');
            checkbox('#all_service_infra','.check_service_infra');
            checkbox('#all_trading','.check_trading');
            checkbox('#all_economy','.check_economy');
            checkbox('#all_media','.check_media');
            checkbox('#all_retail','.check_retail');
            checkbox('#all_information','.check_information');

            //各職種のチェックボックスの引数指定し、関数を呼び出す
            checkbox('#all_job_office_work','.check_job_office_work');
            checkbox('#all_job_business','.check_job_business');
            checkbox('#all_job_sale','.check_job_sale');
            checkbox('#all_job_information','.check_job_information');
            checkbox('#all_job_technology','.check_job_technology');
            checkbox('#all_job_speciality','.check_job_speciality');

            //各地域・都道府県のチェックボックスの引数指定し、関数を呼び出す
            checkbox('#all_hokkaido_tohoku','.check_hokkaido_tohoku');
            checkbox('#all_kanto','.check_kanto');
            checkbox('#all_hokuriku_shinnetu','.check_hokuriku_shinnetu');
            checkbox('#all_tokai','.check_tokai');
            checkbox('#all_kinki','.check_kinki');
            checkbox('#all_tyugoku_shikoku','.check_tyugoku_shikoku');
            checkbox('#all_kyusyu_okinawa','.check_kyusyu_okinawa');
            checkbox('#all_other','.check_other');

            $('.check').on('click', function() {
                if ($(".check:not(:checked)").size() == 0) {
                    allCheck('#all');
                } else {
                    allRemove('#all');
                }
            });

        });
        function checkbox(id_name,class_name){
            $(id_name).on('click', function() {
                if ($(this).prop('checked')) {
                    allCheck(class_name);
                } else {
                    allRemove(class_name);
                }
            });
        }
        function allCheck(value) {
            $(value).prop('checked', true);

        }
        function allRemove(value) {
            $(value).prop('checked', false);

        }

    </script>

</head>
<body>

    <form method="POST" action="/contact" name=Industries>

        <table border="1">
            <tr>
                <td>業種</td>
                <td>詳細職種</td>
            </tr>
            <tr>
                <td><input type="checkbox" value = "I001" name="largeIndustries[]">メーカー</td>
                <td>
                        <input type="checkbox"  id="all_maker" >メーカーすべて<br>
                        @foreach($datas_21 as $data)
                            <input type='checkbox' name="smallIndustries[]" value = "{{$data->small_industries_id}}" class="check_maker">{{$data->small_industries_name}}
                        @endforeach
                </td>
            </tr>
            <tr>
                <td><input type="checkbox" value = "I002" name="largeIndustries[]">サービス・インフラ</td>
                <td>
                        <input type="checkbox"  id="all_service_infra" >サービス・インフラすべて<br>
                        @foreach($datas_22 as $data)
                            <input type='checkbox' name="smallIndustries[]" value = "{{$data->small_industries_id}}" class="check_service_infra">{{$data->small_industries_name}}
                        @endforeach
                </td>
            </tr>
            <tr>
                <td><input type="checkbox" value = "I003" name="largeIndustries[]">商社（総合・専門）</td>
                <td>

                        <input type="checkbox"  id="all_trading" >商社（総合・専門）すべて<br>
                        @foreach($datas_23 as $data)
                            <input type='checkbox' name="smallIndustries[]" value = "{{$data->small_industries_id}}" class="check_trading">{{$data->small_industries_name}}
                        @endforeach
                    
                </td>
            </tr>
            <tr>
                <td><input type="checkbox" value = "I004" name="largeIndustries[]">銀行・証券・保険・金融</td>
                <td>

                        <input type="checkbox"  id="all_economy" >銀行・証券・保険・金融すべて<br>
                        @foreach($datas_24 as $data)
                            <input type='checkbox' name="smallIndustries[]" value = "{{$data->small_industries_id}}" class="check_economy">{{$data->small_industries_name}}
                        @endforeach
                    
                </td>
            </tr>
            <tr>
                <td><input type="checkbox" value = "I005" name="largeIndustries[]">広告・通信・マスコミ</td>
                <td>

                        <input type="checkbox"  id="all_media" >広告・通信・マスコミすべて<br>
                        @foreach($datas_25 as $data)
                            <input type='checkbox' name="smallIndustries[]" value = "{{$data->small_industries_id}}" class="check_media">{{$data->small_industries_name}}
                        @endforeach
                    
                </td>
            </tr>
            <tr>
                <td><input type="checkbox" value = "I006" name="largeIndustries[]">百貨店・専門店・流通・小売</td>
                <td>

                        <input type="checkbox"  id="all_retail" >百貨店・専門店・流通・小売すべて<br>
                        @foreach($datas_26 as $data)
                            <input type='checkbox' name="smallIndustries[]" value = "{{$data->small_industries_id}}" class="check_retail">{{$data->small_industries_name}}
                        @endforeach
                    
                </td>
            </tr>
            <tr>
                <td><input type="checkbox" value = "I007" name="largeIndustries[]">IT・ソフトウェア・情報処理</td>
                <td>

                        <input type="checkbox"  id="all_information" >IT・ソフトウェア・情報処理すべて<br>
                        @foreach($datas_27 as $data)
                            <input type='checkbox' name="smallIndustries[]" value = "{{$data->small_industries_id}}" class="check_information">{{$data->small_industries_name}}
                        @endforeach
                    
                </td>
            </tr>

        </table><br>

        <table border="1">
            <tr>
                <td>職種</td>
                <td>詳細職種</td>
            </tr>
            <tr>
                <td><input type="checkbox" value = "J001"  name="largeJob[]">事務系</td>
                <td>

                        <input type="checkbox"  id="all_job_office_work" >事務系すべて<br>
                        @foreach($datas_31 as $data)
                            <input type="checkbox" value = "{{$data->small_job_category_id}}" name="smallJob[]" class="check_job_office_work">{{$data->small_job_category_name}}
                        @endforeach
                    
                </td>
            </tr>
            <tr>
                <td><input type="checkbox" value = "J002"  name="largeJob[]">営業系</td>
                <td>

                        <input type="checkbox"  id="all_job_business" >営業系すべて<br>
                        @foreach($datas_32 as $data)
                            <input type='checkbox'  value = "{{$data->small_job_category_id}}" name="smallJob[]" class="check_job_business">{{$data->small_job_category_name}}
                        @endforeach
                    
                </td>
            </tr>
            <tr>
                <td><<input type="checkbox" value = "J003"  name="largeJob[]">販売系</td>
                <td>

                        <input type="checkbox"  id="all_job_sale" >販売系すべて<br>
                        @foreach($datas_33 as $data)
                            <input type='checkbox'  value = "{{$data->small_job_category_id}}" name="smallJob[]" class="check_job_sale">{{$data->small_job_category_name}}
                        @endforeach
                    
                </td>
            </tr>
            <tr>
                <td><<input type="checkbox" value = "J004"  name="largeJob[]">IT系</td>
                <td>

                        <input type="checkbox"  id="all_job_information" >IT系すべて<br>
                        @foreach($datas_34 as $data)
                            <input type='checkbox'  value = "{{$data->small_job_category_id}}" name="smallJob[]" class="check_job_information">{{$data->small_job_category_name}}
                        @endforeach
                    
                </td>
            </tr>
            <tr>
                <td><input type="checkbox" value = "J005"  name="largeJob[]">技術系</td>
                <td>

                        <input type="checkbox"  id="all_job_technology" >技術系すべて<br>
                        @foreach($datas_35 as $data)
                            <input type='checkbox'  value = "{{$data->small_job_category_id}}" name="smallJob[]" class="check_job_technology">{{$data->small_job_category_name}}
                        @endforeach
                    
                </td>
            </tr>
            <tr>
                <td><input type="checkbox" value = "J006"  name="largeJob[]">専門系</td>
                <td>

                        <input type="checkbox"  id="all_job_speciality" >専門系すべて<br>
                        @foreach($datas_36 as $data)
                            <input type='checkbox'  value = "{{$data->small_job_category_id}}" name="smallJob[]" class="check_job_speciality">{{$data->small_job_category_name}}
                        @endforeach
                    
                </td>
            </tr>
        </table><br>

        <table border="1">
            <tr>
                <td>地域</td>
                <td>都道府県</td>
            </tr>
            <tr>
                <td><input type="checkbox" value = "W001" name="region[]">北海道・東北</td>
                <td>

                        <input type="checkbox"  id="all_hokkaido_tohoku">北海道・東北すべて<br>
                        @foreach($datas_41 as $data)
                            <input type='checkbox' value = "{{$data->prefecture_id}}" name="prefecture[]" class="check_hokkaido_tohoku">{{$data->prefecture_name}}
                        @endforeach
                    
                </td>
            </tr>
            <tr>
                <td><input type="checkbox" value = "W002" name="region[]">関東</td>
                <td>

                        <input type="checkbox"  id="all_kanto">関東すべて<br>
                        @foreach($datas_42 as $data)
                            <input type='checkbox'  value = "{{$data->prefecture_id}}" name="prefecture[]" class="check_kanto">{{$data->prefecture_name}}
                        @endforeach
                    
                </td>
            </tr>
            <tr>
                <td><input type="checkbox" value = "W003" name="region[]">北陸・甲信越</td>
                <td>

                        <input type="checkbox"  id="all_hokuriku_shinnetu">北陸・甲信越すべて<br>
                        @foreach($datas_43 as $data)
                            <input type='checkbox'  value = "{{$data->prefecture_id}}" name="prefecture[]" class="check_hokuriku_shinnetu">{{$data->prefecture_name}}
                        @endforeach
                    
                </td>
            </tr>
            <tr>
                <td><input type="checkbox" value = "W004" name="region[]">東海</td>
                <td>

                        <input type="checkbox"  id="all_tokai">東海すべて<br>
                        @foreach($datas_44 as $data)
                            <input type='checkbox'  value = "{{$data->prefecture_id}}" name="prefecture[]" class="check_tokai">{{$data->prefecture_name}}
                        @endforeach
                    
                </td>
            </tr>
            <tr>
                <td><input type="checkbox" value = "W005" name="region[]">近畿</td>
                <td>

                        <input type="checkbox"  id="all_kinki">近畿すべて<br>
                        @foreach($datas_45 as $data)
                            <input type='checkbox'  value = "{{$data->prefecture_id}}" name="prefecture[]" class="check_kinki">{{$data->prefecture_name}}
                        @endforeach
                    
                </td>
            </tr>
            <tr>
                <td><input type="checkbox" value = "W006" name="region[]">中国・四国</td>
                <td>

                        <input type="checkbox"  id="all_tyugoku_shikoku">中国・四国すべて<br>
                        @foreach($datas_46 as $data)
                            <input type='checkbox'  value = "{{$data->prefecture_id}}" name="prefecture[]" class="check_tyugoku_shikoku">{{$data->prefecture_name}}
                        @endforeach
                    
                </td>
            </tr>
            <tr>
                <td><input type="checkbox" value = "W007" name="region[]">九州・沖縄</td>
                <td>

                        <input type="checkbox"  id="all_kyusyu_okinawa">九州・沖縄すべて<br>
                        @foreach($datas_47 as $data)
                            <input type='checkbox'  value = "{{$data->prefecture_id}}" name="prefecture[]" class="check_kyusyu_okinawa">{{$data->prefecture_name}}
                        @endforeach
                    
                </td>
            </tr>
            <tr>
                <td><input type="checkbox" value = "W008" name="region[]">その他</td>
                <td>

                        <input type="checkbox"  id="all_other">その他すべて<br>
                        @foreach($datas_48 as $data)
                            <input type='checkbox'  value = "{{$data->prefecture_id}}" name="prefecture[]" class="check_other">{{$data->prefecture_name}}
                        @endforeach
                    
                </td>
            </tr>
        </table>

        <input type="submit" value="CSV出力">
        <input type="hidden"  name="_token" value="{{ csrf_token() }}">
    </form>

    <?php

    /*$smallIndustries = "";
    $smallIndustries_count = 5;
    for($i=1;$i<$smallIndustries_count;$i++){
        $smallIndustries_init = 0;
        $smallIndustries = $smallIndustries."\",\"".$smallIndustries_count;

    }

    $smallIndustries = $smallIndustries_init.$smallIndustries;

    var_dump($smallIndustries);*/

    ?>

</body>
</html>