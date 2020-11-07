<?php

/*
    csvの読み込み
    ・１行目を飛ばす。
    ・対象パスにcsvが存在するか確認

*/
$row = 1;
if (($handle = fopen("data/testdata.csv", "r")) !== FALSE)
{
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
    {
        $num = count($data);
        echo "$row 行目<br>";
        $row++;
        
        for ($c = 0; $c < $num; $c++)
        {
            echo $data[$c];
        }
        echo "<br>";
    }
    fclose($handle);
}


// csvデータのバリデーション
