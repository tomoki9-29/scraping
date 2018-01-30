<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\StreamedResponse;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Rikunavi;

use Response;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input as input;

class RikunavisController extends Controller
{
    //
    public function getIndex()
    {
        //$data = Rikunavi::get()->toArray();
        $datas  = DB::select('select * from large_industries');
        $datas2 = DB::select('select * from small_industries');
        $datas3 = DB::select('select * from large_job_categories');
        $datas4 = DB::select('select * from small_job_categories');
        $datas5 = DB::select('select * from work_location_regions');
        $datas6 = DB::select('select * from work_locations');
        $datas7 = DB::select('select * from companies');

        //各大業種の小業種
        $datas_21  = DB::select('select * from small_industries WHERE large_industries_id ="I001"');
        $datas_22  = DB::select('select * from small_industries WHERE large_industries_id ="I002"');
        $datas_23  = DB::select('select * from small_industries WHERE large_industries_id ="I003"');
        $datas_24  = DB::select('select * from small_industries WHERE large_industries_id ="I004"');
        $datas_25  = DB::select('select * from small_industries WHERE large_industries_id ="I005"');
        $datas_26  = DB::select('select * from small_industries WHERE large_industries_id ="I006"');
        $datas_27  = DB::select('select * from small_industries WHERE large_industries_id ="I007"');

        //各大職種の小職種
        $datas_31  = DB::select('select * from small_job_categories WHERE large_job_category_id ="J001"');
        $datas_32  = DB::select('select * from small_job_categories WHERE large_job_category_id ="J002"');
        $datas_33  = DB::select('select * from small_job_categories WHERE large_job_category_id ="J003"');
        $datas_34  = DB::select('select * from small_job_categories WHERE large_job_category_id ="J004"');
        $datas_35  = DB::select('select * from small_job_categories WHERE large_job_category_id ="J005"');
        $datas_36  = DB::select('select * from small_job_categories WHERE large_job_category_id ="J006"');

        //各地域の都道府県
        $datas_41  = DB::select('select * from work_locations WHERE region_id ="W001"');
        $datas_42  = DB::select('select * from work_locations WHERE region_id ="W002"');
        $datas_43  = DB::select('select * from work_locations WHERE region_id ="W003"');
        $datas_44  = DB::select('select * from work_locations WHERE region_id ="W004"');
        $datas_45  = DB::select('select * from work_locations WHERE region_id ="W005"');
        $datas_46  = DB::select('select * from work_locations WHERE region_id ="W006"');
        $datas_47  = DB::select('select * from work_locations WHERE region_id ="W007"');
        $datas_48  = DB::select('select * from work_locations WHERE region_id ="W008"');


        return view('rikunavis.index',compact(
            'datas',
            'datas_21',
            'datas_22',
            'datas_23',
            'datas_24',
            'datas_25',
            'datas_26',
            'datas_27',
            'datas_31',
            'datas_32',
            'datas_33',
            'datas_34',
            'datas_35',
            'datas_36',
            'datas_41',
            'datas_42',
            'datas_43',
            'datas_44',
            'datas_45',
            'datas_46',
            'datas_47',
            'datas_48',
            'datas3',
            'datas4',
            'datas5',
            'datas6',
            'datas7'
        ));
        //return view('rikunavis.index',compact('datas_s'));

    }

    /*public function show()
    {
        $rikunavis = Rikunavi::get(["company_name","ceo"])->toArray();

        return view('rikunavis.index', [
            'rikunavis' => $rikunavis,
        ]);

    }*/

