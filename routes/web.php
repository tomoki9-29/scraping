<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/
use App\Rikunavi;

//Route::get('/', 'RikunavisController@index');

Route::get('/contact', 'RikunavisController@getIndex');
Route::post('/contact', 'RikunavisController@postIndex');

//Route::get('/contact', 'RikunavisController@index');
//Route::get('/confirm', 'RikunavisController@GetRequest');

//Route::controller('/contact', 'RikunavisController@csv');

// CRUD
//Route::get('rikunavis/{id}', 'RikunavisController@show');
//Route::post('messages', 'MessagesController@store');
//Route::put('messages/{id}', 'MessagesController@update');
//Route::delete('messages/{id}', 'MessagesController@destroy');

// index: showの補助ページ
//Route::get('rikunavis', 'RikunavisController@index');

// create: 新規作成用のフォームページ
//Route::get('messages/create', 'MessagesController@create');

// edit: 更新用のフォームページ
//Route::get('messages/{id}/edit', 'MessagesController@edit');

//Route::resource('rikunavis', 'RikunavisController');

/*// CSVダウンロード
Route::get('/csv', function() {
    $users = App\Rikunavi::all()->toArray();
    $csvHeader = ["会社ID","会社名", "代表者", "ホームページ", "メールアドレス",  "資本金", "売上高", "連絡先","作成日時","更新日時"];
    array_unshift($users, $csvHeader);
    $stream = fopen('php://temp', 'r+b');
    foreach ($users as $user) {
        fputcsv($stream, $user);
    }
    rewind($stream);
    $csv = str_replace(PHP_EOL, "\r\n", stream_get_contents($stream));
    $csv = mb_convert_encoding($csv, 'SJIS-win', 'UTF-8');
    $headers = array(
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="users.csv"',
    );
    return Response::make($csv, 200, $headers);
});*/

/*// CSVダウンロード
Route::get('/csv', function($datas) {
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
            'Content-Disposition' => 'attachment; filename="users.csv"',
        );
        return Response::make($csv, 200, $headers);
});*/
