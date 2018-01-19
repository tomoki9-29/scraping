<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\StreamedResponse;
use App\User;
use App\Rikunavi;

use Illuminate\Http\Request;

class RikunavisController extends Controller
{
    //
    public function index()
    {
        $data = Rikunavi::get()->toArray();

        return view('rikunavis.index',compact('data'));

    }

    public function show()
    {
        $rikunavis = Rikunavi::get(["company_name","ceo"])->toArray();

        return view('rikunavis.index', [
            'rikunavis' => $rikunavis,
        ]);

    }

}
