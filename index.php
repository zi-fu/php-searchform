<?php

/*
    csvの読み込み
    ・対象パスにcsvが存在するか確認

*/
$row = 1;
if (($handle = fopen("data/testdata.csv", "r")) !== FALSE)
{
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
    {
        //１行目をスキップ。
        if ($row !== 1)
        {
            echo "$row 行目<br>";
            
            $num = count($data);
            for ($c = 0; $c < $num; $c++)
            {
                echo $data[$c];
            }
            echo "<br>";
        }
        $row++;
    }
    fclose($handle);
}


// csvデータのバリデーション
