<?php

/*
    csvの読み込み
    ・対象パスにcsvが存在するか確認
*/

try 
{
    // csvファイルかチェック
    $fileName = 'data/testdata.csv';
    if (pathinfo($fileName, PATHINFO_EXTENSION) !== 'csv')
    {
        echo 'CSVファイルではありません。ファイル形式を確認してください。';
    }

    $csvData = new SplFileObject($fileName);
    $csvData->setFlags(SplFileObject::READ_CSV);

    //CSVファイル読み込みフラグ設定
    $csvData->setFlags(
        SplFileObject::READ_CSV | SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE
    );

    foreach ($csvData as $line) 
    {
        if ($csvData->key() > 0 && ! $csvData->eof()) 
        {
            $records[] = $line; 
            var_dump($line);
        }
    }
}
catch (Throwable $e) 
{

    echo "Captured Throwable: " . $e->getMessage() . PHP_EOL;
    //エラー処理
    // echo  $e->getMessage();
    //エラーログ
}

// csvデータのバリデーション
