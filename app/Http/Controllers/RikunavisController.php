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

        return view('rikunavis.index',compact('datas','datas2','datas3','datas4','datas5','datas6','datas7'));
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

        $datas = DB::select(
            "SELECT *
                     FROM companies
                                     A 
                INNER JOIN (
                               SELECT company_id
                                 FROM companies_large_industries
                                WHERE large_industries_id =\"".$largeIndustries."\"
                          )          B
                       ON A.company_id = B.company_id
                INNER JOIN (
                               SELECT company_id
                                 FROM companies_small_industries
                                WHERE small_industries_id =\"".$smallIndustries."\"
                          )          C
                       ON B.company_id = C.company_id
                INNER JOIN (
                               SELECT company_id
                                 FROM companies_large_job_categories
                                WHERE large_job_category_id =\"".$largeJob."\"
                          )          D
                       ON C.company_id = D.company_id
                INNER JOIN (
                               SELECT company_id
                                 FROM companies_small_job_categories
                                WHERE small_job_category_id =\"".$smallJob."\"
                          )          E
                       ON D.company_id = E.company_id
                INNER JOIN (
                               SELECT company_id
                                 FROM companies_work_location_regions
                                WHERE region_id =\"" .$region."\"
                          )          F
                       ON E.company_id = F.company_id
                INNER JOIN (
                               SELECT company_id
                                 FROM companies_work_locations
                                WHERE prefecture_id =\"".$prefecture."\"
                          )          G
                       ON F.company_id = G.company_id "
        );

        //$users = $datas->toArray();
        $stream = fopen('php://temp', 'r+b');
        foreach ($datas as $user) {
            fputcsv($stream, (array)$user);
        }
        rewind($stream);
        $csv = str_replace(PHP_EOL, "\r\n", stream_get_contents($stream));
        $csv = mb_convert_encoding($csv, 'SJIS-win', 'UTF-8');
        $headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="rikunavi.csv"',
        );
        return Response::make($csv, 200, $headers);

        //return view('rikunavis.confirm', compact('datas'));

    }

}