    public function postIndex(Request $request)
    {
        $largeIndustries = $request->input('largeIndustries');
        $smallIndustries = $request->input('smallIndustries');
        $largeJob = $request->input('largeJob');
        $smallJob = $request->input('smallJob');
        $region = $request->input('region');
        $prefecture = $request->input('prefecture');

        //大業種の複数選択
        $largeIndustries_null = "";
        $largeIndustries_count = count($largeIndustries);
        if(count($largeIndustries) == 1){
            $largeIndustries = $largeIndustries[0];
        }
        else{

            for($i=1;$i<$largeIndustries_count;$i++){
                $largeIndustries_init = $largeIndustries[0];
                $largeIndustries_null = $largeIndustries_null."\",\"".$largeIndustries[$i];
            }
            $largeIndustries = $largeIndustries_init.$largeIndustries_null;
        }

        //小業種の複数選択
        $smallIndustries_null = "";
        $smallIndustries_count = count($smallIndustries);
        if(count($smallIndustries) == 1){
            $smallIndustries = $smallIndustries[0];
        }
        else{

            for($i=1;$i<$smallIndustries_count;$i++){
                $smallIndustries_init = $smallIndustries[0];
                $smallIndustries_null = $smallIndustries_null."\",\"".$smallIndustries[$i];
            }
            $smallIndustries = $smallIndustries_init.$smallIndustries_null;
        }

        //大職種の複数選択
        $largeJob_null = "";
        $largeJob_count = count($largeJob);
        if(count($largeJob) == 1){
            $largeJob = $largeJob[0];
        }
        else{

            for($i=1;$i<$largeJob_count;$i++){
                $largeJob_init = $largeJob[0];
                $largeJob_null = $largeJob_null."\",\"".$largeJob[$i];
            }
            $largeJob = $largeJob_init.$largeJob_null;
        }

        //小職種の複数選択
        $smallJob_null = "";
        $smallJob_count = count($smallJob);
        if(count($smallJob) == 1){
            $smallJob = $smallJob[0];
        }
        else{

            for($i=1;$i<$smallJob_count;$i++){
                $smallJob_init = $smallJob[0];
                $smallJob_null = $smallJob_null."\",\"".$smallJob[$i];
            }
            $smallJob = $smallJob_init.$smallJob_null;
        }

        //地域の複数選択
        $region_null = "";
        $region_count = count($region);
        if(count($region) == 1){
            $region = $region[0];
        }
        else{

            for($i=1;$i<$region_count;$i++){
                $region_init = $region[0];
                $region_null = $region_null."\",\"".$region[$i];
            }
            $region = $region_init.$region_null;
        }

        //都道府県の複数選択
        $prefecture_null = "";
        $prefecture_count = count($prefecture);
        if(count($prefecture) == 1){
            $prefecture = $prefecture[0];
        }
        else{

            for($i=1;$i<$prefecture_count;$i++){
                $prefecture_init = $prefecture[0];
                $prefecture_null = $prefecture_null."\",\"".$prefecture[$i];
            }
            $prefecture = $prefecture_init.$prefecture_null;
        }



        $datas = DB::select(
            "SELECT *
                     FROM companies
                                     A 
                INNER JOIN (
                               SELECT company_id
                                 FROM companies_large_industries
                                WHERE large_industries_id IN (\"".$largeIndustries."\")
                          )          B
                       ON A.company_id = B.company_id
                INNER JOIN (
                               SELECT company_id
                                 FROM companies_small_industries
                                WHERE small_industries_id IN (\"".$smallIndustries."\")
                          )          C
                       ON B.company_id = C.company_id
                INNER JOIN (
                               SELECT company_id
                                 FROM companies_large_job_categories
                                WHERE large_job_category_id IN (\"".$largeJob."\")
                          )          D
                       ON C.company_id = D.company_id
                INNER JOIN (
                               SELECT company_id
                                 FROM companies_small_job_categories
                                WHERE small_job_category_id IN (\"".$smallJob."\")
                          )          E
                       ON D.company_id = E.company_id
                INNER JOIN (
                               SELECT company_id
                                 FROM companies_work_location_regions
                                WHERE region_id IN (\"".$region."\")
                          )          F
                       ON E.company_id = F.company_id
                INNER JOIN (
                               SELECT company_id
                                 FROM companies_work_locations
                                WHERE prefecture_id IN (\"".$prefecture."\")
                          )          G
                       ON F.company_id = G.company_id "
        );

        //$users = $datas->toArray();
        $stream = fopen('php://temp', 'r+b');

        $tmp = [];
        $uniqueStations = [];

        foreach ($datas as $user) {

            if (!in_array($user->company_id, $tmp)) {
                $tmp[] = $user->company_id;
                //$uniqueStations[] = (array)$user;
                fputcsv($stream,(array)$user);
            }
        }
        rewind($stream);
        $csv = str_replace(PHP_EOL, "\r\n", stream_get_contents($stream));
        $csv = mb_convert_encoding($csv, 'SJIS-win', 'UTF-8');
        $headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="rikunavi.csv"',
        );
        return Response::make($csv,200, $headers);

        //return Response::make($csv, 200, $headers);

        //return view('rikunavis.confirm', compact('datas'));

        /*
        $tmp = [];
        $uniqueStations = [];
        foreach ($datas as $user){
            if (!in_array($user['name'], $tmp)) {
                $tmp[] = $user['name'];
                $uniqueStations[] = $user;
            }
        }
        */

    }

}

