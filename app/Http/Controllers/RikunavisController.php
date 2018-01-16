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
        $rikunavis = Rikunavi::get(["company_name"])->toArray();

        return view('rikunavis.index', [
            'rikunavis' => $rikunavis,
        ]);

    }

    public function show()
    {
        $rikunavis = Rikunavi::get(["company_name"])->toArray();

        return view('rikunavis.index', [
            'rikunavis' => $rikunavis,
        ]);

    }

    public function store(Request $request)
    {
        $rikunavis = $request;
        return redirect('rikunavis/show');
    }

}
