<?php

namespace Lexin\Func;

class Csv
{
    /**
     * 根據陣列導出csv文件
     *
     * @param  array  一維索引陣列，第一行可以為title行，該方法將輸出每一行每一列
     * @param  string 文件名
     */
    public static function export(Array $data, $file_name = 'file')
    {
        ob_clean();
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $file_name . '.csv');
        foreach ($data as $key => $value) {
            //關鍵字過濾
            $line_data = array_map(function ($d) {
                return str_replace([',', "\n"], ['，', ' '], $d);
            }, $value);
            $line      = join(',', $line_data);
            echo iconv('utf-8', 'gbk//IGNORE', $line . PHP_EOL);
        }
    }

    /**
     * 讀取全部csv文件內容
     * @param $filePath
     * @return array
     */
    public static function read_csv($filePath)
    {
        $csvData = [];
        if (!file_exists($filePath)) {
            return $csvData;
        }

        $fp = fopen($filePath, 'r');
        if ($fp) {
            while ($lineData = fgetcsv($fp)) {
                $csvData[] = $lineData;
            }
            fclose($fp);
        }

        return $csvData;
    }
}
