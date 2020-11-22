<?php

/*
    csvの読み込み

    文字コードへの対応(Shift_JIS　→　UTF-8　→　Shift_JIS)
    echo '<br><br>';

*/
ini_set("date.timezone", "Asia/Tokyo");

//エラーログの設定
ini_set("log_errors","on");
ini_set("error_log","./var/debug.log");

//読みこむCSVのパス指定
$filePath = 'data/';
// $filePath = 'data/testdata.csv';

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

    // csvファイル判定
    if (pathinfo($filePath, PATHINFO_EXTENSION) !== 'csv')
    {
        echo 'CSVファイルではありません。ファイル形式を確認してください。';
    }

    $csvData = new SplFileObject($filePath);

    //CSVファイル読み込みフラグ設定
    $csvData->setFlags(
        \SplFileObject::READ_CSV |        // CSV 列として行を読み込む
        \SplFileObject::READ_AHEAD |      // 先読み/巻き戻しで読み出す。
        \SplFileObject::SKIP_EMPTY |      // 空行は読み飛ばす
        \SplFileObject::DROP_NEW_LINE     // 行末の改行を読み飛ばす
    );

    $i = 0;

    foreach ($csvData as $line) 
    {
        if ($csvData->key() > 0 && ! $csvData->eof()) 
        {
            // 文字コードを UTF-8 へ変換
            $line = mb_convert_encoding($line, "UTF-8", "UTF-8, JIS, eucjp-win, sjis-win, ASCII");

            $records[] = $line; 

            // csvのバリデーション
            if ($i == 2 )
            {
                var_dump($line);
                $error[] = csvValidation($line);
            }
            // DBへの登録
            // ファイルメモリへの配慮
        }
        $i++;
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
//   返り値は、対象項目とエラー内容
function csvValidation($line)
{

    // 必須項目
    // 全角
    // 半角
    // メールアドレス
    // 文字数（最大値）

}

