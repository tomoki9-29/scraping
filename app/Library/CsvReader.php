<?php

namespace app\Library;

/**
 * CSVファイルの読み込みクラス
 *   CSVファイルの読み込み機能を提供します
 *   ※単純なCSVの読み込みのみ対応とする
 *    「"AAAAAA","BBBBBB","CC,AA,BB",""AAAA",AAAAA"」みたいなもの、
 *    １セルに改行を含むものなどは考慮していない
 */
class CsvReader
{

    /**
     * CSVのファイルパス
     * @var string
     */
    private $csvFilePath;

    /**
     * コンストラクタ
     *
     * @param string $csvFilePath CSVファイルパス
     */
    public function __construct($csvFilePath){
        $this->csvFilePath = $csvFilePath;
    }

    /**
     * CSVのファイルパスプロパティ
     * @return string
     */
    public function csvFilePath(){
        return $this->csvFilePath;
    }

    /**
     *  CSVを１行ごと配列に変換し返す
     *
     * @access public
     * @return array CSVデータの配列
     * @throws RuntimeException ファイルの読み込みができなかった時に例外を返す
     */
    public function convertCsvToArray(){

        try {

            // CSVファイルオブジェクトを作成
            $csvFile = new \SplFileObject($this->csvFilePath);
            $csvFile->setFlags(
                  \SplFileObject::READ_CSV       // CSV列として行を読み込み
                | \SplFileObject::READ_AHEAD     // 先読み/巻き戻しで読み出し
                | \SplFileObject::SKIP_EMPTY     // ファイルの空行を読み飛ばす
                | \SplFileObject::DROP_NEW_LINE  // 行末の改行を読みと飛ばす
            );    

        } catch (\RuntimeException $e) {
            echo "\n【CSVファイルの読み込み時にエラーが発生しました】\n" , $e->getMessage() , "\n\n";
        }

        $csvDataArray = [];
                
        if (empty($csvFile) == FALSE){
                
            // CSVファイルのデータを配列にセット
            foreach ($csvFile as $csvLineData){
                $csvDataArray[] = $csvLineData;
            }
                
        }

        return $csvDataArray;

    }

}
