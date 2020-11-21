<?php

/*
    csvの読み込み
*/
ini_set("date.timezone", "Asia/Tokyo");

//エラーログの設定
ini_set("log_errors","on");
ini_set("error_log","./var/debug.log");

//読みこむCSVのパス指定
$filePath = 'data/';

try 
{
    // post以外のアクセスをリダイレクト
    if (empty($_POST))
    {
        header('Location: /index.html');
        exit;
    }
    else
    {
        $filePath = $filePath . $_POST['csvfile'];
    }

    // ファイルが存在するか調べる
    if (!file_exists($filePath))
    {
        echo '対象ファイルが存在しません。';
    }

    // csvファイルか判定
    if (pathinfo($filePath, PATHINFO_EXTENSION) !== 'csv')
    {
        echo 'CSVファイルではありません。ファイル形式を確認してください。';
    }

    $csvData = new SplFileObject($filePath);
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
            // DBへの登録
            // ファイルメモリへの配慮
        }
    }
}
catch (Throwable $e) 
{
    //エラーメッセージ
    echo  $e->getMessage();
    //エラーログ
    error_log($e->getMessage(), 0);
}

// csvデータのバリデーション


